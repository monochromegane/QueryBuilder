<?php
namespace Monochromegane\QueryBuilder\Tests\Clause;

use Monochromegane\QueryBuilder\Clause\Update; 

class UpdateTest extends \PHPUnit_Framework_TestCase
{
    function testBuild(){
        $update = new Update("table", array("column1" => "value1", "column2" => "value2"));
        list($query, $bind) = $update->build();
        $this->assertEquals("UPDATE table SET column1 = ?, column2 = ?", $query);
        $this->assertEquals(array("value1", "value2"), $bind);

        $update = new Update("table", array("column1" => "value1", "column2" => "value2"));
        $update->where(array("column3" => "value3", "column4" => "value4"));
        list($query, $bind) = $update->build();
        $this->assertEquals("UPDATE table SET column1 = ?, column2 = ? WHERE column3 = ? AND column4 = ?", $query);
        $this->assertEquals(array("value1", "value2", "value3", "value4"), $bind);
    }

    public function testTable()
    {
        $update = new Update("table", array("column1" => "value1"));
        list($query, $bind) = $update->table("tableA")->build();
        $this->assertEquals("UPDATE tableA SET column1 = ?", $query);
        $this->assertEquals(array("value1"), $bind);
    }

    public function testSet()
    {
        $update = new Update("table", array("column1" => "value1"));
        list($query, $bind) = $update->set(array("columnA" => "valueA"))->build();
        $this->assertEquals("UPDATE table SET columnA = ?", $query);
        $this->assertEquals(array("valueA"), $bind);
    }

    public function testWhere()
    {
        $update = new Update("table", array("column1" => "value1"));
        list($query, $bind) = $update->where(array("columnA" => "valueA"))->build();
        $this->assertEquals("UPDATE table SET column1 = ? WHERE columnA = ?", $query);
        $this->assertEquals(array("value1", "valueA"), $bind);
    }
}
