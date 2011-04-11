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
class PDOIterator extends \NoRewindIterator implements \IteratorAggregate, \Countable
{
    private $_stmt;

    /**
     * @param \PDOStatement $stmt
     */
    public function __construct(\PDOStatement $stmt)
    {
        $this->_stmt = $stmt;
    }

    public function getIterator()
    {
        return new IteratorIterator($this->_stmt);
    }
    
    public function count()
    {
        return $this->_stmt->rowCount();
    }
}