<?php
/**
 * Format line as CSV into a string
 * 
 * @param array $fields
 * @param string $delimiter optional
 * @param string $enclosure optional
 * 
 * @return string
 */
function str_putcsv(array $fields, $delimiter = ',', $enclosure = '"')
{
    $handle = fopen('php://memory', 'rb+');

    if(false === fputcsv($handle, $fields, $delimiter, $enclosure))
    {
        return false;
    }

    rewind($handle);

    $content = stream_get_contents($handle);
    fclose($handle);

    return $content;
}