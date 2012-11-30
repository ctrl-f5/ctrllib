<?php

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

if (!file_exists('test.config.php')) {
    throw new RuntimeException('Unable to locate "test.config.php":');
}

$autoload = __DIR__.'/../vendor/autoload.php';

if (file_exists($autoload)) {
    $loader = include $autoload;
    $loader->add('CtrlTest', __DIR__.'/phpunit/');
} else {
    throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}

if (!defined('TESTS_DOCTRINE_PROXY_DIR')) define('TESTS_DOCTRINE_PROXY_DIR', __DIR__.'/db/proxies/');

//$configuration = require 'test.config.php';
//
//$serviceManager = new ServiceManager(new ServiceManagerConfig(
//    isset($configuration['service_manager']) ? $configuration['service_manager'] : array()
//));
//$serviceManager->setService('ApplicationConfig', $configuration);
//$serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');
//
///** @var $moduleManager \Zend\ModuleManager\ModuleManager */
//$moduleManager = $serviceManager->get('ModuleManager');
//$moduleManager->loadModules();
//$serviceManager->setAllowOverride(true);
//
//TestCase::setServiceManager($serviceManager);