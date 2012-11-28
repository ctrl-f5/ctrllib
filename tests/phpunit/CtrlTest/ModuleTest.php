<?php

namespace CtrlTest;

class ModuleTest extends ApplicationTest
{
    public function testCanRetrieveDomainServiceLoader()
    {
        $loader = $this->application->getServiceManager()->get('DomainServiceLoader');
        $this->assertInstanceOf('\Zend\ServiceManager\ServiceManager', $loader);
    }

    public function testHasOverridenDefaultRedirectControllerPlugin()
    {
        $loader = $this->application->getServiceManager()->get('ControllerPluginManager');
        $redirectPlugin = $loader->get('Redirect');
        $this->assertInstanceOf('\Ctrl\Mvc\Controller\Plugin\Redirect', $redirectPlugin);
    }

    public function testHasOverridenDefaultNavigationViewHelper()
    {
        $loader = $this->application->getServiceManager()->get('ViewHelperManager');
        $navHelper = $loader->get('Navigation');
        $this->assertInstanceOf('\Ctrl\View\Helper\Navigation\Navigation', $navHelper);
    }

    public function testHasInitialisedDoctrine()
    {
        $entityManager = $this->application->getServiceManager()->get('EntityManager');
        $this->assertInstanceOf('\Doctrine\Orm\EntityManager', $entityManager);
    }
}
