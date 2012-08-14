<?php

namespace Ctrl\View\Helper\Form;

use Ctrl\View\Helper\AbstractHtmlElement;
use Zend\Form\Element;
use Ctrl\Form\Element\ElementInterface as CtrlElement;

class CtrlButton extends AbstractHtmlElement
{
    public function __invoke($type, $attr = array())
    {
        return $this->create($type, $attr);
    }

    protected function create($type, $attr = array())
    {
        switch ($type) {
            case 'submit':
                return $this->createSubmit($attr);
                break;
            case 'link':
                return $this->createlink($attr);
                break;
            case 'button':
            default:
                return $this->createButton($attr);
                break;
        }
    }

    protected function createSubmit($attr = array())
    {
        return '<input type="submit"'.$this->_htmlAttribs($this->_getElementAttr(null, $attr)).
            $this->getClosingBracket().
            PHP_EOL;
    }

    protected function createLink($attr = array())
    {
        $name = isset($attr['value']) ? $attr['value'] : '';
        return '<a'.$this->_htmlAttribs($this->_getElementAttr(null, $attr)).'>'.
            $name.
            '</a>'.
            PHP_EOL;
    }

    protected function createButton($attr = array())
    {
        $name = isset($attr['value']) ? $attr['value'] : '';
        return '<button '.$this->_htmlAttribs($this->_getElementAttr(null, $attr)).'>'.
            $name.
            '</button>'.
            PHP_EOL;
    }
}
