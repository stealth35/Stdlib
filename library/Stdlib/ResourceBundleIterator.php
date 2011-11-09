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
class ResourceBundleIterator extends \RecursiveArrayIterator
{
   public function __construct(\ResourceBundle $bundle)
   {
       $storage = array();

       foreach($bundle as $key => $value)
       {
           $storage[$key] = $value instanceof \ResourceBundle ? new self($value) : $value;
       }

       parent::__construct($storage);
   }
}