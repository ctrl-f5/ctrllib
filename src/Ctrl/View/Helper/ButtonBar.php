<?php

namespace Ctrl\View\Helper;

use Zend\View\Helper\AbstractHtmlElement as ZendAbstractHtmlElement;
use Ctrl\View\Helper\AbstractHtmlElement;

class ButtonBar extends AbstractHtmlElement
{
    public function __invoke($groups = array(), $attr = array())
    {
        $html = $this->create($groups, $attr);

        return $html;
    }

    protected function create($groups = array(), $subtitle = null, $attr = array())
    {
        if (is_string($groups)) {
            $groups = array($groups);
        }
        return '<div '.$this->htmlAttribs($this->_getContainerAttr(null, $attr)).'>'.
            implode(PHP_EOL, $groups).
        '</div>';
    }
}
