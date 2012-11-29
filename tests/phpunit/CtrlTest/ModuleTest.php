<?php

namespace CtrlTest;

class ModuleTest extends ApplicationTestCase
{
    public function testCanRetrieveDomainServiceLoader()
    {
        $loader = $this->getApplicationServiceManager()->get('DomainServiceLoader');
        $this->assertInstanceOf('\Zend\ServiceManager\ServiceManager', $loader);
    }

    public function testHasOverridenDefaultRedirectControllerPlugin()
    {
        $loader = $this->getApplicationServiceManager()->get('ControllerPluginManager');
        $redirectPlugin = $loader->get('Redirect');
        $this->assertInstanceOf('\Ctrl\Mvc\Controller\Plugin\Redirect', $redirectPlugin);
    }

    public function testHasOverridenDefaultNavigationViewHelper()
    {
        $loader = $this->getApplicationServiceManager()->get('ViewHelperManager');
        $navHelper = $loader->get('Navigation');
        $this->assertInstanceOf('\Ctrl\View\Helper\Navigation\Navigation', $navHelper);
    }
}
