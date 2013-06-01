<?php
namespace Monochromegane\QueryBuilder\Clause;

/**
 * A limit query builder
 */
class Limit
{
    private $limit;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->limit = null;
    }

    /**
     * Set limit clause
     *
     * @param integer $limit The limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * Get limit query and binding values
     *
     * @return array $built(query, bindingValues)
     */
    public function build()
    {
        if(is_null($this->limit)) return array("", array());
        return array(
            " LIMIT ?",
            array($this->limit)
        );
    }
}
