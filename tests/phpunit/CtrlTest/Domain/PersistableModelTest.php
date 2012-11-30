<?php

namespace CtrlTest\Domain;

use CtrlTest\Domain\TestAssets\DummyPersistableModel;

class PersistableModelTest Extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DummyPersistableModel
     */
    protected $model;

    public function setUp()
    {
        $this->model = new DummyPersistableModel();
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
}