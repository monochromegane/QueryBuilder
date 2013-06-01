<?php
namespace Monochromegane\QueryBuilder\Tests\Clause;

use Monochromegane\QueryBuilder\Clause\Delete; 

class DeleteTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $delete = new Delete("table");
        list($query, $bind) = $delete->build();
        $this->assertEquals("DELETE FROM table", $query);
        $this->assertEquals(array(), $bind);    

        $delete = new Delete("table");
        $delete->where(array("column1" => "value1", "column2" => "value2"));
        list($query, $bind) = $delete->build();
        $this->assertEquals("DELETE FROM table WHERE column1 = ? AND column2 = ?", $query);
        $this->assertEquals(array("value1", "value2"), $bind);
    }

    public function testTable()
    {
        $delete = new Delete("table");
        list($query, $bind) = $delete->table("tableA")->build();
        $this->assertEquals("DELETE FROM tableA", $query);
        $this->assertEquals(array(), $bind);    
    }

    public function testWhere()
    {
        $delete = new Delete("table");
        list($query, $bind) = $delete->where(array("columnA" => "valueA"))->build();
        $this->assertEquals("DELETE FROM table WHERE columnA = ?", $query);
        $this->assertEquals(array("valueA"), $bind);
    }

}
