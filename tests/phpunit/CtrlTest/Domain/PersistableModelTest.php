<?php

namespace CtrlTest\Domain;

use CtrlTest\DbTestCase;
use CtrlTest\Domain\TestAssets\DummyEntity;

class PersistableModelTest extends DbTestCase
{
    /**
     * @var DummyEntity
     */
    protected $model;

    public function setUp()
    {
        $this->model = new DummyEntity();
    }

    public function tearDown()
    {
        $this->model = null;
    }

    public function testIdProperty()
    {
        $this->assertNull($this->model->getId());
        $this->model->setId('test');
        $this->assertEquals('test', $this->model->getId());
    }

    public function testCanPersist()
    {
        $em = $this->getEntityManager(array(__DIR__.'/TestAssets/metadata'));
        $this->createSchema($em);

        $this->assertNull($this->model->getId());
        $em->persist($this->model);
        $em->flush();
        $this->assertNotNull($this->model->getId());
    }
}