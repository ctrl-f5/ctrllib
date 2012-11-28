<?php

namespace CtrlTest;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zend\Mvc\Application
     */
    protected $serviceManager;

    protected $defaultConfig = array();

    protected function getServiceManager(array $configuration = array())
    {
        $config = new \Zend\Config\Config(include __DIR__.'/../../test.config.php');
        $config->merge(new \Zend\Config\Config($this->defaultConfig));
        $config->merge(new \Zend\Config\Config($configuration));
        $serviceManager = new ServiceManager(new ServiceManagerConfig($config->toArray()));
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');
        /* @var $moduleManager \Zend\ModuleManager\ModuleManagerInterface */
        $moduleManager = $serviceManager->get('ModuleManager');
        $moduleManager->loadModules();

        return $serviceManager;
    }

    public function testCanCreateServiceManager()
    {
        $this->assertInstanceOf('\Zend\ServiceManager\ServiceManager', $this->getServiceManager());
    }

}
