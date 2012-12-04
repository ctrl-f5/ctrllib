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
        $html = array();
        $html[] = $this->start($element, $attr);
        foreach ($element->getElements() as $el) {
            $html[] = $this->view->ctrlFormInput($el);
        }
        $html[] = $this->end($element, $actions);

        return implode(PHP_EOL, $html);
    }

    public function start(Form $form, $attr = array())
    {
        $this->startedForms[spl_object_hash($form)] = $attr;
        $html = $this->createStart($form, $attr);

        if (!isset($attr['combined-errors']) || $attr['combined-errors']) {
            $html .= PHP_EOL . $this->view->ctrlFormErrors($form);
        }

        return $html;
    }

    public function end(Form $form, $actions = array())
    {
        $hash = spl_object_hash($form);
        $attr = isset($this->startedForms[$hash]) ? $this->startedForms[$hash] : array();
        unset($this->startedForms[$hash]);

        $html = $this->createEnd($form, $attr, $actions);

        return $html;
    }

    public function createStart(Form $form, $attr = array())
    {
        return '<div'.
            $this->htmlAttribs($this->_getContainerAttr($form, $attr)).
            '>'.PHP_EOL.
            $this->createElement($form, $attr).PHP_EOL.
            '<fieldset>'.PHP_EOL.
            $this->createLabel($form, $attr);
    }

    protected function getDefaultActions($form)
    {
        return array(
            $this->view->ctrlButton('submit', array('value' => 'save'), 'primary'),
            $this->view->ctrlButton('link', array('value' => 'cancel', 'href' => $form->getReturnUrl()))
        );
    }

    public function createEnd(Form $form, $attr = array(), $actions = array())
    {
        if ($actions === true) {
            $actions = $this->getDefaultActions($form);
        }
        if (!is_array($actions)) {
            throw new \Ctrl\Exception('$actions must be an array of options or true for default actions');
        }
        $html[] = $this->view->ctrlFormActions($actions);
        $html[] = '</fieldset></form></div>';
        return implode(PHP_EOL, $html);
    }

    public function createLabel(Element $form, $attr = array())
    {
        return '<legend>'.$form->getLabel().'</legend>';
    }

    public function createElement(Element $form, $attr = array())
    {
        $tmpAttr = $form->getAttributes();
        $form->setAttributes($this->_getElementAttr($form, $attr));
        $html = $this->view->form()->openTag($form);
        $form->setAttributes($tmpAttr);
        return $html;
    }
}
