<?php
namespace Monochromegane\QueryBuilder\Tests\Clause;

use Monochromegane\QueryBuilder\Clause\Limit; 

class LimitTest extends \PHPUnit_Framework_TestCase
{
    function testSetLimit()
    {
        $limit = new Limit(); 
        $limit->setLimit(0);
        list($query, $bind) = $limit->build();
        $this->assertEquals(" LIMIT ?", $query);
        $this->assertEquals(array(0), $bind);
    }
}
