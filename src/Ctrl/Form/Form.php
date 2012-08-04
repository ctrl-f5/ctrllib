<?php

namespace Ctrl\Form;

use Zend\Form\Form as ZendForm;
use Ctrl\Form\Element\ElementInterface;

class Form extends ZendForm
{
    /**
     * @var string
     */
    protected $returnUrl;

    /**
     * @var string
     */
    protected $label;

    /**
     * @return array|\Traversable|ElementInterface[]
     */
    public function getElements()
    {
        return parent::getElements();
    }

    /**
     * @param array|\Traversable|ElementInterface $elementOrFieldset
     * @param array $flags
     * @return void|\Zend\Form\Fieldset|\Zend\Form\FieldsetInterface|\Zend\Form\FormInterface
     */
    public function add($elementOrFieldset, array $flags = array())
    {
        if ($elementOrFieldset instanceof ElementInterface) {
            $elementOrFieldset->setForm($this);
        }
        parent::add($elementOrFieldset, $flags);
    }

    public function setReturnUrl($url)
    {
        $this->returnUrl = $url;
        return $this;
    }

    public function getReturnurl()
    {
        return $this->returnUrl;
    }

    /**
     * @param $label
     * @return Form
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}