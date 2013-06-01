<?php
namespace Monochromegane\QueryBuilder\Clause;

use Monochromegane\QueryBuilder\Clause\Condition;

/**
 * A update query builder
 */
class Update 
{
    private $table;
    private $params;
    private $where;

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
        $this->where = new Condition("WHERE");
    }

    /**
     * Set table
     *
     * @param string $table The table
     *
     * @return Update $this
     */
    public function table($table)
    {
        $this->table = $table; 
        return $this;
    }

    /**
     * Set fields and values
     *
     * @param array $params The fields and values
     *
     * @return Update $this
     */
    public function set($params)
    {
        $this->params = $params; 
        return $this;
    }

    /**
     * Set conditions
     *
     * @param array $conditions The conditions
     *
     * @return Update $this
     */
    public function where($conditions)
    {
        $this->where->setConditions($conditions);
        return $this;
    }

    /**
     * Get update query and binding values
     *
     * @return array $built(query, bindingValues)
     */
    public function build()
    {
        $columns = array_keys($this->params);
        $bind = array_values($this->params);

        $sets = array();
        foreach($columns as $column){
            $sets[] = "{$column} = ?";
        }
        $sets = join(", ", $sets);

        $query = "UPDATE {$this->table} SET {$sets}";

        list($whereQuery, $whereBind) = $this->where->build();
        return array(
            $query . $whereQuery,
            array_merge($bind, $whereBind)
        );
    }
}
