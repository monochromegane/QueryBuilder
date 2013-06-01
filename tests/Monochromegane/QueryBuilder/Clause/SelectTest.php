<?php
namespace Monochromegane\QueryBuilder\Tests\Clause;

use Monochromegane\QueryBuilder\Clause\Select; 

class SelectTest extends \PHPUnit_Framework_TestCase
{
    private $select;

    public function setup()
    {
        $this->select = new Select("table", array("column1", "column2")); 
    }

    public function testBuild()
    {
        list($query, $bind) = $this->select->build();
        $this->assertEquals("SELECT column1, column2 FROM table", $query);
        $this->assertEquals(array(), $bind);
    }

    public function testWhere()
    {
        $this->select->where(array(
            "column1" => null,
            "column2" => "value2",
            "column3" => array("<=" => "value3")
        ));
        list($query, $bind) = $this->select->build();

        $this->assertEquals("SELECT column1, column2 FROM table WHERE column1 IS NULL AND column2 = ? AND column3 <= ?", $query);
        $this->assertEquals(array("value2", "value3"), $bind);
    }

    public function testInnerJoin()
    {
        $select = new Select("table", array("column1", "column2"));
        $select->innerJoin("table2");
        list($query, $bind) = $select->build();
        $this->assertEquals("SELECT column1, column2 FROM table INNER JOIN table2", $query);
        $this->assertEquals(array(), $bind);

        $select = new Select("table", array("column1", "column2"));
        $select->innerJoin("table2", array("column1 = column2"));
        list($query, $bind) = $select->build();
        $this->assertEquals("SELECT column1, column2 FROM table INNER JOIN table2 ON column1 = column2", $query);
        $this->assertEquals(array(), $bind);
    }

    public function testLeftJoin()
    {
        $select = new Select("table", array("column1", "column2"));
        $select->leftJoin("table2");
        list($query, $bind) = $select->build();
        $this->assertEquals("SELECT column1, column2 FROM table LEFT JOIN table2", $query);
        $this->assertEquals(array(), $bind);

        $select = new Select("table", array("column1", "column2"));
        $select->leftJoin("table2", array("column1 = column2"));
        list($query, $bind) = $select->build();
        $this->assertEquals("SELECT column1, column2 FROM table LEFT JOIN table2 ON column1 = column2", $query);
        $this->assertEquals(array(), $bind);
    }

    public function testOrderBy()
    {
        $this->select->orderBy(array("column1", "column2" => "ASC"));
        list($query, $bind) = $this->select->build();
        $this->assertEquals("SELECT column1, column2 FROM table ORDER BY column1, column2 ASC", $query);
        $this->assertEquals(array(), $bind);
    }

    public function testGroupBy()
    {
        $this->select->groupBy(array("column1", "column2"));
        list($query, $bind) = $this->select->build();
        $this->assertEquals("SELECT column1, column2 FROM table GROUP BY column1, column2", $query);
        $this->assertEquals(array(), $bind);
    }

    public function testLimit()
    {
        $this->select->limit(20);
        list($query, $bind) = $this->select->build();
        $this->assertEquals("SELECT column1, column2 FROM table LIMIT ? OFFSET ?", $query);
        $this->assertEquals(array(20, 0), $bind);

        $this->select->limit(20, 5);
        list($query, $bind) = $this->select->build();
        $this->assertEquals("SELECT column1, column2 FROM table LIMIT ? OFFSET ?", $query);
        $this->assertEquals(array(20, 5), $bind);
    }

    public function testMethodChain()
    {
        list($query, $bind) = $this->select
            ->where(array("column1" => "value1"))
            ->innerJoin("table2", array("table.column2 = table2.column2"))
            ->leftJoin("table3", array("table2.column3 = table3.column3"))
            ->groupBy(array("column4"))
            ->orderBy(array("column5"))
            ->limit(20)
            ->build();

        $this->assertEquals("SELECT column1, column2 FROM table INNER JOIN table2 ON table.column2 = table2.column2 LEFT JOIN table3 ON table2.column3 = table3.column3 WHERE column1 = ? GROUP BY column4 ORDER BY column5 LIMIT ? OFFSET ?", $query);
        $this->assertEquals(array("value1", 20, 0), $bind);
    }
}
