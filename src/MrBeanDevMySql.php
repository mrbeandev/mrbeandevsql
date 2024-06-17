<?php

namespace MrBeanDev;

use PDO;
use PDOException;

class MrBeanDevMySql
{
    private $pdo;
    private $error;

    public function __construct($dbname, $host, $user, $password, $charset = 'utf8', $persistent = true)
    {
        $this->connect($dbname, $host, $user, $password, $charset, $persistent);
    }

    private function connect($dbname, $host, $user, $password, $charset, $persistent)
    {
        if (!$this->pdo) {
            $dsn = "mysql:dbname={$dbname};host={$host};charset={$charset}";
            try {
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => $persistent
                ];
                $this->pdo = new PDO($dsn, $user, $password, $options);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                throw new \Exception($this->error);
            }
        }
    }

    private function prepQuery($query)
    {
        return $this->pdo->prepare($query);
    }

    public function tableExists($tableName)
    {
        try {
            $stmt = $this->prepQuery('SHOW TABLES LIKE ?');
            $stmt->execute([$tableName]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function execute($query, $values = [])
    {
        try {
            $stmt = $this->prepQuery($query);
            $stmt->execute((array)$values);
            return $stmt;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function count($query, $values = [])
    {
        try {
            $stmt = $this->prepQuery($query);
            $stmt->execute((array)$values);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function fetch($query, $values = [])
    {
        try {
            $stmt = $this->execute($query, $values);
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function fetchAll($query, $values = [], $key = null)
    {
        try {
            $stmt = $this->execute($query, $values);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($key !== null && isset($results[0][$key])) {
                $keyedResults = [];
                foreach ($results as $result) {
                    $keyedResults[$result[$key]] = $result;
                }
                return $keyedResults;
            }

            return $results;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getLastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function getError()
    {
        return $this->error;
    }
}
