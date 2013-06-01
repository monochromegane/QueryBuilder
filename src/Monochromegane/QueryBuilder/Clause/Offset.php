<?php
namespace Monochromegane\QueryBuilder\Clause;

/**
 * A offset query builder
 */
class Offset
{
    private $offset;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->offset = null;
    }

    /**
     * Set offset clause
     *
     * @param integer $offset The offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * Get offset query and binding values
     *
     * @return array $built(query, bindingValues)
     */
    public function build()
    {
        if(is_null($this->offset)) return array("", array());
        return array(
            " OFFSET ?",
            array($this->offset)
        );
    }
}
