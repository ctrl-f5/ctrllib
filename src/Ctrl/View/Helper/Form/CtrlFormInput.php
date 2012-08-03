<?php

namespace Ctrl\View\Helper\Form;

use Zend\View\Helper\AbstractHtmlElement;
use Zend\Form\ElementInterface;
use Ctrl\Form\Element\ElementInterface as CtrlElement;

class CtrlFormInput extends AbstractHtmlElement
{
    protected $defaultContainerAttributes = array();

    protected $defaulElementAttributes = array();

    protected $defaulLabelAttributes = array(
        'class' => array(
            'control-label',
        ),
    );

    public function __invoke(ElementInterface $element, $containerAttr = array(), $elementAttr = array(), $labelAttr = array())
    {
        $html = $this->createContainer(
            $this->createElement($element, $elementAttr),
            $this->createLabel($element, $labelAttr)
        );

        return $html;
    }

    protected function createContainer($element, $label, $containerAttr = array())
    {
        return '<div'.$this->_htmlAttribs(array_merge($this->defaultContainerAttributes, $containerAttr)).'">'.
            $label.
            $element.
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

    protected function _cleanupAttributes($attr)
    {
        $clean = array();
        foreach ($attr as $k => $a) {
            if (is_array($a)) {
                $a = implode(' ', $a);
            }
            $clean[$k] = $a;
        }
        return $clean;
    }

    protected function isRequired(CtrlElement $element)
    {
        if ($element instanceof \Ctrl\Form\Element\ElementInterface
            && $element->getForm()->getInputFilter()->has($element->getName())
            && $element->getForm()->getInputFilter()->get($element->getName())->isRequired()) {
            return true;
        }
        return false;
    }
}
