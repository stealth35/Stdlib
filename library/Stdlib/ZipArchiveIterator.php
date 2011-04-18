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
class ZipArchiveIterator extends SplZipFileInfo implements \Iterator
{
    /**
     * @var Stdlib\SplZipFileInfo
     */
    private $_current;

    /**
     * @var int
     */
    private $_position;

    /**
     * @var int
     */
    private $_internal_position;

    /**
     * @param string $filename
     * @throws \RuntimeException
     *
     * @todo Improve errors handling
     */
    public function __construct($file_name)
    {
        parent::__construct($file_name);
        
        if($this->isDir() === false)
        {
            throw new \UnexpectedValueException(sprintf('%s is not a directory', $file_name));
        }

        $this->_position = $this->_internal_position = 0;
        $this->next();
    }

    /**
     * @see \Iterator::current()
     */
    public function current()
    {
        return $this->_current;
    }

    /**
     * @see \Iterator::key()
     */
    public function key()
    {
        return $this->current()->getPathname();;
    }

    /**
     * @see Iterator::next()
     */
    public function next()
    {
        $stat = $this->_zip->statIndex($this->_internal_position);

        if(is_array($stat))
        {
            ++$this->_internal_position;

            if(dirname($stat['name']) . '/' === $this->_file_name)
            {
                $file_name = sprintf('zip://%s#%s', $this->_zip_name, $stat['name']);
                $this->_current = new SplZipFileInfo($file_name);
                ++$this->_position;
            }
            else
            {
                $this->next();
            }
        }
        else
        {
            $this->_current = false;
        }
    }

    /**
     * @see \Iterator::rewind()
     */
    public function rewind()
    {
        $this->_position = $this->_internal_position = 0;
        $this->next();
    }

    /**
     * @see \Iterator::valid()
     */
    public function valid()
    {
        return $this->_current;
    }

    public function __destruct()
    {
        $this->_zip->close();
    }
}