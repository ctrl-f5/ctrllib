<?php

namespace Ctrl\View\Helper\TwitterBootstrap\Form;

use Ctrl\View\Helper\Form\CtrlButton as BaseButton;

class CtrlButton extends BaseButton
{
    protected $defaulElementAttributes = array(
        'class' => array('btn')
    );

    protected $styleAttributes = array(
        'normal' => array(
            //'class' => array('btn-')
        ),
        'primary' => array(
            'class' => array('btn-primary')
        ),
        'info' => array(
            'class' => array('btn-info')
        ),
        'danger' => array(
            'class' => array('btn-danger')
        ),
        'grant' => array(
            'class' => array('btn-success')
        ),
    );

    public function __invoke($type, $attr = array(), $style = 'normal')
    {
        $style = isset($this->styleAttributes[$style]) ? $this->styleAttributes[$style] : array();
        if (isset($attr['confirm']) && $attr['confirm']) {
            if (isset($attr['class'])) $attr['class'] = (array)$attr['class'];
            $attr['class'] = 'ctrljs-confirm';
        }
        $attr = $this->_mergeAttributes(array($style, $attr));
        return $this->create($type, $attr);
    }
}
