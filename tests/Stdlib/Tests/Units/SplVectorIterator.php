<?php
namespace Stdlib\tests\units;

use \mageekguy\atoum;

class SplVectorIterator extends atoum\test
{
    protected $vector;

    protected function setUp()
    {
        $this->vector = new \Stdlib\SplVectorIterator('string');

        return $this;
    }

    protected function tearDown()
    {
        $this->vector = null;

        return $this;
    }

    public function testAppendInvalid()
    {
        $this->assert
             ->exception($this->vector->append(1))
             ->isInstanceOf('\UnexpectedValueException');
    }
}