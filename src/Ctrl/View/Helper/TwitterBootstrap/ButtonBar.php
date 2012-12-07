<?php

namespace Ctrl\View\Helper\TwitterBootstrap;

use Ctrl\View\Helper\ButtonBar as BaseButtonBar;

class ButtonBar extends BaseButtonBar
{
    protected $defaultContainerAttributes = array(
        'class' => 'btn-toolbar'
    );

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
