<?php

namespace CtrlTest\Service;

use Zend\ServiceManager\ServiceManager;

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
        parent::setup();
        $this->serviceLoader = $this->getServiceManager()->get('DomainServiceLoader');
    }

    protected function teardown()
    {
        parent::teardown();
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
        return;
        $service = $this->serviceLoader->get('DummyDomainService');

        $this->assertTrue(is_object($service->getServiceLocator()));
        $this->assertInstanceOf('Zend\ServiceManager\ServiceManager', $service->getServiceLocator());
    }

    public function testLoaderInjectsEntityManager()
    {
        return;
        $service = $this->serviceLoader->get('DummyDomainService');

        $this->assertTrue(is_object($service->getEntityManager()));
        $this->assertInstanceOf('Doctrine\ORM\EntityManager', $service->getEntityManager());
    }
}
