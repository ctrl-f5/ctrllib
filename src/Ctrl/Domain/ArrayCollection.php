<?php

namespace Ctrl\Domain;

use \Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

class ArrayCollection extends DoctrineCollection
{
    const ORDER_MOVE_DIR_UP     = 'up';
    const ORDER_MOVE_DIR_DOWN   = 'down';

    /**
     * Moves an element one up or down in an ordered collection
     *  - the getter and setter of the order property must be public
     *  - the getter and setter
     *
     * @param mixed $id id of the element that needs to be moved
     * @param string $dir wether to move it up or down
     * @param string $getter the function used to retrieve the order of a model
     * @param string $setter the function used to set the order of a model
     * @param array|ArrayCollection $collection
     * @return ArrayCollection
     */
    public function moveOrderInCollection($id, $dir, $getter = 'getOrder', $setter =  'setOrder', $collection = null)
    {
        if ($collection == null) $collection = $this;

        //get order of source model and check its validity
        $from = $this->getFirstInCollectionWithProperty('getId', $id, $collection);
        $order = $from->$getter();
        if (($order >= count($collection) && $dir == self::ORDER_MOVE_DIR_DOWN) || ($order <= 1 && $dir == self::ORDER_MOVE_DIR_UP)) {
            return $collection;
        }

        if ($dir == self::ORDER_MOVE_DIR_UP) $order--;
        elseif ($dir == self::ORDER_MOVE_DIR_DOWN) $order++;

        //switch the orders
        $to = $this->getFirstInCollectionWithProperty($getter, $order, $collection);
        $to->$setter($from->$getter());
        $from->$setter($order);

        return $collection;
    }

    /**
     * Returns the first class in the collection that returns
     * the same value as $value
     *
     * @param string $getter the method to check the value against
     * @param mixed $value the value to compare to the result of the called method
     * @param array|ArrayCollection $collection
     * @return ArrayCollection
     * @throws Exception
     */
    public function getFirstInCollectionWithProperty($getter, $value, $collection = null)
    {
        if ($collection == null) $collection = $this;

        // only check once, assume all same classes
        $checkedMethod = false;
        foreach ($collection as $model) {
            if (!$checkedMethod) {
                if (!method_exists($model, $getter)) {
                    throw new Exception("Invalid getter $getter for class: ".get_class($model));
                }
                $checkedMethod = true;
            }
            if ($model->$getter() == $value) return $model;
        }
        throw new Exception("No ".get_class($model)." found with $getter($value)");
    }
}
