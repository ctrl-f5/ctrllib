<?php

namespace Ctrl\View\Helper\Form;

use Ctrl\View\Helper\AbstractHtmlElement;
use Zend\Form\Element;
use Ctrl\Form\Element\ElementInterface as CtrlElement;

class AbstractFormElement extends AbstractHtmlElement
{
    protected $defaulLabelAttributes = array();

    public function __invoke($element, $attr = array())
    {
        $html = $this->create(
            $element,
            $attr
        );

        return $html;
    }

    protected function _getLabelAttr(Element $element, $attr = array())
    {
        if (isset($attr['container'])) {
            return $this->_mergeAttributes(array(
                $this->defaulLabelAttributes,
                $element->getLabelAttributes()
            ));
        }
        return $this->defaulLabelAttributes;
    }

    /**
     * @param $element Element
     * @param array $attr
     * @return string
     */
    protected function create($element, $attr = array())
    {
        if ($element instanceof Element && $element->getAttribute('type') == 'hidden') {
            return $this->createElement($element, $attr);
        }
        return '<div '.$this->_htmlAttribs($this->_getContainerAttr($element, $attr)).
            '">'.
            $this->createLabel($element, $attr).
            $this->createElement($element, $attr).
            '</div>';
    }

    protected function createLabel(Element $element, $attr = array())
    {
        return '<label '.$this->_htmlAttribs($this->_getLabelAttr($element, $attr)).'>'.
                    $element->getLabel().
                '</label>';
    }

    protected function createElement(Element $element, $attr = array())
    {
        $tmpAttr = $element->getAttributes();
        $element->setAttributes($this->_getElementAttr($element, $attr));
        $html = $this->_getElementRenderer(
                $element->getAttribute('type')
            )->render($element);
        $element->setAttributes($tmpAttr);
        return $html;
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

    /**
     * @param string $type
     * @return FormInput|FormSelect
     */
    protected function _getElementRenderer($type)
    {
        switch ($type) {
            case 'select':
            default:
                return $this->view->getHelperPluginManager()->get('FormSelect');
                break;
            case 'textarea':
            default:
                return $this->view->getHelperPluginManager()->get('FormTextarea');
                break;
            case 'text':
            default:
                return $this->view->getHelperPluginManager()->get('FormInput');
                break;
        }
    }
}
