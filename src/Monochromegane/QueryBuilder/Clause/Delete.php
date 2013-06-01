<?php
namespace Monochromegane\QueryBuilder\Clause;

use Monochromegane\QueryBuilder\Clause\Condition;

/**
 * A delete query builder
 */
class Delete 
{
    private $table;
    private $where;

    /**
     * Constructor
     *
     * @param string $table The table
     */
    public function __construct($table)
    {
        $this->table($table);
        $this->where = new Condition("WHERE");
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
        $this->table = $table; 
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
     * Get delete query and binding values
     *
     * @return array $built(query, bindingValues)
     */
    public function build()
    {
        $query = "DELETE FROM {$this->table}";
        list($whereQuery, $whereBind) = $this->where->build();
        return array(
            $query . $whereQuery,
            $whereBind 
        );
    }
}
