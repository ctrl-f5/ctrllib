<?php

namespace Ctrl\View\Helper\TwitterBootstrap\Form;

use Ctrl\View\Helper\Form\CtrlFormInput as BaseInput;
use Zend\Form\Element as ZendElement;
use Ctrl\Form\Element\Element;
use Zend\Form\View\Helper\FormInput;
use Zend\Form\View\Helper\FormSelect;

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

    protected function create($element, $attr = array())
    {
        if (isset($attr['bare']) && $attr['bare']) {
            return parent::createElement($element, $attr);
        }
        if ($element instanceof Element) {
            if ($element->getForm()->getMessages($element->getName())) {
                $tmpAttr = (isset($attr['container'])) ? $attr['container']: array();
                $attr['container'] = $this->_mergeAttributes(array(
                    array('class' => 'error'),
                    $tmpAttr
                ));
            }
            $filter = $element->getForm()->getInputFilter()->getMessages();
            if (isset($filter[$element->getName()])) {
                $element->setAttribute('data-validation-msg', \reset($filter[$element->getName()]));
            }
        }
        if ($this->isRequired($element)) {
            $attr = $this->_mergeAttributes(array(
                array('class' => 'required'),
                $attr
            ));
        }

        return parent::create($element, $attr);
    }

    protected function createElement(ZendElement $element, $attr = array())
    {
        if ($element instanceof Element && $element->getAttribute('type') == 'hidden') {
            return parent::createElement($element, $attr);
        }
        return '<div class="controls">'.parent::createElement($element, $attr).'</div>';
    }

    protected function createLabel(ZendElement $element, $attr = array())
    {
        $required = '';
        $required = ($this->isRequired($element)) ? '<span>*</span>' : '';

        return '<label '.$this->htmlAttribs($this->_getLabelAttr($element, $attr)).'>'.
            $element->getLabel().$required.
            '</label>';
    }
}
