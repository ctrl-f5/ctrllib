<?php

namespace Ctrl\View\Helper\TwitterBootstrap;

use Ctrl\View\Helper\PageTitle as BasePageTitle;

class PageTitle extends BasePageTitle
{
    protected $defaulSubtitleAttributes = array();

    protected function create($title, $subtitle = null, $attr = array())
    {
        $level = (isset($attr['level']) && is_int($attr['level'])) ?
            $attr['level']: 1;

        if ($level == 1) {
            if (!isset($attr['container'])) $attr['container'] = array();
            $attr['container'] = $this->_mergeAttributes(array(
                    array('class' => 'page-header'),
                    $attr['container'],
                )
            );
        }

        return '<div '.$this->htmlAttribs($this->_getContainerAttr($title, $attr)).'>'.
            $this->createTitle($title, $level, $this->createSubtitle($subtitle, $attr), $attr).
        '</div>';
    }

    protected function createTitle($title, $level = 1, $subtitle = null, $attr = array())
    {
        return '<h'.$level.$this->htmlAttribs($this->_mergeAttributes($this->defaulElementAttributes, $attr)).'>'.
            $title.$subtitle.
        '</h'.$level.'>';
    }

    protected function createSubtitle($subtitle, $attr = array())
    {
        return '<small'.$this->htmlAttribs($this->_mergeAttributes($this->defaulSubtitleAttributes, $attr)).'>'.
            $subtitle.
        '</small>';
    }
}
