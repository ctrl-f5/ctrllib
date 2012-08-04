<?php

namespace Ctrl\View\Helper\TwitterBootstrap\Form;

use Zend\Form\ElementInterface;
use Ctrl\Form\Element\ElementInterface as CtrlElement;
use Ctrl\View\Helper\AbstractHtmlElement;
use Ctrl\Form\Form;
use Ctrl\View\Helper\Form\CtrlForm as BaseForm;

class CtrlForm extends BaseForm
{
    protected $defaultContainerAttributes = array();

    protected $defaulElementAttributes = array(
        'class' => array('form-horizontal', 'ctrljs-validate')
    );

    protected $defaulLabelAttributes = array();

    protected function createElement(Form $form, $formtAttr = array())
    {
        return $this->view->form()->openTag($form->setAttributes(
            $this->_cleanupAttributes(
                array_merge_recursive(
                    $this->defaulElementAttributes,
                    $form->getAttributes(),
                    $formtAttr
                )
            )
        ));
    }
}
