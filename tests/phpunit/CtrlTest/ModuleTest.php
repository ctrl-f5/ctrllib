<?php

namespace CtrlTest;

class ModuleTest extends ApplicationTest
{
    public function testCanRetrieveDomainServiceLoader()
    {
        $loader = $this->getServiceManager()->get('DomainServiceLoader');
        $this->assertInstanceOf('\Zend\ServiceManager\ServiceManager', $loader);
    }

    public function testHasOverridenDefaultRedirectControllerPlugin()
    {
        $loader = $this->getServiceManager()->get('ControllerPluginManager');
        $redirectPlugin = $loader->get('Redirect');
        $this->assertInstanceOf('\Ctrl\Mvc\Controller\Plugin\Redirect', $redirectPlugin);
    }

    public function testHasOverridenDefaultNavigationViewHelper()
    {
        $loader = $this->getServiceManager()->get('ViewHelperManager');
        $navHelper = $loader->get('Navigation');
        $this->assertInstanceOf('\Ctrl\View\Helper\Navigation\Navigation', $navHelper);
    }
}
