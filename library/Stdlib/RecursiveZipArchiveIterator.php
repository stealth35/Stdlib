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
class RecursiveZipArchiveIterator extends ZipArchiveIterator implements \RecursiveIterator
{
	/**
	 * @var \ReflectionClass
	 */
    private $ref;

    /**
     * @see \RecursiveIterator:hasChildren();
     */
    public function hasChildren()
    {
        return $this->current()->isDir();
    }

    /**
     * @see \RecursiveIterator:getChildren();
     */
    public function getChildren()
    {
        if ($this->current() instanceof self)
        {
            return $this->current();
        }

        if (empty($this->ref))
        {
            $this->ref = new \ReflectionClass($this);
        }

        return $this->ref->newInstance($this->current() . '/');
    }
}