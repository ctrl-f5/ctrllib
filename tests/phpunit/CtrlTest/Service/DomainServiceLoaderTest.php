<?php

namespace CtrlTest\Service;

use CtrlTest\ApplicationTestCase;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

class DomainServiceLoaderTest extends ApplicationTestCase
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
        $serviceManager = $this->getServiceManager($this->defaultConfig);
        $factory = new \Ctrl\Service\DomainServiceLoaderFactory();
        $this->serviceLoader = $factory->createService($serviceManager);
    }

    protected function teardown()
    {
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
