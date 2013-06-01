<?php
namespace Monochromegane\QueryBuilder;

use Monochromegane\QueryBuilder\Clause\Select;
use Monochromegane\QueryBuilder\Clause\Insert;
use Monochromegane\QueryBuilder\Clause\Update;
use Monochromegane\QueryBuilder\Clause\Delete;

/**
 * A query builder factory
 */
class Query
{
    /**
     * Get select query builder
     *
     * @param string $table The table
     * @param array $columns The columns
     *
     * @return Select $select
     */
    public static function select($table, $columns)
    {
        return new Select($table, $columns); 
    }

    /**
     * Get insert query builder
     *
     * @param string $table The table
     * @param array $params The fields and values
     *
     * @return Insert $insert
     */
    public static function insert($table, $params)
    {
        return new Insert($table, $params); 
    }

    /**
     * Get update query builder
     *
     * @param string $table The table
     * @param array $params The fields and values
     *
     * @return Update $update
     */
    public static function update($table, $params)
    {
        return new Update($table, $params); 
    }

    /**
     * Get delete query builder
     *
     * @param string $table The table
     *
     * @return Delete $delete
     */
    public static function delete($table)
    {
        return new Delete($table); 
    }
}
