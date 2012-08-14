<?php

namespace Ctrl\View\Helper\Form;

use Zend\Form\Element;
use Ctrl\Form\Element\ElementInterface as CtrlElement;
use Ctrl\View\Helper\Form\AbstractFormElement;
use Ctrl\Form\Form;

class CtrlForm extends AbstractFormElement
{
    protected $startedForms = array();

    public function __invoke($form = null, $actions = array(), $attr = array())
    {
        if ($form) {
            return $this->createForm($form, $attr);
        }
        return $this;
    }

    /**
     * @param \Ctrl\Form\Form $element
     * @param array|bool $actions
     * @param array $attr
     * @return string
     */
    public function createForm(Form $element, $actions = array(), $attr = array())
    {
        if ($actions === true) {
            $actions = array(
                $this->view->ctrlButton('submit', array('value' => 'save'), 'primary'),
                $this->view->ctrlButton('link', array('value' => 'cancel', 'href' => $element->getReturnUrl()))
            );
        }

        $html = array();
        $html[] = $this->start($element, $attr);
        foreach ($element->getElements() as $el) {
            $html[] = $this->view->ctrlFormInput($el);
        }
        $html[] = $this->view->ctrlFormActions($actions);
        $html[] = $this->end($element);

        return implode(PHP_EOL, $html);
    }

    public function start(Form $form, $attr = array())
    {
        $this->startedForms[spl_object_hash($form)] = $attr;
        $html = $this->createStart($form, $attr);

        return $html;
    }

    public function end(Form $form)
    {
        $hash = spl_object_hash($form);
        $attr = isset($this->startedForms[$hash]) ? $this->startedForms[$hash] : array();
        unset($this->startedForms[$hash]);

        $html = $this->createEnd($form, $attr);

        return $html;
    }

    public function createStart(Form $form, $attr = array())
    {
        return '<div'.
            $this->_htmlAttribs($this->_getContainerAttr($form, $attr)).
            '>'.PHP_EOL.
            $this->createElement($form, $attr).PHP_EOL.
            '<fieldset>'.PHP_EOL.
            $this->createLabel($form, $attr);
    }

    public function createEnd(Form $form, $attr = array())
    {
        return '</fieldset></form></div>';
    }

    public function createLabel(Form $form, $attr = array())
    {
        return '<legend>'.$form->getLabel().'</legend>';
    }

    public function createElement(Form $form, $attr = array())
    {
        $tmpAttr = $form->getAttributes();
        $form->setAttributes($this->_getElementAttr($form, $attr));
        $html = $this->view->form()->openTag($form);
        $form->setAttributes($tmpAttr);
        return $html;
    }
}
