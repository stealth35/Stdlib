<?php
namespace Stdlib;

class ReverseIterator implements \IteratorAggregate
{
    private $_iterator;

    public function __construct(\Traversable $iterator)
    {
        $this->_iterator = $iterator;
    }

    public function getIterator()
    {
        $array = iterator_to_array($this->_iterator, true);
        $reverse = array_reverse($array, true);

        return new \ArrayIterator($reverse);
    }
}