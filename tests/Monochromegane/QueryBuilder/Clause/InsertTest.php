<?php
namespace Monochromegane\QueryBuilder\Tests\Clause;

use Monochromegane\QueryBuilder\Clause\Insert; 

class InsertTest extends \PHPUnit_Framework_TestCase
{
    private $insert;

    public function setup()
    {
        parent::setup(); 
        $this->insert = new Insert("table", array("column1" => "value1", "column2" => "value2"));
    }

    public function testConstruct()
    {
        list($query, $bind) = $this->insert->build();
        $this->assertEquals("INSERT INTO table (column1, column2) VALUES (?, ?)", $query);
        $this->assertEquals(array("value1", "value2"), $bind);
    }

    public function testSet()
    {
        list($query, $bind) = $this->insert->table("tableA")->build();
        $this->assertEquals("INSERT INTO tableA (column1, column2) VALUES (?, ?)", $query);
        $this->assertEquals(array("value1", "value2"), $bind);
    }

    public function testTable()
    {
        list($query, $bind) = $this->insert->set(array("columnA" => "valueA"))->build();
        $this->assertEquals("INSERT INTO table (columnA) VALUES (?)", $query);
        $this->assertEquals(array("valueA"), $bind);
    }

}
