<?php
namespace Monochromegane\QueryBuilder\Tests\Clause;

use Monochromegane\QueryBuilder\Clause\OrderBy; 

class OrderByTest extends \PHPUnit_Framework_TestCase
{
    public function testAddOrder()
    {
        $orderBy = new OrderBy();
        $query = $orderBy->build();
        $this->assertEquals("", $query);

        $orderBy = new OrderBy();
        $orderBy->addOrder(0, "column1");
        $query = $orderBy->build();
        $this->assertEquals(" ORDER BY column1", $query);

        $orderBy = new OrderBy();
        $orderBy->addOrder("column1", "ASC");
        $query = $orderBy->build();
        $this->assertEquals(" ORDER BY column1 ASC", $query);
    }

    public function testSetOrders()
    {
        $orderBy = new OrderBy();
        $params = array(
            "column1",
            "column2" => "ASC",
            "column3"
        );
        $orderBy->setOrders($params);
        $query = $orderBy->build();
        $this->assertEquals(" ORDER BY column1, column2 ASC, column3", $query);
    }
}
