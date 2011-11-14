<?php
$src = __DIR__.'/../src/';

spl_autoload_register(function($class) use ($src) {
    require $src.str_replace('\\', '/', $class).'.php';
});