<?php
namespace Monochromegane\QueryBuilder\Tests\Clause;

use Monochromegane\QueryBuilder\Clause\GroupBy; 

class GroupByTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGroups()
    {
        $groupBy = new GroupBy();
        $params = array(
            "column1",
            "column2"
        );
        $groupBy->setGroups($params);
        $query = $groupBy->build();
        $this->assertEquals(" GROUP BY column1, column2", $query);
    }
}
