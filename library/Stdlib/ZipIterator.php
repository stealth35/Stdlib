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
class ZipIterator implements \SeekableIterator
{
    private $_zip;
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
        $this->_zip = new \ZipArchive();
        
        $ret = $this->_zip->open($this->_filename);
		
        if(true !== $ret)
        {            
            $message = sprintf('zip error', $ret);
            throw new \RuntimeException($message);
        }

        $this->_position = 0;
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
        $this->_current = $this->_zip->statIndex($this->_position);        
        ++$this->_position;
    }

    public function rewind()
    {
        $this->_position = 0;
        $this->next();
    }

    public function valid()
    {
        return is_array($this->_current);
    }
    
    public function seek($position)
    {
    	$this->_position = $position;
    }

    public function __destruct()
    {
        $this->_zip->close();
    }
}