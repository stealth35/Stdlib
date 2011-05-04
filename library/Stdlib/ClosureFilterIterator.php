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
class ClosureFilterIterator extends \FilterIterator
{
    /**
     * @var \Closure
     */
    private $_closure;

    /**
     * @param \Iterator $iterator
     * @param \Closure $closure
     */
    public function __construct(\Iterator $iterator, \Closure $closure)
    {
        parent::__construct($iterator);
        $this->_closure = $closure;    
    }

    public function accept()
    {
        $closure = $this->_closure;
        return $closure($this->getInnerIterator()->current());
    }
}