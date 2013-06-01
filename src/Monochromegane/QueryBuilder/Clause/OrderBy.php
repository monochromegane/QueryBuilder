<?php
namespace Monochromegane\QueryBuilder\Clause;

/**
 * A order by query builder
 */
class OrderBy
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
     * Set orders
     *
     * @param array $orders The orders
     */
    public function setOrders($orders)
    {
        if(is_null($orders)) return;
        foreach($orders as $column => $order){
            $this->addOrder($column, $order);
        }
    }

    /**
     * Add order
     *
     * @param string $column The column
     * @param string $order  The order(ASC|DESC)
     */
    public function addOrder($column, $order)
    {
        if(is_int($column)){
            $this->query[] = $order;
        }else{
            $this->query[] = "{$column} {$order}";
        }
    }

    /**
     * Get order by query
     *
     * @return string $query
     */
    public function build()
    {
        if(empty($this->query)) return "";
        return " ORDER BY " . join(", ", $this->query);
    }
}
