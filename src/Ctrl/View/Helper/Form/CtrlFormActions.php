<?php

namespace Ctrl\View\Helper\Form;

use Zend\Form\ElementInterface;
use Ctrl\Form\Element\ElementInterface as CtrlElement;
use Ctrl\View\Helper\AbstractHtmlElement;
use Ctrl\Form\Form;

class CtrlFormActions extends AbstractHtmlElement
{
    protected $defaultAttributes = array();

    public function __invoke($content = array(), $attributes = array())
    {
        if (!is_array($content)) $content = (array)$content;
        $html = $this->create($content, $attributes);

        return $html;
    }

    protected function create(array $content, $attr = array())
    {
        return '<div'.
            $this->_htmlAttribs(
                $this->_cleanupAttributes(
                    array_merge_recursive($this->defaultAttributes, $attr)
                )
            ).
            '>'.
            implode(PHP_EOL, $content).
            '</div>';
    }
}
