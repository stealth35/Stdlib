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
class CallbackFilterIterator extends \FilterIterator
{
    /**
     * @var mixed
     */
    private $_callback;

    /**
     * @param \Iterator $iterator
     * @param mixed $callback
     */
    public function __construct(\Iterator $iterator, $callback)
    {
        parent::__construct($iterator);
        $this->_callback = $callback;    
    }

    public function accept()
    {
        return call_user_func($this->_callback, $this->getInnerIterator()->current());
    }
}