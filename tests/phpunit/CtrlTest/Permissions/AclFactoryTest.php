<?php

namespace CtrlTest\Permissions;

use CtrlTest\ApplicationTestCase;
use Ctrl\Permissions\AclFactory;

class AclFactoryTest extends ApplicationTestCase
{
    /**
     * @var AclFactory
     */
    protected $factory;

    protected function setup()
    {
        $this->factory = new AclFactory();
    }

    protected function teardown()
    {
        $this->factory = null;
    }

    /**
     * @expectedException Ctrl\Exception
     */
    public function testThrowsExceptionIfConfigKeyIsMissing()
    {
        $serviceManager = $this->getServiceManager();
        $instance = $this->factory->createService($serviceManager);
    }

    public function testInstantiatesCorrectDefaultClass()
    {
        $serviceManager = $this->getServiceManager(array(
            'acl' => array(
                'resources' => array(
                    'TestResources' => 'CtrlTest\Service\TestAssets\DummyDomainService',
                )
            )
        ));
        $instance = $this->factory->createService($serviceManager);

        $this->assertInstanceOf('Ctrl\Permissions\Acl', $instance);
    }

    public function testInstantiatesCustomClass()
    {
        return;
        $serviceManager = $this->getServiceManager(array(
            'acl' => array(
                'class' => 'custom',
            )
        ));
        $instance = $this->factory->createService($serviceManager);

        $this->assertInstanceOf('Ctrl\Permissions\Acl', $this->service->getDomainService('DummyDomainService'));
    }

    public function testCanParseResources()
    {
        return;
        $serviceManager = $this->getServiceManager(array(
            'acl' => array(
                'resources' => array(
                    'TestResources' => 'CtrlTest\Service\TestAssets\DummyDomainService',
                )
            )
        ));
        $instance = $this->factory->createService($serviceManager);

        $this->assertInstanceOf('Ctrl\Permissions\Acl', $this->service->getDomainService('DummyDomainService'));
    }
}
