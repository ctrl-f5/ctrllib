<?php

namespace Ctrl\View\Helper;

use Zend\View\Helper\AbstractHtmlElement as ZendAbstractHtmlElement;
use Zend\Form\ElementInterface as ZendElementInterface;
use Ctrl\Form\Element\ElementInterface;
use Ctrl\Form\Form;

abstract class AbstractHtmlElement extends ZendAbstractHtmlElement
{
    /**
     * @var \Zend\View\Renderer\PhpRenderer
     */
    protected $view;

    /**
     * converts subarrays to strings
     * seperated by a space
     *
     * @param $attr
     * @return array
     */
    protected function _cleanupAttributes($attr)
    {
        $clean = array();
        foreach ($attr as $k => $a) {
            if (is_array($a)) {
                $a = implode(' ', $a);
            }
            $clean[$k] = $a;
        }
        return $clean;
    }
}
