# MrBeanDevSQL

MrBeanDevSQL is a simple MySQL PDO wrapper for PHP applications.

## Installation

Install via Composer:

```sh
composer require mrbeandev/mrbeandevsql
```

## Usage

### Basic Usage

```php
require 'vendor/autoload.php';

use MrBeanDev\MrBeanDevMySql;

$db = new MrBeanDevMySql('database_name', 'host', 'username', 'password');

// Example usage
$result = $db->fetch("SELECT * FROM users WHERE id = ?", [1]);
print_r($result);
```

### Methods

- **tableExists($tableName)**: Checks if a table exists in the database.
- **execute($query, $values = [])**: Executes a query with optional bound values.
- **count($query, $values = [])**: Returns the number of rows affected by the query.
- **fetch($query, $values = [])**: Fetches a single row from the database.
- **fetchAll($query, $values = [], $key = null)**: Fetches all rows from the database, optionally keyed by a specified column.
- **getLastInsertId()**: Returns the ID of the last inserted row.
- **getError()**: Returns the last error message.

### Examples

#### Direct Queries

To perform direct queries where you don't need to return any results (such as update, insert, etc.):

```php
$db->execute("UPDATE customers SET email = 'newemail@domain.com' WHERE username = 'a1phanumeric'");
```

#### Using Prepared Statements

To utilize prepared statements, pass the values as an array:

```php
$db->execute("UPDATE customers SET email = ? WHERE username = ?", ['newemail@domain.com', 'a1phanumeric']);
```

### Fetching Rows

#### Fetching a Single Row

To perform select queries and fetch a single row:

```php
$user = $db->fetch("SELECT * FROM users WHERE id = ?", $id);
print_r($user);
```

#### Fetching Multiple Rows

To perform select queries and fetch multiple rows:

```php
$counties = $db->fetchAll("SELECT * FROM counties");
print_r($counties);
```

#### Fetching Multiple Rows with Custom Keys

To fetch multiple rows and use a column as the key for the returned array:

```php
$counties = $db->fetchAll("SELECT * FROM counties", null, 'county');
print_r($counties);
```

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Authors

- **MrbeanDev** - *Initial work* - [mrbeandev](https://github.com/mrbeandev)
