<?php

namespace CtrlTest\Domain;

use Ctrl\Domain\ArrayCollection;
use CtrlTest\Domain\TestAssets\DummyOrderModel;

class ArrayCollectionTest Extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayCollection
     */
    protected $collection;

    public function setUp()
    {
        $this->collection = new ArrayCollection();
    }

    public function tearDown()
    {
        $this->collection = null;
    }

    public function testCanCreateFromArray()
    {
        $this->collection = new ArrayCollection(array(
            new DummyOrderModel(1, 1),
            new DummyOrderModel(2, 2),
            new DummyOrderModel(3, 3),
        ));

        $this->assertEquals(3, count($this->collection));
    }

    public function testCanGetFirstByProperty()
    {
        $models = array(
            new DummyOrderModel(1, 1),
            new DummyOrderModel(2, 2),
            new DummyOrderModel(3, 3),
        );
        $this->collection = new ArrayCollection($models);

        $this->assertEquals(3, count($this->collection));
        $this->assertSame($models[0], $this->collection->getFirstInCollectionWithProperty('getId', 1));
        $this->assertSame($models[1], $this->collection->getFirstInCollectionWithProperty('getOrder', 2));
    }

    public function testCanChangeOrder()
    {
        $models = array(
            new DummyOrderModel(1, 1),
            new DummyOrderModel(2, 2),
            new DummyOrderModel(3, 3),
        );
        $this->collection = new ArrayCollection($models);
        // move lqst element one up
        $this->collection->moveOrderInCollection(3, ArrayCollection::ORDER_MOVE_DIR_UP);

        $this->assertEquals(3, count($this->collection));
        $this->assertSame($models[2], $this->collection->getFirstInCollectionWithProperty('getOrder', 2));
        $this->assertSame($models[1], $this->collection->getFirstInCollectionWithProperty('getOrder', 3));
        $this->assertSame($models[0], $this->collection->getFirstInCollectionWithProperty('getOrder', 1));
    }
}