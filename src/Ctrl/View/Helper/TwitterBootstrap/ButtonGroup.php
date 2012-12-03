<?php

namespace Ctrl\View\Helper\TwitterBootstrap;

use Zend\View\Helper\AbstractHtmlElement as ZendAbstractHtmlElement;
use Ctrl\View\Helper\AbstractHtmlElement;

class ButtonGroup extends AbstractHtmlElement
{
    protected $defaultContainerAttributes = array(
        'class' => 'btn-group'
    );

    public function __invoke($buttons = array(), $attr = array())
    {
        $html = $this->create($buttons, $attr);

        return $html;
    }

    protected function create($buttons = array(), $attr = array())
    {
        if (!isset($attr['container']) && isset($attr['pull-right']) && $attr['pull-right']) {
            $attr['container']['class'] = 'pull-right';
        }
        return '<div '.$this->htmlAttribs($this->_getContainerAttr(null, $attr)).'>'.
            implode(PHP_EOL, $buttons).
        '</div>';
    }
}
