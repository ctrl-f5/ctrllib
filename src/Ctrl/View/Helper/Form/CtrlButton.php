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
            case 'dropdown':
                return $this->createDropdown($attr);
                break;
            case 'button':
            default:
                return $this->createButton($attr);
                break;
        }
    }

    protected function createSubmit($attr = array())
    {
        return '<input type="submit"'.$this->htmlAttribs($this->_getElementAttr(null, $attr)).
            $this->getClosingBracket().
            PHP_EOL;
    }

    protected function createLink($attr = array())
    {
        $name = isset($attr['value']) ? $attr['value'] : '';
        return '<a'.$this->htmlAttribs($this->_getElementAttr(null, $attr)).'>'.
            $name.
            '</a>'.
            PHP_EOL;
    }

    protected function createDropdown($attr = array())
    {
        if (!isset($attr['children']) || !is_array($attr['children']) || !count($attr['children'])) return '';

        $children = $attr['children'];
        unset($attr['children']);

        $html = array();
        $name = isset($attr['value']) ? $attr['value'] : '';
        $html[] = '<a '.$this->htmlAttribs($this->_getElementAttr(null, $attr)).' data-toggle="dropdown" href="#">'
                    .$name.' <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">';

        foreach ($children as $child) {
            $html[] ='<a href="'.$child['url'].'">'.$child['content'].'</a>';
        }
        $html[] = '</ul>';

        return implode(PHP_EOL, $html).PHP_EOL;
    }

    protected function createButton($attr = array())
    {
        $name = isset($attr['value']) ? $attr['value'] : '';
        return '<button '.$this->htmlAttribs($this->_getElementAttr(null, $attr)).'>'.
            $name.
            '</button>'.
            PHP_EOL;
    }
}
