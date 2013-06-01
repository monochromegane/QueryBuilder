<?php
namespace Monochromegane\QueryBuilder\Clause;

use Monochromegane\QueryBuilder\Clause\Condition;

/**
 * A join query builder
 */
class Join
{
    private $type;
    private $table;
    private $on;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->on = new Condition("ON");
    }

    /**
     * Add left join clause
     *
     * @param string $table The table
     * @param array $conditions The conditions
     */
    public function leftJoin($table, $conditions = null)
    {
        $this->setJoin("LEFT", $table, $conditions); 
    }

    /**
     * Add inner join clause
     *
     * @param string $table The table
     * @param array $conditions The conditions
     */
    public function innerJoin($table, $conditions = null)
    {
        $this->setJoin("INNER", $table, $conditions); 
    }

    /**
     * Add join clause
     *
     * @param string $type The join type(LEFT|INNER)
     * @param string $table The table
     * @param array $conditions The conditions
     */
    private function setJoin($type, $table, $conditions)
    {
        $this->type  = $type;
        $this->table = $table;
        $this->on->setConditions($conditions);
    }

    /**
     * Get join query and binding values
     *
     * @return array $built(query, bindingValues)
     */
    public function build()
    {
        $query = " {$this->type} JOIN {$this->table}";
        list($on, $bind) = $this->on->build();
        return array(
            $query . $on,
            $bind
        );
    }
}
