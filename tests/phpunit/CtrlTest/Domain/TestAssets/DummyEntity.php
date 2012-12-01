<?php

namespace CtrlTest\Domain\TestAssets;

use Ctrl\Domain\PersistableServiceLocatorAwareModel;

class DummyEntity extends PersistableServiceLocatorAwareModel
{
    protected $stringProperty = 'test';

    protected $intProperty = 69;

    protected $dateProperty;

    public function __construct()
    {
        $this->dateProperty = new \DateTime();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDateProperty($dateProperty)
    {
        $this->dateProperty = $dateProperty;
    }

    public function getDateProperty()
    {
        return $this->dateProperty;
    }

    public function setIntProperty($intProperty)
    {
        $this->intProperty = $intProperty;
    }

    public function getIntProperty()
    {
        return $this->intProperty;
    }

    public function setStringProperty($stringProperty)
    {
        $this->stringProperty = $stringProperty;
    }

    public function getStringProperty()
    {
        return $this->stringProperty;
    }
}
