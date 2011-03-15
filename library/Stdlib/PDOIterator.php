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
class PDOIterator implements \Iterator
{
    private $_stmt;
    private $_current;
    private $_position;
    private $_fetch_style;
    private $_cursor_orientation;
    private $_cursor_offset;
    
    /**
     * @param \PDOStatement $stmt
     * @param int $fetch_style optional
     * @param int $cursor_orientation optional
     * @param int $cursor_offset optional
     */
    public function __construct(\PDOStatement $stmt, $fetch_style = null, $cursor_orientation = null, $cursor_offset = null)
    {
        $this->_stmt               = $stmt;
        $this->_fetch_style        = $fetch_style;
        $this->_cursor_orientation = $cursor_orientation;
        $this->_cursor_offset      = $cursor_offset;
        
        $this->_position = -1;
        $this->next();
    }
    
    public function current()
    {
        return $this->_current;
    }

    public function key()
    {
        return $this->_position;
    }

    public function next()
    {
        $this->_current = $this->_stmt->fetch($this->_fetch_style, $this->_cursor_orientation, $this->_cursor_offset);
        ++$this->_position;
    }

    public function rewind()
    {
        return;
    }

    public function valid()
    {
        return $this->_current;
    }

    public function __destruct()
    {
        $this->_stmt->closeCursor();
    }
}