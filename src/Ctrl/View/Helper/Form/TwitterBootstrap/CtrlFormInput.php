<?php

namespace Ctrl\View\Helper\Form\TwitterBootstrap;

use Ctrl\View\Helper\Form\CtrlFormInput as BaseInput;
use Zend\Form\ElementInterface as ZendElementInterface;
use Ctrl\Form\Element\ElementInterface;

class CtrlFormInput extends BaseInput
{
    protected $defaultContainerAttributes = array(
        'class' => array(
            'control-group',
        ),
    );

    protected $defaulElementAttributes = array(
        'class' => array(
            'input-xxlarge',
        ),
    );

    protected $defaulLabelAttributes = array(
        'class' => array(
            'control-label',
        ),
    );

    protected function createLabel(ElementInterface $element, $labelAttr = array())
    {
        $required = '';
        if ($element instanceof \Ctrl\Form\Element\ElementInterface && $this->isRequired($element)) {
            $required = '<span>*</span>';
        }
        return '<label'.
            $this->_htmlAttribs(
                $this->_cleanupAttributes(
                    array_merge($this->defaulLabelAttributes, $labelAttr)
                )
            ).
            '>'.$element->getLabel().$required.'</label>';
    }

    /**
     * @param ElementInterface|ZendElementInterface $element
     * @param array $elementAttr
     * @return string
     */
    protected function createElement(ZendElementInterface $element, $elementAttr = array())
    {
        if ($element instanceof \Ctrl\Form\Element\ElementInterface && $this->isRequired($element)) {
            $elementAttr = array_merge_recursive(
                array('class' => array(
                    'required'
                )),
                $elementAttr
            );
        }
        return '<div class="controls">'.
            $this->view->formInput(
            $element->setAttributes(
                $this->_cleanupAttributes(
                    array_merge($this->defaulElementAttributes, $elementAttr, $element->getAttributes())
                )
            )).
            '</div>';
    }


}
