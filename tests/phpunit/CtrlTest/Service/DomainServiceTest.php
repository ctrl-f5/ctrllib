<?php

namespace CtrlTest\Service;

use CtrlTest\Service\TestAssets\DummyDomainService;

class DomainServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DummyDomainService
     */
    protected $service;

    protected function setup()
    {
        $this->service = new DummyDomainService();
    }

    protected function teardown()
    {
        $this->service = null;
    }

    public function testCanAccessServiceLocator()
    {
        $this->assertEquals($this->service->getServiceLocator(), null);

        $serviceManager = new \Zend\ServiceManager\ServiceManager();
        $this->service->setServiceLocator($serviceManager);

        $this->assertSame($this->service->getServiceLocator(), $serviceManager);
    }

    public function testCanGetDomainService()
    {
        $serviceManager = new \Zend\ServiceManager\ServiceManager();
        $serviceManager->setService('Config', array(
            'domain_services' => array(
                'invokables' => array(
                    'DummyDomainService' => 'CtrlTest\Service\TestAssets\DummyDomainService',
                )
            )
        ));
        $serviceManager->setService('ServiceManager', $serviceManager);
        $serviceManager->setAlias('Zend\ServiceManager\ServiceLocatorInterface', 'ServiceManager');
        $serviceManager->setAlias('Configuration', 'Config');
        $serviceManager->setFactory('DomainServiceLoader', new \Ctrl\Service\DomainServiceLoaderFactory());
        $this->service->setServiceLocator($serviceManager);

        $this->assertInstanceOf('CtrlTest\Service\TestAssets\DummyDomainService', $this->service->getDomainService('DummyDomainService'));
    }
}
