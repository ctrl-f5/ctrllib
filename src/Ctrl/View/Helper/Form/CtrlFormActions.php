<?php

namespace Ctrl\View\Helper\Form;

use Zend\Form\ElementInterface;
use Ctrl\Form\Element\ElementInterface as CtrlElement;
use Ctrl\View\Helper\AbstractHtmlElement;
use Ctrl\Form\Form;

class CtrlFormActions extends AbstractHtmlElement
{
    protected function createElement($content, $attr = array())
    {
        return implode(' ', (array)$content);
    }
}
