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
class PDOIterator implements \IteratorAggregate, \Countable
{
    /**
     * @var \PDOStatement
     */
    private $_stmt;

    /**
     * @param \PDOStatement $stmt
     */
    public function __construct(\PDOStatement $stmt)
    {
        $this->_stmt = $stmt;
    }

  	/**
  	 * @see \IteratorAggregate::getIterator()
  	 */
    public function getIterator()
    {
        return new IteratorIterator($this->_stmt);
    }
    
    /**
     * @see \Countable::count()
     */
    public function count()
    {
        return $this->_stmt->rowCount();
    }
}