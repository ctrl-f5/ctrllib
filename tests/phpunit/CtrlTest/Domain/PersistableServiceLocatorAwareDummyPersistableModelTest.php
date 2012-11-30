<?php

namespace CtrlTest\Domain;

use CtrlTest\ApplicationTestCase;
use CtrlTest\Domain\TestAssets\DummyPersistableServiceLocatorAwareModel;
use Zend\ServiceManager\ServiceManager;

class DummyPersistableServiceLocatorAwareModelTest extends ApplicationTestCase
{
    /**
     * @var DummyPersistableServiceLocatorAwareModel
     */
    protected $model;

    public function setUp()
    {
        $this->model = new DummyPersistableServiceLocatorAwareModel();
    }

    public function tearDown()
    {
        $this->model = null;
    }

    public function testServiceLocatorProperty()
    {
        $this->assertNull($this->model->getServiceLocator());
        $locator = new ServiceManager();
        $this->model->setServiceLocator($locator);
        $this->assertSame($locator, $this->model->getServiceLocator());
    }

    public function testCanGetDomainService()
    {
        $serviceManager = $this->getServiceManager(array(
            'domain_services' => array(
                'invokables' => array(
                    'DummyDomainService' => 'CtrlTest\Service\TestAssets\DummyDomainService',
                )
            )
        ));
        $serviceManager->setFactory('DomainServiceLoader', new \Ctrl\Service\DomainServiceLoaderFactory());
        $this->model->setServiceLocator($serviceManager);

        $this->assertInstanceOf('CtrlTest\Service\TestAssets\DummyDomainService', $this->model->getDomainService('DummyDomainService'));
    }
}