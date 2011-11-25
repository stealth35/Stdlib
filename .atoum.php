<?php
$src = __DIR__.'/src/';

spl_autoload_register(function($class) use ($src) {
    $filename = $src.str_replace('\\', '/', $class).'.php';
    if (file_exists($filename)) {
        require $filename;
    }
});

require_once __DIR__.'/mageekguy.atoum.phar';