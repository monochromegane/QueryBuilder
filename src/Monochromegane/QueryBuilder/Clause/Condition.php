<?php
namespace Monochromegane\QueryBuilder\Clause;

/**
 * A condition query builder
 */
class Condition
{
    private $phrase;
    private $query;
    private $bind;

    /**
     * Constructor
     *
     * @param string $phrase The phrase(WHERE|ON)
     */
    public function __construct($phrase)
    {
        $this->phrase = $phrase;
        $this->query  = array();
        $this->bind   = array();
    }

    /**
     * Set conditions
     *
     * @param array $conditions The conditions
     */
    public function setConditions($conditions)
    {
        if(is_null($conditions)) return;
        foreach($conditions as $column => $value){
            $this->addExpression($column, $value);
        }
    }

    /**
     * Add condition
     *
     * @param string $column The column
     * @param mixed  $value  The value
     */
    public function addExpression($column, $value)
    {
        if(is_int($column)){
            $this->query[] = $value;
        }elseif(is_null($value)){
            $this->query[] = "{$column} IS NULL";
        }elseif(strpos($column, "?") !== false){
            $this->query[] = $column;
            if(is_array($value)){
                $this->bind = array_merge($this->bind, $value);
            }else{
                $this->bind[] = $value;
            }
        }elseif(is_array($value)){
            $operators = array_keys($value);
            $value = array_values($value);
            $this->query[] = "{$column} {$operators[0]} ?";
            $this->bind[] = $value[0];
        }else{
            $this->query[] = "{$column} = ?";
            $this->bind[] = $value;
        }     
    }

    /**
     * Get condition query and binding values
     *
     * @return array $built(query, bindingValues)
     */
    public function build()
    {
        if(empty($this->query)) return array("", array());
        return array(
            " {$this->phrase} " . join(" AND ", $this->query),
            $this->bind
        );
    }
}

