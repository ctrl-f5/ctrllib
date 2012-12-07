<?php

namespace Ctrl\View\Helper\TwitterBootstrap;

use Ctrl\View\Helper\OrderControls as BaseOrderControls;

class OrderControls extends BaseOrderControls
{
    protected $defaulElementAttributes = array(
        'class' => 'btn'
    );

    protected function createUp($route, $params = array(), $attr = array())
    {
        $params['dir'] = 'up';
        $attr['label'] = '<i class="icon-circle-arrow-up"></i>';
        return $this->create(
            $this->view->url($route, $params),
            $attr
        );
    }

    protected function createDown($route, $params = array(), $attr = array())
    {
        $params['dir'] = 'down';
        $attr['label'] = '<i class="icon-circle-arrow-down"></i>';
        return $this->create(
            $this->view->url($route, $params),
            $attr
        );
    }
}
