<?php
namespace Monochromegane\QueryBuilder\Tests\Clause;

use Monochromegane\QueryBuilder\Clause\Condition; 

class ConditionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $condition = new Condition("WHERE");
        $condition->setConditions(array("column1" => "value1"));
        list($query, $bind) = $condition->build();
        $this->assertEquals(" WHERE column1 = ?", $query); 

        $condition = new Condition("ON");
        $condition->setConditions(array("column1" => "value1"));
        list($query, $bind) = $condition->build();
        $this->assertEquals(" ON column1 = ?", $query); 
    }

    public function testAddExpression()
    {
        $where = new Condition("WHERE");
        list($query, $bind) = $where->build();
        $this->assertEquals("", $query);
        $this->assertEquals(array(), $bind);

        list($query, $bind) = $this->buildWhere(0, "column = value");
        $this->assertEquals(" WHERE column = value", $query);
        $this->assertEquals(array(), $bind);

        list($query, $bind) = $this->buildWhere("column", null);
        $this->assertEquals(" WHERE column IS NULL", $query);
        $this->assertEquals(array(), $bind);

        list($query, $bind) = $this->buildWhere("column1 = ?", "value1");
        $this->assertEquals(" WHERE column1 = ?", $query);
        $this->assertEquals(array("value1"), $bind);

        list($query, $bind) = $this->buildWhere("column1 = ? OR column2 = ?", array("value1", "value2"));
        $this->assertEquals(" WHERE column1 = ? OR column2 = ?", $query);
        $this->assertEquals(array("value1", "value2"), $bind);

        list($query, $bind) = $this->buildWhere("column", "value");
        $this->assertEquals(" WHERE column = ?", $query);
        $this->assertEquals(array("value"), $bind);

        list($query, $bind) = $this->buildWhere("column", array("<=" => "value"));
        $this->assertEquals(" WHERE column <= ?", $query);
        $this->assertEquals(array("value"), $bind);

    }

    private function buildWhere($column, $value)
    {
        $where = new Condition("WHERE");
        $where->addExpression($column, $value);
        return list($query, $bind) = $where->build();
    }


    public function testSetConditions()
    {
        $condition = new Condition("WHERE");
        $params = array(
            "column1" => null,
            "column2" => "value2",
            "column3" => array("<=" => "value3"),
            "column4-1 = ? OR column4-2 = ?" => array("value4-1", "value4-2"),
            "column5 = value5"
        );
        $condition->setConditions($params);
        list($query, $bind) = $condition->build();
        $this->assertEquals(" WHERE column1 IS NULL AND column2 = ? AND column3 <= ? AND column4-1 = ? OR column4-2 = ? AND column5 = value5", $query);
        $this->assertEquals(array("value2", "value3", "value4-1", "value4-2"), $bind);
    }
}
