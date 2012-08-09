<?php

namespace CtrlTest\Domain;

require_once __DIR__.'/TestAssets/DummyModel.php';
use CtrlTest\Domain\TestAssets\DummyModel;

class ModelTest Extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DummyModel
     */
    protected $model;

    public function setUp()
    {
        $this->model = new DummyModel();
    }

    public function tearDown()
    {
        $this->model = null;
    }

    public function testCanOrderModelArrayWithDefaults()
    {
        //TODO
    }
}