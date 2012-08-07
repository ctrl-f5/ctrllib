<?php

namespace Ctrl\View;

/**
 * this class is just a dummy to be used for code completion in
 * view scripts
 */
class PhpView extends \Zend\View\Renderer\PhpRenderer
{
    /**
     * @return string
     */
    public function url($route, $params) {}
    /**
     * @return string
     */
    public function formatDate($date, $format = null) {}
    /**
     * @return string
     */
    public function pageTitle($title, $subtitle = null, $options = array()){}
    /**
     * @return string
     */
    public function orderControls($route, $params = array(), $attr = array()){}
    /**
     * @return string
     */
    public function ctrlFormInput($element, $containerAttr = array(), $elemAttr = array(), $labelAttr = array()){}
    /**
     * @return string
     */
    public function ctrlButton($type, $attr = array(), $style = null){}
    /**
     * @return string
     */
    public function ctrlFormActions($content, $attr = array()){}
    /**
     * @return \Ctrl\View\Helper\TwitterBootstrap\Form\CtrlForm
     */
    public function ctrlForm(){}
}
