<?php

namespace Ctrl\View\Helper\Navigation;

use Zend\View\Helper\Navigation\PluginManager as ZendPluginManager;

class PluginManager extends ZendPluginManager
{
    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = array(
        'breadcrumbs' => 'Zend\View\Helper\Navigation\Breadcrumbs',
        'links'       => 'Zend\View\Helper\Navigation\Links',
        'menu'        => 'Ctrl\View\Helper\Navigation\Menu',
        'sitemap'     => 'Zend\View\Helper\Navigation\Sitemap',
    );
}
