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
        $this->assertEquals('Ctrl\Permissions\Acl', get_class($instance));
    }

    public function testInstantiatesCustomClass()
    {
        $serviceManager = $this->getServiceManager(array(
            'acl' => array(
                'class' => 'CtrlTest\Permissions\TestAssets\CustomAcl',
            )
        ));
        $instance = $this->factory->createService($serviceManager);

        $this->assertInstanceOf('Ctrl\Permissions\Acl', $instance);
        $this->assertInstanceOf('CtrlTest\Permissions\TestAssets\CustomAcl', $instance);
        $this->assertEquals('CtrlTest\Permissions\TestAssets\CustomAcl', get_class($instance));
    }

    public function testCanParseResourcesFromConfig()
    {
        $serviceManager = $this->getServiceManager(array(
            'acl' => array(
                'resources' => array(
                    'EmptyResources' => 'CtrlTest\Permissions\TestAssets\EmptyResources',
                )
            )
        ));
        $instance = $this->factory->createService($serviceManager);

        $this->assertEquals(3, count($instance->getResources()));
        $this->assertTrue($instance->hasResource(\Ctrl\Permissions\Resources::SET_GLOBAL));
        $this->assertTrue($instance->hasResource(\Ctrl\Permissions\Resources::SET_ROUTES));
    }

    public function testCanParseCustomResourcesFromConfig()
    {
        $serviceManager = $this->getServiceManager(array(
            'acl' => array(
                'resources' => array(
                    'CustomResources' => 'CtrlTest\Permissions\TestAssets\CustomResources',
                )
            )
        ));
        $instance = $this->factory->createService($serviceManager);

        //var_dump($instance->getResources());
        $this->assertEquals(5, count($instance->getResources()));
        $this->assertTrue($instance->hasResource(\Ctrl\Permissions\Resources::SET_GLOBAL));
        $this->assertTrue($instance->hasResource(\Ctrl\Permissions\Resources::SET_ROUTES));
        $this->assertTrue($instance->hasResource('routes.testRoute1'));
        $this->assertTrue($instance->hasResource('routes.testRoute2'));
    }
}
