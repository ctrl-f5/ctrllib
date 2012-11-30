<?php

namespace CtrlTest\Permissions;

use CtrlTest\ApplicationTestCase;
use Ctrl\Permissions\Acl;
use CtrlTest\Permissions\TestAssets\EmptyResources;
use CtrlTest\Permissions\TestAssets\CustomResources;

class AclTest extends ApplicationTestCase
{
    /**
     * @var Acl
     */
    protected $acl;

    protected function setup()
    {
        $this->acl = new Acl();
    }

    protected function teardown()
    {
        $this->acl = null;
    }

    public function testCanAddSystemResources()
    {
        $this->acl->addSystemResources(new EmptyResources());

        $this->assertEquals(2, count($this->acl->getResources()));
        $this->assertTrue($this->acl->hasResource(\Ctrl\Permissions\Resources::SET_GLOBAL));
        $this->assertTrue($this->acl->hasResource(\Ctrl\Permissions\Resources::SET_ROUTES));
    }

    public function testDoesNotAddDoubleResources()
    {
        // add first time
        $this->acl->addSystemResources(new EmptyResources());

        $this->assertEquals(2, count($this->acl->getResources()));
        $this->assertTrue($this->acl->hasResource(\Ctrl\Permissions\Resources::SET_GLOBAL));
        $this->assertTrue($this->acl->hasResource(\Ctrl\Permissions\Resources::SET_ROUTES));

        // add again
        $this->acl->addSystemResources(new EmptyResources());

        // should still be the same
        $this->assertEquals(2, count($this->acl->getResources()));
        $this->assertTrue($this->acl->hasResource(\Ctrl\Permissions\Resources::SET_GLOBAL));
        $this->assertTrue($this->acl->hasResource(\Ctrl\Permissions\Resources::SET_ROUTES));
    }

    public function testCanAddCustomResources()
    {
        $this->acl->addSystemResources(new CustomResources());

        $this->assertEquals(4, count($this->acl->getResources()));
        $this->assertTrue($this->acl->hasResource(\Ctrl\Permissions\Resources::SET_GLOBAL));
        $this->assertTrue($this->acl->hasResource(\Ctrl\Permissions\Resources::SET_ROUTES));
        $this->assertTrue($this->acl->hasResource('routes.testRoute1'));
        $this->assertTrue($this->acl->hasResource('routes.testRoute2'));
    }
}
