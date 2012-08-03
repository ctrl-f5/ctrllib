<?php

namespace Ctrl\Domain;

abstract class PersistableModel implements Model
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
