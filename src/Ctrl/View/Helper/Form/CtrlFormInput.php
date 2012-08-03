<?php

namespace Ctrl\View\Helper\Form;

use Zend\View\Helper\AbstractHtmlElement;
use Zend\Form\ElementInterface;
use Ctrl\Form\Element\ElementInterface as CtrlElement;

class CtrlFormInput extends AbstractHtmlElement
{
    /**
     * @var \Zend\View\Renderer\PhpRenderer
     */
    protected $view;

    protected $defaultContainerAttributes = array();

    protected $defaulElementAttributes = array();

    protected $defaulLabelAttributes = array(
        'class' => array(
            'control-label',
        ),
    );

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

    /**
     * converts subarrays to strings
     * seperated by a space
     *
     * @param $attr
     * @return array
     */
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
