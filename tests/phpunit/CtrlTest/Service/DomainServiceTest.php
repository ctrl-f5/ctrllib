<?php

namespace CtrlTest\Service;

class DomainServiceTest extends \CtrlTest\ApplicationTest
{
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
        $this->serviceLoader = $this->getServiceManager($this->defaultConfig)->get('DomainServiceLoader');
    }

    protected function teardown()
    {
        parent::teardown();
        $this->serviceLoader = null;
    }

    public function testCanRetrieveDomainService()
    {
        return;
        $service = $this->serviceLoader->get('DummyDomainService');

        $this->assertTrue(is_object($service));
        $this->assertInstanceOf('CtrlTest\Service\TestAssets\DummyDomainService', $service);
    }
}
