<?php

namespace Ctrl\View\Helper\Form;

use Zend\Form\ElementInterface;
use Ctrl\Form\Element\ElementInterface as CtrlElement;
use Ctrl\View\Helper\AbstractHtmlElement;
use Ctrl\Form\Form;

class CtrlForm extends AbstractHtmlElement
{
    protected $defaultContainerAttributes = array();

    protected $defaulElementAttributes = array();

    protected $defaulLabelAttributes = array();

    protected $startedForms = array();

    public function __invoke()
    {
        return $this;
    }

    public function start(Form $form, $containerAttr = array(),$elementAttr = array(), $labelAttr = array())
    {
        $this->startedForms[spl_object_hash($form)] = array(
            'container' => $containerAttr,
            'element' => $elementAttr,
            'label' => $labelAttr
        );
        $html = $this->createStart($form, $containerAttr, $elementAttr, $labelAttr);

        return $html;
    }

    public function end(Form $form)
    {
        $hash = spl_object_hash($form);
        $cache = isset($this->startedForms[$hash]) ? $this->startedForms[$hash] : array();
        $containerAttr = isset($cache['container']) ? $cache['container'] : array();
        $elementAttr = isset($cache['element']) ? $cache['element'] : array();
        $labelAttr = isset($cache['label']) ? $cache['label'] : array();

        $html = $this->createEnd($form, $containerAttr, $elementAttr, $labelAttr);

        return $html;
    }

    protected function createStart(Form $form, $containerAttr = array(),$formAttr = array(), $labelAttr = array())
    {
        return '<div'.
            $this->_htmlAttribs(
                $this->_cleanupAttributes(
                    array_merge_recursive($this->defaultContainerAttributes, $containerAttr)
                )
            ).
            '>'.
            $this->createElement($form, $formAttr).
            '<fieldset>'.
            $this->createLabel($form, $labelAttr);
    }

    protected function createEnd(Form $form, $containerAttr = array(),$elementAttr = array(), $labelAttr = array())
    {
        return '</fieldset></form></div>';
    }

    protected function createLabel(Form $form, $labelAttr = array())
    {
        return '<legend>'.$form->getName().'</legend>';
    }

    protected function createElement(Form $form, $formtAttr = array())
    {
        return $this->view->form($form);
    }
}
