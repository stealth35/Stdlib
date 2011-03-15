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
class ZipIterator implements \Iterator
{
    private $_resource;
    private $_filename;
    private $_current;
    private $_position;

    /**
     * @param string $filename
     * @throws \RuntimeException
     *
     * @todo Improve errors handling
     */
    public function __construct($filename)
    {
        $this->_filename = $filename;
        $this->_resource = zip_open($this->_filename);

        if(false === is_resource($this->_resource))
        {
            throw new \RuntimeException('zip error', $this->_resource);
        }

        $this->_position = -1;
    }

    public function current()
    {
        if($this->_position === -1)
        {
            $this->next();
        }

        return $this->_current;
    }

    public function key()
    {
        return $this->_position;
    }

    public function next()
    {
        $this->_current = zip_read($this->_resource);
        ++$this->_position;
    }

    public function rewind()
    {
        $this->__destruct();
        $this->__construct($this->_filename);
    }

    public function valid()
    {
        return is_resource($this->_current);
    }

    public function __destruct()
    {
        zip_close($this->_resource);
    }
}