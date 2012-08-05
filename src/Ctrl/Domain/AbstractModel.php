<?php

namespace Ctrl\Domain;

abstract class AbstractModel implements Model
{
    protected $_orderGetter = 'getOrder';

    /**
     * @param $array
     * @param null $getter
     * @return array
     * @throws \Exception
     */
    protected function _orderModelArray($array, $getter = null)
    {
        $ordered = array();

        $getter = $getter ?: $this->_orderGetter;
        if (!is_callable($getter)) $getter = function ($model) use ($getter) {
            //TODO: fix exception
            if (method_exists($model, $getter))
                throw new \Exception('object must implement getter: '.$getter);
            return $model->$getter();
        };

        foreach ($array as $model) {
            //TODO: fix exception
            if (!is_object($model))
                throw new \Exception('must be object');
            $ordered[$getter($model)] = $model;
        }
        ksort($ordered);
        return $ordered;
    }
}
