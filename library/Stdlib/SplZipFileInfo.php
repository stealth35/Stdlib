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
    private $_stat;
    private $_archive;

    public function __construct($file_name)
    {
        parent::__construct($file_name);
        
        $archive = strstr($file_name, '#', true);
        
        if(strpos($archive, 'zip://') === 0)
        {
            $this->_archive = substr($archive, strlen('zip://'));
        }
        else
        {
            $this->_archive = $archive;
        }

        $filename = substr(strstr($file_name, '#'), 1);
        
        $zip = new \ZipArchive();
        $zip->open($this->_archive);
        
        $this->_stat = $zip->statName($filename);
    }

    public function getFilename()
    {
        return basename($this->_stat['name']);
    }

    public function getPath()
    {
        return dirname($this->_stat['name']);
    }

    public function getBasename($suffix = null)
    {
        return basename($this->_stat['name'], $suffix);
    }

    public function getPathname()
    {
        return $this->_stat['name'];
    }

    public function getPerms()
    {
        return $this->getArchiveFileInfo()->getPerms();
    }

    public function getInode()
    {
        return $this->getArchiveFileInfo()->getInode();
    }

    public function getOwner()
    {
        return $this->getArchiveFileInfo()->getOwner();
    }

    public function getGroup()
    {
        return $this->getArchiveFileInfo()->getGroup();
    }

    public function getATime()
    {
        return $this->getArchiveFileInfo()->getATime();
    }

    public function getMTime()
    {
        return $this->_stat['mtime'];
    }

    public function getCTime()
    {
        return $this->getArchiveFileInfo()->getCTime();
    }

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

    public function isWritable()
    {
        return $this->getArchiveFileInfo()->isWritable();
    }

    public function isReadable()
    {
        return $this->getArchiveFileInfo()->isReadable();
    }

    public function isExecutable()
    {
        return $this->getArchiveFileInfo()->isExecutable();
    }

    public function getIndex()
    {
        return $this->_stat['index'];
    }

    public function getCRC()
    {
        return $this->_stat['crc'];
    }

    public function getSize()
    {
        return $this->_stat['size'];
    }

    public function getCompressSize()
    {
        return $this->_stat['comp_size'];
    }

    public function getCompressMethod()
    {
        return $this->_stat['comp_method'];
    }

    public function isDir()
    {
        return substr($this->_stat['name'], -1) === '/';
        
    }

    public function isFile()
    {
        return !$this->isDir();
    }

    public function getRealPath()
    {
        return sprintf('zip://%s#%s', $this->getArchiveFileInfo()->getRealPath(), $this->getPathname());
    }

    public function getFileInfo($class_name = __CLASS__)
    {
        return new $class_name($this->getRealPath());  
    }

    public function getPathInfo($class_name = __CLASS__)
    {
        return new $class_name($this->getRealPath());  
    }

    public function openFile($open_mode = 'r', $use_include_path = false, $context = null)
    {
        if($context === null)
        {
            return new \SplFileObject($this->getRealPath(), $open_mode, $use_include_path);
        }
        
        return new \SplFileObject($this->getRealPath(), $open_mode, $use_include_path, $context);
    }

    public function getArchiveFileInfo()
    {
        return new \SplFileInfo($this->_archive);
    }
}