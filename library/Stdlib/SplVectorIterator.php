<?php
/**
 * @namespace
 */
namespace Stdlib;

/**
 * @category Stdlib
 * @package  Stdlib
 * @author   stealth35
 */
class SplVectorIterator extends \ArrayIterator
{    
    private $_type;

    public function __construct($type)
    {        
        $this->_type = $type;
    }

    public function append($value)
    {
        $this->_inspect($value);
        parent::append($value);
    }

    public function offsetSet($index, $newval)
    {
        $this->_inspect($newval);
        parent::offsetSet($index, $newval);
    }

    private function _inspect($value)
    {
        if($this->_type !== ($type = gettype($value)))
        {
            $message = sprintf('expects value to be %s, %s given', $this->_type, $type);
            throw new \UnexpectedValueException($message);
        }
    }
}