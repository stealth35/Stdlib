<?php
namespace Stdlib;

class ZipIterator implements \Iterator
{
    private $_resource;
    private $_filename;
    private $_current;
    private $_position;

    public function __construct($filename)
    {
        $this->_filename = $filename;
        $this->_resource = zip_open($this->_filename);

        if(false === is_resource($this->_resource))
        {
            throw new \RuntimeException('zip error', $this->_resource);
        }

        $this->_current = zip_read($this->_resource);
        $this->position = 0;
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
        $this->_current = zip_read($this->_resource);
        $this->_position++;

        return $this->_current;
    }

    public function rewind()
    {
        zip_close($this->_resource);

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