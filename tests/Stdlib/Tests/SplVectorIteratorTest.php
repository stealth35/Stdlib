<?php
namespace Stdlib\Tests;

use Stdlib\SplVectorIterator;

class SplVectorIteratorTest extends \PHPUnit_Framework_TestCase
{
    protected $vector;

    protected function setUp()
    {
        $this->vector = new SplVectorIterator('string');
    }

    protected function tearDown()
    {
        $this->vector = null;
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testAppendInvalid()
    {
    	$this->vector->append(1);
    }
}