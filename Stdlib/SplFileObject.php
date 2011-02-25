<?php
/**
 * @namespace
 */
namespace Stdlib;

/**
 * Add fputcsv method to \SplFileObject
 * 
 * @category Stdlib
 * @package  Stdlib
 * @author   stealth35
 * @see      http://bugs.php.net/bug.php?id=53264
 */
class SplFileObject extends \SplFileObject
{
    /**
     * Format line as CSV and write to file
     * 
     * @param array $fields
     * @param string $delimiter optional
     * @param string $enclosure optional
     * 
     * @return mixed
     */
    public function fputcsv(array $fields, $delimiter = ',', $enclosure = '"')
    {
        $handle = fopen('php://memory', 'r+');

        if(false === fputcsv($handle, $fields, $delimiter, $enclosure))
        {
            return false;
        }

        rewind($handle);

        $content = stream_get_contents($handle);
        fclose($handle);

        return $this->fwrite($content);
    }
}