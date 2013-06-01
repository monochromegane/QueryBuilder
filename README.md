QueryBuilder
===
`QueryBuilder` is very simple query builder. It helps building query and binding values.

# Install

```console
composer.phar require monochromegane/query-builder:dev-master
```

# Usage

## Get query and binding values

Binding value format like a PDO format. i.e `column = ?`

```php
use Monochromegane\QueryBuilder\Query; 

// SELECT
list($query, $bind) = Query::select("table", array("column1", "column2"));
                    ->where(array("column1" => "value1"));
                    ->build();

// INSERT
list($query, $bind) = Query::insert("table", array("column1" => "value1"))
                    ->build();

// UPDATE
list($query, $bind) = Query::update("table", array("column1" => "value1"))
                    ->where(array("column1" => "value1"));
                    ->build();

// DELETE
list($query, $bind) = Query::delete("table")
                    ->where(array("column1" => "value1"));
                    ->build();

// Execute
$dbh  = new PDO($dsn, $user, $password);
$stmt = $dbh->prepare($query);
$stmt->execute($bind);
```

## Set Conditions

```php
$conditions = array(
    // column1 IS NULL
    "column1" => null,
    // column2 = ? (and bind "value2")
    "column2" => "value2",
    // column3 <= ? (and bind "value3")
    "column3" => array("<=" => "value3"),
    // column4-1 = ? OR column4-2 ? (and bind "value4-1", "value4-2")
    "column4-1 = ? OR column4-2 = ?" => array("value4-1", "value4-2"),
    // column5 = value5
    "column5 = value5"
);

list($query, $bind) = Query::select("table", array("column1", "column2"));
                    ->where($conditions);
                    ->build();
```

## Other clauses

Select query builder supports the following clauses.

* inner join
* left join
* group by
* order by
* limit and offset

```php
list($query, $bind) = Query::select("table", array("column1", "column2"));
                    ->where(array("column1" => "value1"))
                    ->innerJoin("table2", array("table.column2 = table2.column2"))
                    ->leftJoin("table3", array("table2.column3 = table3.column3"))
                    ->groupBy(array("column4"))
                    ->orderBy(array("column5"))
                    ->limit(20)
                    ->build();

$query // "SELECT column1, column2 FROM table INNER JOIN table2 ON table.column2 = table2.column2 LEFT JOIN table3 ON table2.column3 = table3.column3 WHERE column1 = ? GROUP BY column4 ORDER BY column5 LIMIT ? OFFSET ?"

$bind // array("value1", 20, 0) 
```

# Test

```console
cd Monochromegane/QueryBuilder/tests
composer.phar install --dev
../vendor/bin/phpunit
```

