<?php

namespace Ctrl\View\Helper\Form;

use Zend\Form\ElementInterface;
use Ctrl\Form\Element\ElementInterface as CtrlElement;
use Ctrl\View\Helper\AbstractHtmlElement;
use Ctrl\Form\Form;

class CtrlFormErrors extends AbstractHtmlElement
{
    protected function create($elements, $attr = array())
    {
        $errors = $this->createErrors($elements, $attr);
        if (trim($errors)) {
            return parent::create($this->createErrors($elements, $attr), $attr);
        }
    }

    protected function createErrors($elements = array(), $attr = array())
    {
        $errors = array();
        /** @var $e \Ctrl\Form\Element\Element */
        foreach ($elements as $e) {
            if ($e instanceof \Zend\Form\Element && $e->getMessages()) {
                $errors[$e->getLabel()] = $e->getMessages();
            }
        }
        if (!count($errors)) return '';

        return $this->createErrorList($errors, $attr);
    }

    protected function createErrorList($errors = array(), $attr = array())
    {
        $html[] = '<ul>';
        foreach ($errors as $field => $fieldErrors) {
            $html[] = '<li>';
            $html[] = '<label>'.$field.'</label>';
            $html[] = '<ul>';
            foreach ($fieldErrors as $validator => $message) {
                $html[] = '<li>';
                $html[] = $message;
                $html[] = '</li>';
            }
            $html[] = '</ul>';
            $html[] = '</li>';
        }
        $html[] = '</ul>';

        return implode(PHP_EOL, $html);
    }
}
