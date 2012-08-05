<?php

namespace Ctrl\View\Helper\Form;

use Ctrl\View\Helper\AbstractHtmlElement;
use Zend\Form\ElementInterface;
use Ctrl\Form\Element\ElementInterface as CtrlElement;

class CtrlFormInput extends AbstractHtmlElement
{
    protected $defaultContainerAttributes = array();

    protected $defaulElementAttributes = array();

    protected $defaulLabelAttributes = array();

    public function __invoke(ElementInterface $element, $containerAttr = array(), $elementAttr = array(), $labelAttr = array())
    {
        $html = $this->create($element, $containerAttr, $elementAttr, $labelAttr);

        return $html;
    }

    protected function create(ElementInterface $element, $containerAttr = array(),$elementAttr = array(), $labelAttr = array())
    {
        return '<div'.
            $this->_htmlAttribs(
                $this->_cleanupAttributes(
                    array_merge_recursive($this->defaultContainerAttributes, $containerAttr)
                )
            ).
            '">'.
            $this->createLabel($element, $labelAttr).
            $this->createElement($element, $elementAttr).
            '</div>';
    }

    protected function createLabel(ElementInterface $element, $labelAttr = array())
    {
        return '<label>my element</label>';
    }

    protected function createElement(ElementInterface $element, $elementAttr = array())
    {
        return $element;
    }

    protected function isRequired(CtrlElement $element)
    {
        if ($element instanceof \Ctrl\Form\Element\ElementInterface
            && $element->getForm()->getInputFilter()
            && $element->getForm()->getInputFilter()->has($element->getName())
            && $element->getForm()->getInputFilter()->get($element->getName())->isRequired()) {
            return true;
        }
        return false;
    }
}
