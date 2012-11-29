<?php

namespace Ctrl\View\Helper\Form;

use Zend\Form\Element;
use Ctrl\Form\Element\ElementInterface as CtrlElement;

class CtrlFormInput extends AbstractFormElement
{
    protected function isRequired(CtrlElement $element)
    {
        if ($element instanceof \Ctrl\Form\Element\Element
            && $element->getForm()->getInputFilter()
            && $element->getForm()->getInputFilter()->has($element->getName())
            && $element->getForm()->getInputFilter()->get($element->getName())->isRequired()) {
            return true;
        }
        return false;
    }
}
