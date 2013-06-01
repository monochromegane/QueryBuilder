<?php
namespace Monochromegane\QueryBuilder\Clause;

/**
 * A group by query builder
 */
class GroupBy
{
    private $query;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->query  = array(); 
    }

    /**
     * Set groups
     *
     * @param array $groups The groups
     */
    public function setGroups($groups)
    {
        if(is_null($groups)) return;
        $this->query = $groups;
    }

    /**
     * Get group by query
     *
     * @return string $query
     */
    public function build()
    {
        if(empty($this->query)) return "";
        return " GROUP BY " . join(", ", $this->query);
    }
}
