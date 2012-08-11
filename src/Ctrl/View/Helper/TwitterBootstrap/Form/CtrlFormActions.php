<?php

namespace Ctrl\View\Helper\TwitterBootstrap\Form;

use Ctrl\View\Helper\Form\CtrlFormActions as BaseFormActions;

class CtrlFormActions extends BaseFormActions
{
    protected $defaultAttributes = array(
        'class' => 'form-actions'
    );

    protected function create(array $content, $attr = array())
    {
        return '<div'.
            $this->_htmlAttribs(
                $this->_cleanupAttributes(
                    array_merge_recursive($this->defaultAttributes, $attr)
                )
            ).
            '>'.
            implode(PHP_EOL, $content).
            '</div>';
    }
}
