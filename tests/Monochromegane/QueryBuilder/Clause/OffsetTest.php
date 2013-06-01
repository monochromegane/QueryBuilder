<?php
namespace Monochromegane\QueryBuilder\Tests\Clause;

use Monochromegane\QueryBuilder\Clause\Offset; 

class OffsetTest extends \PHPUnit_Framework_TestCase
{
    function testSetOffset()
    {
        $offset = new Offset(); 
        $offset->setOffset(0);
        list($query, $bind) = $offset->build();
        $this->assertEquals(" OFFSET ?", $query);
        $this->assertEquals(array(0), $bind);
    }
}
