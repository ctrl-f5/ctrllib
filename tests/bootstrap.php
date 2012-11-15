<?php

error_reporting(E_STRICT);
ini_set('display_errors', 1);

$autoload = __DIR__.'/../vendor/autoload.php';
if (file_exists($autoload)) {
    $loader = include $autoload;
} else {
    die('could not find autoload in:'.$autoload.PHP_EOL);
} 
