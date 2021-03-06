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
class ReverseIterator implements \IteratorAggregate
{
	/**
	 * @var \Traversable
	 */
    private $_iterator;
    
    /**
     * @var boolean
     */
    private $_preserve_keys;

    /**
     * @param \Traversable $iterator
     * @param boolean $preserve_keys
     */
    public function __construct(\Traversable $iterator, $preserve_keys = false)
    {
        $this->_iterator = $iterator;
        $this->_preserve_keys = $preserve_keys;
    }

    /**
     * @see IteratorAggregate::getIterator()
     */
    public function getIterator()
    {
        $array = iterator_to_array($this->_iterator, $this->_preserve_keys);
        $reverse = array_reverse($array, $this->_preserve_keys);

        return new \ArrayIterator($reverse);
    }
}