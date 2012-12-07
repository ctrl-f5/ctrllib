<?php

namespace Ctrl\View\Helper;

use Ctrl\View\Helper\AbstractHtmlElement;

class OrderControls extends AbstractHtmlElement
{
    public function __invoke($route, $params = array(), $attr = array())
    {
        return $this->createUp($route, $params, $attr).
            PHP_EOL.
            $this->createDown($route, $params, $attr);
    }

    protected function createUp($route, $params = array(), $attr = array())
    {
        $attr['label'] = 'down';
        return $this->create(
            $this->view->url($route, $params),
            $attr
        );
    }

    protected function createDown($route, $params = array(), $attr = array())
    {
        $attr['label'] = 'up';
        return $this->create(
            $this->view->url($route, $params),
            $attr
        );
    }

    protected function create($url, $attr = array())
    {
        $label = $attr['label'];
        unset($attr['label']);
        $attr['href'] = $url;
        $html = '<a'.$this->htmlAttribs($this->_getElementAttr(null, $attr)).'">'.
            $label.
            '</a>';
        return $html;
    }
}
