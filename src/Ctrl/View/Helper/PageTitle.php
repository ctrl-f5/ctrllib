<?php

namespace Ctrl\View\Helper;

use Ctrl\View\Helper\AbstractHtmlElement;

class PageTitle extends AbstractHtmlElement
{
    protected $defaulTitleAttributes = array();

    public function __invoke($title, $subtitle, $attr = array())
    {
        $html = $this->create($title, $subtitle, $attr);

        return $html;
    }

    protected function create($title, $subtitle = null, $attr = array())
    {
        $html = '<h1'.
            $this->_htmlAttribs(
                $this->_cleanupAttributes(
                    array_merge_recursive($this->defaulTitleAttributes, $attr)
                )
            ).'">'.
            $title.
            '</h1>';
        if ($subtitle) {
            $html .= '<h2>'.$subtitle.'</h2>';
        }
        return $html;
    }
}
