<?php

namespace CtrlTest\Domain\TestAssets;

use Ctrl\Domain\AbstractModel;

class DummyOrderModel extends AbstractModel
{
    protected $id;
    protected $order;

    public function __construct($id, $order)
    {
        $this->setId($id);
        $this->setOrder($order);
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
}
