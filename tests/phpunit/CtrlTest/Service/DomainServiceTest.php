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
        $this->serviceLoader = $this->application->getServiceManager()->get('DomainServiceLoader');
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
}
