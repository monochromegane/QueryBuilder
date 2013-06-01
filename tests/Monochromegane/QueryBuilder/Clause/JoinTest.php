<?php
namespace Monochromegane\QueryBuilder\Tests\Clause;

use Monochromegane\QueryBuilder\Clause\Join; 

class JoinTest extends \PHPUnit_Framework_TestCase
{
    public function testLeftJoin()
    {
        $join = new Join();
        $join->leftJoin("table");
        list($query, $bind) = $join->build();
        $this->assertEquals(" LEFT JOIN table", $query);
        $this->assertEquals(array(), $bind);

        $join = new Join();
        $join->leftJoin("table", array("column1 = column2"));
        list($query, $bind) = $join->build();
        $this->assertEquals(" LEFT JOIN table ON column1 = column2", $query);
        $this->assertEquals(array(), $bind);
    }

    public function testInnerJoin()
    {
        $join = new Join();
        $join->innerJoin("table");
        list($query, $bind) = $join->build();
        $this->assertEquals(" INNER JOIN table", $query);
        $this->assertEquals(array(), $bind);

        $join = new Join();
        $join->innerJoin("table", array("column1 = column2"));
        list($query, $bind) = $join->build();
        $this->assertEquals(" INNER JOIN table ON column1 = column2", $query);
        $this->assertEquals(array(), $bind);
    }
}
