<?php

namespace Ctrl\View\Helper\TwitterBootstrap\Form;

use Ctrl\View\Helper\Form\CtrlFormErrors as BaseFormErrors;

class CtrlFormErrors extends BaseFormErrors
{
    protected $defaultContainerAttributes = array(
        'class' => 'alert alert-error',
    );

    protected function createErrorList($errors = array(), $attr = array())
    {
        $html = array();
        foreach ($errors as $field => $fieldErrors) {
            foreach ($fieldErrors as $validator => $message) {
                $html[] = '<h4>'.$field.'</h4>';
                $html[] = $message;
            }
        }

        return implode(PHP_EOL, $html);
    }
}
