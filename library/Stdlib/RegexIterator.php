<?php
/**
 * @namespace
 */
namespace Stdlib;

/**
 * Add getRegex method to \RegexIterator
 * 
 * @category Stdlib
 * @package  Stdlib
 * @author   stealth35
 * @see http://bugs.php.net/bug.php?id=53659
 */
class RegexIterator extends \RegexIterator
{
    /**
     * @var string
     */
    private $_regex;

    /**
     * @param \Iterator $iterator
     * @param string $regex
     * @param int $mode optional
     * @param int $flags optional
     * @param int $preg_flags optional
     */
    public function __construct(\Iterator $iterator, $regex, $mode = null, $flags = null, $preg_flags = null)
    {
        parent::__construct($iterator, $regex, $mode, $flags, $preg_flags);
        $this->_regex = $regex;
    }

    /**
     * @return string
     */
    public function getRegex()
    {
        return $this->_regex;
    }
}