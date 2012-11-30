<?php

namespace CtrlTest\Domain\TestAssets;

use Ctrl\Domain\PersistableModel;

class DummyPersistableModel extends PersistableModel
{
    public function setId($id)
    {
        $this->id = $id;
    }
}
