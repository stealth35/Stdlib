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
    /**
     * @var string
     */
    private $_type;

    /**
     * @param string $type
     */
    public function __construct($type)
    {        
        $this->_type = $type;
    }

    /**
     * @see ArrayIterator::append()
     */
    public function append($value)
    {
        $this->_inspect($value);
        parent::append($value);
    }

    /**
     * @see ArrayIterator::offsetSet()
     */
    public function offsetSet($index, $newval)
    {
        $this->_inspect($newval);
        parent::offsetSet($index, $newval);
    }

    /**
     * @param string $value
     * @throws \UnexpectedValueException
     */
    private function _inspect($value)
    {
        if($this->_type !== ($type = gettype($value)))
        {
            $message = sprintf('expects value to be %s, %s given', $this->_type, $type);
            throw new \UnexpectedValueException($message);
        }
    }
}