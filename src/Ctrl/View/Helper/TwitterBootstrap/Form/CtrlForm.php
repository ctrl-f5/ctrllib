<?php

namespace Ctrl\View\Helper\TwitterBootstrap\Form;

use Zend\Form\ElementInterface;
use Ctrl\Form\Element\ElementInterface as CtrlElement;
use Ctrl\View\Helper\AbstractHtmlElement;
use Ctrl\Form\Form;
use Ctrl\View\Helper\Form\CtrlForm as BaseForm;

class CtrlForm extends BaseForm
{
    protected $defaulElementAttributes = array(
        'class' => array('form-horizontal', 'ctrljs-validate')
    );
}
