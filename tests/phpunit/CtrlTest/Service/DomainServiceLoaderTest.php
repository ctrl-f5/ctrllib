<?php

namespace CtrlTest\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

class DomainServiceLoaderTest extends \CtrlTest\ApplicationTest
{
    /**
     * @var ServiceManager
     */
    protected $serviceLoader;

    protected $defaultConfig = array(
        'domain_services' => array(
            'invokables' => array(
                'DummyDomainService' => 'CtrlTest\Service\TestAssets\DummyDomainService',
            )
        )
    );

    protected function setup()
    {
        $serviceConfig = new ServiceManagerConfig();
        $this->serviceManager = new ServiceManager($serviceConfig);
        $this->serviceManager->setService('Config', $this->defaultConfig);
        $this->serviceManager->setAlias('Configuration', 'Config');
        $factory = new \Ctrl\Service\DomainServiceLoaderFactory();
        $this->serviceLoader = $factory->createService($this->serviceManager);
    }

    protected function teardown()
    {
        $this->serviceManager = null;
        $this->serviceLoader = null;
    }

    public function testCanRetrieveDomainService()
    {
        $service = $this->serviceLoader->get('DummyDomainService');

        $this->assertTrue(is_object($service));
        $this->assertInstanceOf('CtrlTest\Service\TestAssets\DummyDomainService', $service);
    }

    public function testLoaderInjectsServiceLocator()
    {
        $service = $this->serviceLoader->get('DummyDomainService');

        $this->assertTrue(is_object($service->getServiceLocator()));
        $this->assertInstanceOf('Zend\ServiceManager\ServiceManager', $service->getServiceLocator());
    }
}
