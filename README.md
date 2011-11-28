PHP Stdlib extra
================

EXAMPLE
-------
``` php
<?php
$zip = new Stdlib\ZipArchiveIterator('Stdlib.zip#Stdlib/src/Stdlib/');

foreach($zip as  $file)
{
    var_dump($file->getFilename());
}
```
```
string(24) "PDOStatementIterator.php"
string(31) "RecursiveZipArchiveIterator.php"
string(17) "RegexIterator.php"
string(19) "ReverseIterator.php"
string(17) "SplFileObject.php"
string(21) "SplVectorIterator.php"
string(18) "SplZipFileInfo.php"
string(22) "ZipArchiveIterator.php"
```
