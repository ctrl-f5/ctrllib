<?php

namespace Ctrl\View\Helper;

use Zend\View\Helper\AbstractHtmlElement as ZendAbstractHtmlElement;
use Ctrl\View\Helper\AbstractHtmlElement;

class PageTitle extends AbstractHtmlElement
{
    protected $defaulSubtitleAttributes = array();

    public function __invoke($title, $subtitle = null, $attr = array())
    {
        $html = $this->create($title, $subtitle, $attr);

        return $html;
    }

    protected function _getSubtitleAttr($subtitle, $attr = array())
    {
        if (isset($attr['subtitle'])) {
            return $this->_mergeAttributes(array(
                $this->defaulSubtitleAttributes,
                $attr
            ));
        }
        return $this->defaulLabelAttributes;
    }

    protected function _getElementAttr($element, $attr = array())
    {
        $clean = parent::_getElementAttr($element, $attr);
        unset($clean['subtitle']);
        return $clean;
    }

    protected function create($title, $subtitle = null, $attr = array())
    {
        return '<div '.$this->_htmlAttribs($this->_getContainerAttr($title, $attr)).'>'.
            $this->createTitle($title, $attr).$this->createSubtitle($subtitle, $attr).
        '</div>';
    }

    protected function createTitle($title, $attr = array())
    {
        '<h1'.$this->_htmlAttribs($this->_mergeAttributes($this->defaulElementAttributes, $attr)).'>'.
            $title.
        '</h1>';
    }

    protected function createSubtitle($subtitle, $attr = array())
    {
        '<h2'.$this->_htmlAttribs($this->_mergeAttributes($this->defaulSubtitleAttributes, $attr)).'>'.
            $subtitle.
        '</h2>';
    }
}
