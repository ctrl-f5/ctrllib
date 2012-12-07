<?php

namespace Ctrl\View\Helper;

use Zend\View\Helper\AbstractHtmlElement as ZendAbstractHtmlElement;
use Ctrl\View\Helper\AbstractHtmlElement;

class ButtonGroup extends AbstractHtmlElement
{
    public function __invoke($buttons = array(), $attr = array())
    {
        $html = $this->create($buttons, $attr);

        return $html;
    }

    protected function create($buttons = array(), $attr = array())
    {
        if (is_string($buttons)) {
            $buttons = array($buttons);
        }
        return '<div '.$this->htmlAttribs($this->_getContainerAttr(null, $attr)).'>'.
            implode(PHP_EOL, $buttons).
        '</div>';
    }
}
