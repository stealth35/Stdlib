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
class SplZipFileInfo extends \SplFileInfo
{
    /**
     * @var array
     */
    protected $_stat;

    /**
     * @var string
     */
    protected $_zip_name;
    
    /**
     * @var \ZipArchive
     */
    protected $_file_name;

    /**
     * @var \ZipArchive
     */
    protected $_zip;

    /**
     * @param string $file_name
     */
    public function __construct($file_name)
    {
        parent::__construct($file_name);
        
        $archive = strstr($file_name, '#', true);
        
        if(strpos($archive, 'zip://') === 0)
        {
            $this->_zip_name = substr($archive, strlen('zip://'));
        }
        else
        {
            $this->_zip_name = $archive;
        }

        $filename = substr(strstr($file_name, '#'), 1);

        $zip = new \ZipArchive();

        $ret = $zip->open($this->_zip_name);

        if(true !== $ret)
        {
            $message = sprintf('zip error', $ret);
            throw new \RuntimeException($message);
        }

        $this->_stat = $zip->statName($filename);
        $this->_zip = $zip;
        $this->_file_name = $filename;
    }

    /**
     * @see \SplFileInfo::getFilename()
     */
    public function getFilename()
    {
        return basename($this->_stat['name']);
    }

    /**
     * @see \SplFileInfo::getPath()
     */
    public function getPath()
    {
        return dirname($this->_stat['name']);
    }

    /**
     * @see \SplFileInfo::getBasename()
     */
    public function getBasename($suffix = null)
    {
        return basename($this->_stat['name'], $suffix);
    }

    /**
     * @see \SplFileInfo::getPathname()
     */
    public function getPathname()
    {
        return $this->_stat['name'];
    }

    /**
     * @see SplFileInfo::getPerms()
     */
    public function getPerms()
    {
        return $this->getZipArchiveFileInfo()->getPerms();
    }

    /**
     * @see \SplFileInfo::getInode()
     */
    public function getInode()
    {
        return $this->getZipArchiveFileInfo()->getInode();
    }

    /**
     * @see \SplFileInfo::getOwner()
     */
    public function getOwner()
    {
        return $this->getZipArchiveFileInfo()->getOwner();
    }

    /**
     * @see \SplFileInfo::getGroup()
     */
    public function getGroup()
    {
        return $this->getZipArchiveFileInfo()->getGroup();
    }

    /**
     * @see \SplFileInfo::getATime()
     */
    public function getATime()
    {
        return $this->getZipArchiveFileInfo()->getATime();
    }

    /**
     * @see \SplFileInfo::getMTime()
     */
    public function getMTime()
    {
        return $this->_stat['mtime'];
    }

    /**
     * @see \SplFileInfo::getCTime()
     */
    public function getCTime()
    {
        return $this->getZipArchiveFileInfo()->getCTime();
    }

    /**
     * @see \SplFileInfo::getType()
     */
    public function getType()
    {
        if($this->isDir())
        {
            return 'dir';
        }
        
        if($this->isFile())
        {
            return 'file';
        }
    }

    /**
     * @see \SplFileInfo::isWritable()
     */
    public function isWritable()
    {
        return $this->getZipArchiveFileInfo()->isWritable();
    }

    /**
     * @see \SplFileInfo::isReadable()
     */
    public function isReadable()
    {
        return $this->getZipArchiveFileInfo()->isReadable();
    }

    /**
     * @see \SplFileInfo::isExecutable()
     */
    public function isExecutable()
    {
        return $this->getZipArchiveFileInfo()->isExecutable();
    }

    /**
     * Return ZipArchive file index
     * @return int
     */
    public function getIndex()
    {
        return $this->_stat['index'];
    }

    /**
     * Return ZipArchive file CRC
     * @return string
     */
    public function getCRC()
    {
        return $this->_stat['crc'];
    }

    /**
     * @see \SplFileInfo::getSize()
     */
    public function getSize()
    {
        return $this->_stat['size'];
    }

    /**
     * Return ZipArchive file compresse size
     * @return int
     */
    public function getCompressSize()
    {
        return $this->_stat['comp_size'];
    }

    /**
     * Return ZipArchive file compresse method
     * @return int
     */
    public function getCompressMethod()
    {
        return $this->_stat['comp_method'];
    }

    /**
     * @see \SplFileInfo::isDir()
     */
    public function isDir()
    {
        return substr($this->_stat['name'], -1) === '/';
    }

    /**
     * @see \SplFileInfo::isFile()
     */
    public function isFile()
    {
        return !$this->isDir();
    }

    /**
     * @see \SplFileInfo::getRealPath()
     */
    public function getRealPath()
    {
        return sprintf('zip://%s#%s', $this->getZipArchiveFileInfo()->getRealPath(), $this->getPathname());
    }

    /**
     * @see \SplFileInfo::getFileInfo()
     */
    public function getFileInfo($class_name = __CLASS__)
    {
        return new $class_name($this->getRealPath());  
    }

    /**
     * @see \SplFileInfo::getPathInfo()
     */
    public function getPathInfo($class_name = __CLASS__)
    {
        return new $class_name($this->getRealPath());  
    }

    /**
     * @see \SplFileInfo::openFile()
     */
    public function openFile($open_mode = 'r', $use_include_path = false, $context = null)
    {
        if($context === null)
        {
            return new \SplFileObject($this->getRealPath(), $open_mode, $use_include_path);
        }
        
        return new \SplFileObject($this->getRealPath(), $open_mode, $use_include_path, $context);
    }

    /**
     * Return ZipArchive info of this file
     * @return \SplFileInfo
     */
    public function getZipArchiveFileInfo()
    {
        return new \SplFileInfo($this->_zip_name);
    }

    /**
     * Return ZipArchive of this file
     * @return \ZipArchive
     */
    public function getZipArchive()
    {
        return $this->_zip;
    }  
}