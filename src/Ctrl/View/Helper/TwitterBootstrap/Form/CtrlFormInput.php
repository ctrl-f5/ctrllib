<?php

namespace Ctrl\View\Helper\TwitterBootstrap\Form;

use Ctrl\View\Helper\Form\CtrlFormInput as BaseInput;
use Ctrl\Form\Element\ElementInterface;
use Zend\Form\ElementInterface as ZendElementInterface;
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

    protected function create(ElementInterface $element, $containerAttr = array(),$elementAttr = array(), $labelAttr = array())
    {
        if ($element->getForm()->getMessages($element->getName())) {
            $containerAttr['class'][] = 'error';
        }
        return parent::create(
            $element,
            $containerAttr,
            $elementAttr,
            $labelAttr
        );
    }

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

        //due to ZF using attributes to do some freaky stuff
        //we need to unset the options attribute before rendering
        //the html attributes
        $elAttr = $element->getAttributes();
        unset($elAttr['options']);
        $el = $element->setAttributes(
            $this->_cleanupAttributes(
                array_merge_recursive($this->defaulElementAttributes, $elementAttr, $elAttr)
            )
        );

        $inputRenderer = $this->_getElementRenderer($element->getAttribute('type'));
        return
            '<div class="controls">'.
                $inputRenderer->render($el).
            '</div>';
    }

    /**
     * @param string $type
     * @return FormInput|FormSelect
     */
    protected function _getElementRenderer($type)
    {
        switch ($type) {
            case 'select':
            default:
                return $this->view->getHelperPluginManager()->get('FormSelect');
                break;
            case 'text':
            default:
                return $this->view->getHelperPluginManager()->get('FormInput');
                break;
        }
    }
}
