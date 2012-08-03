<?php

namespace Ctrl\Form;

use Zend\Form\Form as ZendForm;
use Ctrl\Form\Element\ElementInterface;

class Form extends ZendForm
{
    /**
     * @return array|\Traversable|ElementInterface[]
     */
    public function getElements()
    {
        return parent::getElements();
    }

    /**
     * @param array|\Traversable|ElementInterface $elementOrFieldset
     * @param array $flags
     * @return void|\Zend\Form\Fieldset|\Zend\Form\FieldsetInterface|\Zend\Form\FormInterface
     */
    public function add($elementOrFieldset, array $flags = array())
    {
        if ($elementOrFieldset instanceof ElementInterface) {
            $elementOrFieldset->setForm($this);
        }
        parent::add($elementOrFieldset, $flags);
    }
}
