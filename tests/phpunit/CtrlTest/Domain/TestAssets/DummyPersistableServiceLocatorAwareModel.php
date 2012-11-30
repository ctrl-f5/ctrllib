<?php

namespace CtrlTest\Domain\TestAssets;

use Ctrl\Domain\PersistableServiceLocatorAwareModel;

class DummyPersistableServiceLocatorAwareModel extends PersistableServiceLocatorAwareModel
{
    public function setId($id)
    {
        $this->id = $id;
    }
}
