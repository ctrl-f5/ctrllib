<?php

namespace CtrlTest\EntityManager;

use CtrlTest\DbTestCase;
use Ctrl\EntityManager\PostLoadSubscriber;
use CtrlTest\Domain\TestAssets\DummyEntity as Model;

class PostLoadSubscriberTest extends DbTestCase
{
    protected function setUp()
    {
        parent::setup();

        $this->entityManager = $this->getEntityManager(array(__DIR__.'/../Domain/TestAssets/metadata'));
        $this->createSchema($this->entityManager);
    }

    protected function breakdown()
    {
        $this->dropSchema($this->entityManager);
        $this->entityManager = null;
    }

    public function testDoesNotInjectServiceLocatorWhenPersisting()
    {
        // init entitymanager
        $entityManager = $this->entityManager;
        $entityManager->getEventManager()->addEventListener(
            array(\Doctrine\ORM\Events::postLoad),
            new PostLoadSubscriber($this->getServiceManager())
        );

        // add 3 ServiceLocatorAware dummy models
        $models = array(
            new Model(),
            new Model(),
            new Model(),
        );
        foreach ($models as $m) { $entityManager->persist($m); }
        $entityManager->flush();

        // original model does not have servicelocator
        $this->assertNull($models[0]->getServicelocator());

        // load it again
        $model = $entityManager
            ->createQuery('SELECT de FROM CtrlTest\\Domain\\TestAssets\\DummyEntity de WHERE de.id=:id')
            ->setParameter('id', 1)
            ->getOneOrNullResult();

        // did the model load
        $this->assertNotNull($model);
        $this->assertInstanceOf('CtrlTest\Domain\TestAssets\DummyEntity', $model);
        // did inject service locator
        $this->assertNull($model->getServiceLocator());
    }

    public function testDoesInjectServiceLocatorWhenLoading()
    {
        // init entitymanager
        $entityManager = $this->entityManager;
        $entityManager->getEventManager()->addEventListener(
            array(\Doctrine\ORM\Events::postLoad),
            new PostLoadSubscriber($this->getServiceManager())
        );

        // add 3 ServiceLocatorAware dummy models
        $models = array(
            new Model(),
            new Model(),
            new Model(),
        );
        foreach ($models as $m) { $entityManager->persist($m); }
        $entityManager->flush();

        // detatch all persisted models
        $entityManager->clear();

        $model = $entityManager
            ->createQuery('SELECT de FROM CtrlTest\\Domain\\TestAssets\\DummyEntity de WHERE de.id=:id')
            ->setParameter('id', 1)
            ->getOneOrNullResult();

        // original model does not have servicelocator
        $this->assertNull($models[0]->getServicelocator());
        // did the model load
        $this->assertNotNull($model);
        $this->assertInstanceOf('CtrlTest\Domain\TestAssets\DummyEntity', $model);
        // did inject service locator
        $this->assertInstanceOf('Zend\ServiceManager\ServiceManager', $model->getServiceLocator());
    }
}
