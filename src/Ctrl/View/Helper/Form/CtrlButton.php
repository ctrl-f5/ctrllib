<?php

namespace Ctrl\View\Helper\Form;

use Ctrl\View\Helper\AbstractHtmlElement;
use Zend\Form\ElementInterface;
use Ctrl\Form\Element\ElementInterface as CtrlElement;

class CtrlButton extends AbstractHtmlElement
{
    protected $defaulAttributes = array();

    public function __invoke($type, $attr = array())
    {
        $attr = $this->_cleanupAttributes(
            array_merge_recursive($this->defaulAttributes, $attr)
        );
        switch ($type) {
            case 'submit':
                $this->createSubmit($attr);
                break;
            case 'link':
                $this->createlink($attr);
                break;
            case 'button':
            default:
                $this->createButton($attr);
                break;
        }
    }

    protected function createSubmit($attr = array())
    {
        return '<input type="submit"'.
            $this->_htmlAttribs($attr).
            $this->getClosingBracket().
            PHP_EOL;
    }

    protected function createLink($attr = array())
    {
        $name = isset($attr['value']) ? $attr['value'] : '';
        return '<a'.
            $this->_htmlAttribs($attr).
            '>'.
            $name.
            '</a>'.
            PHP_EOL;
    }

    protected function createButton($attr = array())
    {
        $name = isset($attr['value']) ? $attr['value'] : '';
        return '<button '.
            $this->_htmlAttribs($attr).
            '>'.
            $name.
            '</button>'.
            PHP_EOL;
    }
}
