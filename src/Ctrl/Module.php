<?php

namespace Ctrl;

use Zend\ServiceManager\ServiceLocatorInterface;
use Ctrl\Mvc\View\Http\InjectTemplateListener;
use Zend\Mvc\MvcEvent;
use Ctrl\EntityManager\PostLoadSubscriber;

class Module
{
    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        /** @var $serviceManager \Zend\ServiceManager\ServiceManager */
        $serviceManager = $application->getServiceManager();

        $this->initModules($serviceManager);
        $this->setPhpSettings($serviceManager);
        $this->initDoctrine($serviceManager);

        $serviceManager->setAlias('EntityManager', 'doctrine.entitymanager.orm_default');
    }

    protected function initDoctrine(ServiceLocatorInterface $serviceManager)
    {
        /** @var $entityManager \Doctrine\ORM\EntityManager */
        $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $entityManager->getEventManager()->addEventListener(
            array(\Doctrine\ORM\Events::postLoad),
            new PostLoadSubscriber($serviceManager)
        );
    }

    protected function initModules(ServiceLocatorInterface $serviceManager)
    {
        $injectTemplateListener = new InjectTemplateListener();

        $eventManager = $serviceManager->get('Application')->getEventManager();
        $sharedEvents = $eventManager->getSharedManager();
        $sharedEvents->attach('Zend\Stdlib\DispatchableInterface', MvcEvent::EVENT_DISPATCH, array($injectTemplateListener, 'injectTemplate'), -81);
    }

    protected function setPhpSettings($serviceManager)
    {
        $config      = $serviceManager->get('Configuration');
        $phpSettings = $config['phpSettings'];
        if($phpSettings) {
            foreach($phpSettings as $key => $value) {
                ini_set($key, $value);
            }
        }
    }

    public function getConfig()
    {
        return array(
            'phpSettings' => array(
                'date.timezone' => 'UTC',
            ),
            'controller_plugins' => array(
                'invokables' => array(
                    'CtrlRedirect' => 'Ctrl\Mvc\Controller\Plugin\Redirect',
                ),
                'aliases' => array(
                    'redirect' => 'CtrlRedirect'
                )
            ),
            'view_helpers' => array(
                'invokables' => array(
                    'CtrlNavigation' => 'Ctrl\View\Helper\Navigation\Navigation',
                    'Navigation' => 'Ctrl\View\Helper\Navigation\Navigation',
                    'FormatDate' => 'Ctrl\View\Helper\FormatDate',
                    'CtrlJsLoader' => 'Ctrl\CtrlJs\ViewHelper\CtrlJsLoader',
                    'PageTitle' => 'Ctrl\View\Helper\TwitterBootstrap\PageTitle',
                    'CtrlFormInput' => 'Ctrl\View\Helper\TwitterBootstrap\Form\CtrlFormInput',
                    'CtrlForm' => 'Ctrl\View\Helper\TwitterBootstrap\Form\CtrlForm',
                    'CtrlButton' => 'Ctrl\View\Helper\TwitterBootstrap\Form\CtrlButton',
                    'CtrlFormActions' => 'Ctrl\View\Helper\TwitterBootstrap\Form\CtrlFormActions',
                    'OrderControls' => 'Ctrl\View\Helper\TwitterBootstrap\OrderControls',
                ),
                'aliases' => array(
                    'navigation' => 'CtrlNavigation'
                )
            ),
            'app_log' => array(
                'class' => '\Ctrl\Log\Logger',
                'writers' => array(
                    array (
                        'writer' => 'stream',
                        'options' => array('stream' => 'php://stderr'),
                    ),
                ),
                'registerErrorHandler' => false,
                'registerExceptionHandler' => false,
            ),
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../',
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'DomainServiceLoader'       => 'Ctrl\Service\DomainServiceLoaderFactory',
                'CtrlAcl'                   => 'Ctrl\Permissions\AclFactory',
                'Log'                       => 'Ctrl\Log\LogFactory',
            ),
            'aliases' => array(
                'Acl' => 'CtrlAcl'
            )
        );
    }
}
