<?php

error_reporting(E_STRICT);

$autoload = __DIR__.'/../vendor/autoload.php';
if (file_exists($autoload)) {
    $loader = include $autoload;
}