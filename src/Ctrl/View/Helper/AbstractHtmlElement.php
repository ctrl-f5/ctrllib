<?php

namespace Ctrl\View\Helper;

use Zend\View\Helper\AbstractHtmlElement as ZendAbstractHtmlElement;
use Zend\Form\ElementInterface as ZendElementInterface;
use Zend\Form\Element;
use Ctrl\Form\Form;

abstract class AbstractHtmlElement extends ZendAbstractHtmlElement
{
    /**
     * @var \Zend\View\Renderer\PhpRenderer
     */
    protected $view;

    /**
     * @var array default attributes for a container
     */
    protected $defaultContainerAttributes = array();

    /**
     * @var array default attributes merged with the element's
     */
    protected $defaulElementAttributes = array();

    public function __invoke($content, $attr = array())
    {
        $html = $this->create($content, $attr);

        return $html;
    }

    protected function create($content, $attr = array()) {
        return '<div '.$this->htmlAttribs($this->_getContainerAttr($content, $attr)).'">'.
                    $this->createElement($content, $attr).
                '</div>';
    }

    protected function _getElementAttr($element, $attr = array())
    {
        $elemAttr = ($element instanceof Element) ? $element->getAttributes(): array();
        $clean = $this->_mergeAttributes(array(
            $this->defaulElementAttributes,
            $elemAttr,
            $attr
        ));
        unset($clean['container']);
        return $clean;
    }

    protected function _getContainerAttr($element, $attr = array())
    {
        if (isset($attr['container'])) {
            return $this->_mergeAttributes(array(
                $this->defaultContainerAttributes,
                $attr['container']
            ));
        }
        return $this->defaultContainerAttributes;
    }

    protected function _mergeAttributes($attrs = array())
    {
        $merged = array();
        foreach ($attrs as $attr) {
            if (!$attr) continue;
            foreach ($attr as $key => $value) {
                if ($key == 'class') {
                    if (is_array($value)) $value = implode(' ', $value);
                    if (isset($merged[$key])) {
                        $merged[$key] .= ' '.$value;
                        continue; //next!
                    }
                }
                $merged[$key] = $value;
            }
        }
        return $merged;
    }
}
