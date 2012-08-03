<?php

namespace Ctrl\Form\Element;

use Zend\Form\ElementInterface as ZendElementInterface;
use Ctrl\Form\Form;

interface ElementInterface extends ZendElementInterface
{
    /**
     * @param Form $form
     * @return ElementInterface
     */
    public function setForm(Form $form);

    /**
     * @return Form
     */
    public function getForm();
}
