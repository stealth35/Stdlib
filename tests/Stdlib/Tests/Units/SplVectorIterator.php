<?php
namespace Stdlib\tests\units;

use \mageekguy\atoum;

class SplVectorIterator extends atoum\test
{
    public function testAppendValid()
    {
        $vector = new \Stdlib\SplVectorIterator('string');

        $this->assert
             ->exception($vector->append(1))
             ->isInstanceOf('\UnexpectedValueException');
    }
}