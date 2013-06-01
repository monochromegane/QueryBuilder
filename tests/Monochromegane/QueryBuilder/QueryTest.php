<?php
namespace Monochromegane\QueryBuilder\Tests;

use Monochromegane\QueryBuilder\Query; 

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function testSelect()
    {
        $select = Query::select("table", array("column1", "column2"));
        $this->assertInstanceOf("Monochromegane\\QueryBuilder\\Clause\\Select", $select);
    }

    public function testInsert()
    {
        $insert = Query::insert("table", array("column1" => "value1"));
        $this->assertInstanceOf("Monochromegane\\QueryBuilder\\Clause\\Insert", $insert);
    }

    public function testUpdate()
    {
        $update = Query::update("table", array("column1" => "value1"));
        $this->assertInstanceOf("Monochromegane\\QueryBuilder\\Clause\\Update", $update);
    }

    public function testDelete()
    {
        $delete = Query::delete("table");
        $this->assertInstanceOf("Monochromegane\\QueryBuilder\\Clause\\Delete", $delete);
    }
}
