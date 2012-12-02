<?php

namespace CtrlTest;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

abstract class ApplicationTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zend\Mvc\Application
     */
    protected $applicationServiceManager;

    protected $defaultApplicationConfig = array();

    protected function getServiceManager($config = array())
    {
        $serviceManager = new \Zend\ServiceManager\ServiceManager();
        $serviceManager->setService('Config', $config);
        $serviceManager->setService('ServiceManager', $serviceManager);
        $serviceManager->setAlias('Zend\ServiceManager\ServiceLocatorInterface', 'ServiceManager');
        $serviceManager->setAlias('Configuration', 'Config');
        return $serviceManager;
    }

    protected function getApplicationServiceManager(array $configuration = array())
    {
        $config = new \Zend\Config\Config(include __DIR__.'/../../test.config.php');
        $config->merge(new \Zend\Config\Config($this->defaultApplicationConfig));
        $config->merge(new \Zend\Config\Config($configuration));
        $serviceManager = new ServiceManager(new ServiceManagerConfig($config->toArray()));
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');
        /* @var $moduleManager \Zend\ModuleManager\ModuleManagerInterface */
        $moduleManager = $serviceManager->get('ModuleManager');
        $moduleManager->loadModules();

        return $serviceManager;
    }

    protected function getApplicationConfig(array $configuration = array())
    {
        $config = new \Zend\Config\Config(include __DIR__.'/../../test.config.php');
        $config->merge(new \Zend\Config\Config($this->defaultApplicationConfig));
        $config->merge(new \Zend\Config\Config($configuration));
        return $config;
    }
}
