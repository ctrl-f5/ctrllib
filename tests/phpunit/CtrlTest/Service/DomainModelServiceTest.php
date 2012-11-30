<?php

namespace CtrlTest\Service;

use CtrlTest\DbTestCase;
use CtrlTest\Service\TestAssets\DummyEntityModelService;
use CtrlTest\Domain\TestAssets\DummyEntity;

class DomainModelServiceTest extends DbTestCase
{
    /**
     * @var DummyEntityModelService
     */
    protected $service;

    protected function setup()
    {
        $this->entityManager = $this->getEntityManager(array(__DIR__.'/../Domain/TestAssets/metadata'));
        $this->createSchema($this->entityManager);
        $this->service = new DummyEntityModelService();
        $this->service->setEntityManager($this->entityManager);
    }

    protected function teardown()
    {
        $this->service = null;
        $this->dropSchema($this->entityManager);
        $this->entityManager = null;
    }

    public function testCanPersistModel()
    {

        $model = new DummyEntity();
        $this->assertNull($model->getId());
        $this->entityManager->persist($model);
        $this->entityManager->flush();
        $this->assertNotNull($model->getId());
    }

    public function testCanGetModelById()
    {
        $models = array(
            new DummyEntity(),
            new DummyEntity(),
            new DummyEntity(),
        );
        foreach ($models as $m) { $this->entityManager->persist($m); }
        $this->entityManager->flush();
        $result = $this->service->getById(1);
        $this->assertSame($models[0], $result);
    }

    public function testCanGetAllModels()
    {
        $models = array(
            new DummyEntity(),
            new DummyEntity(),
            new DummyEntity(),
        );
        foreach ($models as $m) { $this->entityManager->persist($m); }
        $this->entityManager->flush();
        $result = $this->service->getAll();
        $this->assertEquals(3, count($result));
    }
}
