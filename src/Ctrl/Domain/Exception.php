<?php

namespace Ctrl\Domain;

use Ctrl\Domain\PersistableModel;

class Exception extends \Ctrl\Exception
{
    public static function modelPersistanceException(PersistableModel $model)
    {
        $msg = 'Failed to mersist model %s with id: %s';
        return new self(
            sprintf(
                $msg,
                get_class($model),
                $model->getId()
            )
        );
    }
}
