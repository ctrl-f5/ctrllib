<?php

namespace Ctrl\View\Helper\TwitterBootstrap;

use Ctrl\View\Helper\PageTitle as BasePageTitle;

class PageTitle extends BasePageTitle
{
    protected $defaulTitleAttributes = array();

    protected function create($title, $subtitle = null, $attr = array())
    {
        $level = (isset($attr['level']) && is_int($attr['level'])) ?
            $attr['level']:
            1;

        $attr = array_merge_recursive(
            ($level == 1 ?
                array('class' => 'page-header'):
                array('class' => 'page-title')
            ),
            $this->defaulTitleAttributes,
            $attr
        );
        $html = '<div'.
            $this->_htmlAttribs(
                $this->_cleanupAttributes(
                    array_merge_recursive($this->defaulTitleAttributes, $attr)
                )
            ).'"><h'.$level.'>'.
            $title;
        if ($subtitle) {
            $html .= '<small> '.$subtitle.'</small>';
        }
        $html .= '</h'.$level.'></div>';

        return $html;
    }
}
