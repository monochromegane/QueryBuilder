<?php
namespace Monochromegane\QueryBuilder\Clause;

/**
 * A insert query builder
 */
class Insert
{
    private $table;
    private $params;

    /**
     * Constructor
     *
     * @param string $table The table
     * @param array $params The fields and values
     */
    public function __construct($table, $params)
    {
        $this->table($table);
        $this->set($params);
    }

    /**
     * Set table
     *
     * @param string $table The table
     *
     * @return Insert $this
     */
    public function table($table)
    {
        $this->table  = $table;
        return $this;
    }

    /**
     * Set fields and values
     *
     * @param array $params The fields and values
     *
     * @return Insert $this
     */
    public function set($params)
    {
        $this->params = $params; 
        return $this;
    }

    /**
     * Get insert query and binding values
     *
     * @return array $built(query, bindingValues)
     */
    public function build()
    {
        $columns = array_keys($this->params);
        $bind    = array_values($this->params);

        $placeHolders = join(", ", array_fill(0, count($columns), "?"));
        $columns = join(", ", $columns);
        $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeHolders})";

        return array($query, $bind);
    }
}
