<?php

namespace Ctrl\View\Helper\TwitterBootstrap\Form;

use Ctrl\View\Helper\Form\CtrlButton as BaseButton;

class CtrlButton extends BaseButton
{
    protected $defaulAttributes = array(
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
        )
    );

    public function __invoke($type, $attr = array(), $style = 'normal')
    {
        $style = isset($this->styleAttributes[$style]) ? $this->styleAttributes[$style] : array();
        if (isset($attr['confirm']) && $attr['confirm']) {
            if (isset($attr['class'])) $attr['class'] = (array)$attr['class'];
            $attr['class'] = 'ctrljs-confirm';
        }
        $attr = $this->_cleanupAttributes(array_merge_recursive($this->defaulAttributes, $style, $attr));
        switch ($type) {
            case 'submit':
                return $this->createSubmit($attr);
                break;
            case 'link':
                return $this->createlink($attr);
                break;
            case 'button':
            default:
                return $this->createButton($attr);
                break;
        }
    }
}
