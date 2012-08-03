<?php

namespace Ctrl\Form\Element;

use Ctrl\Form\Element\ElementInterface;
use Zend\Form\Element as ZendElement;
use Ctrl\Form\Form;

class Element extends ZendElement
    implements ElementInterface
{
    /**
     * @var Form
     */
    protected $form;

    /**
     * @param Form $form
     * @return Element
     */
    public function setForm(Form $form)
    {
        $this->form = $form;
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }
}
