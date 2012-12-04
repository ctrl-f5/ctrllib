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
        return parent::create(
            $this->createTitle($title, $attr) . $this->createSubtitle($subtitle, $attr)
        );
    }

    protected function createTitle($title, $attr = array())
    {
        '<h1'.$this->htmlAttribs($this->_mergeAttributes($this->defaulElementAttributes, $attr)).'>'.
            $title.
        '</h1>';
    }

    protected function createSubtitle($subtitle, $attr = array())
    {
        '<h2'.$this->htmlAttribs($this->_mergeAttributes($this->defaulSubtitleAttributes, $attr)).'>'.
            $subtitle.
        '</h2>';
    }
}
