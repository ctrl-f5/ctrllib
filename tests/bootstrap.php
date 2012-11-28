<?php

$autoload = __DIR__.'/../vendor/autoload.php';

if (file_exists($autoload)) {
    $loader = include $autoload;
    $loader->add('CtrlTest', __DIR__.'/phpunit/');
} else {
    die('could not find autoload in:'.$autoload.PHP_EOL);
} 
