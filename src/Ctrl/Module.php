<?php

namespace Ctrl;

use Zend\ServiceManager\ServiceLocatorInterface;
use Ctrl\Mvc\View\Http\InjectTemplateListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        /** @var $serviceManager \Zend\ServiceManager\ServiceManager */
        $serviceManager = $application->getServiceManager();

        $this->initModules($serviceManager);
        $this->setPhpSettings($serviceManager);
        $this->initLog($serviceManager);
        $this->initControllers($serviceManager);
    }

    protected function initLog(\Zend\ServiceManager\ServiceManager $serviceManager)
    {
        $config      = $serviceManager->get('Configuration');
        $c = $config['app_log'];
        /** @var $logger \Ctrl\Log\Logger */
        $logger = new $c['class']();
        foreach ($c['writers'] as $wr) {
            $logger->addWriter(
                $wr['writer'],
                (isset($wr['priority']) ? $wr['priority']: 1),
                (isset($wr['options']) ? $wr['options']: array())
            );
        }
        if (isset($c['registerErrorHandler']) && $c['registerErrorHandler']) {
            $logger->registerErrorHandler($logger);
        }
        if (isset($c['registerExceptionHandler']) && $c['registerExceptionHandler']) {
            $logger->registerExceptionHandler($logger);
        }
        $serviceManager->setService('log', $logger);
    }

    protected function initControllers(ServiceLocatorInterface $serviceManager)
    {
        // Add initializer to Controller ServiceManager
        $serviceManager->get('ControllerLoader')->addInitializer(function ($instance) use ($serviceManager) {
            if (method_exists($instance, 'setEntityManager')) {
                $instance->setEntityManager($serviceManager->get('doctrine.entitymanager.orm_default'));
            }
            if (method_exists($instance, 'setLogger')) {
                $instance->setLogger($serviceManager->get('log'));
            }
        });
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
            'view_helpers' => array(
                'invokables' => array(
                    'CtrlNavigation' => 'Ctrl\View\Helper\Navigation\Navigation',
                    'PageTitle' => 'Ctrl\View\Helper\TwitterBootstrap\PageTitle',
                    'CtrlJsLoader' => 'Ctrl\CtrlJs\ViewHelper\CtrlJsLoader',
                    'CtrlFormInput' => 'Ctrl\View\Helper\TwitterBootstrap\Form\CtrlFormInput',
                    'CtrlForm' => 'Ctrl\View\Helper\TwitterBootstrap\Form\CtrlForm',
                    'CtrlButton' => 'Ctrl\View\Helper\TwitterBootstrap\Form\CtrlButton',
                    'CtrlFormActions' => 'Ctrl\View\Helper\TwitterBootstrap\Form\CtrlFormActions',
                    'FormatDate' => 'Ctrl\View\Helper\FormatDate',
                    'OrderControls' => 'Ctrl\View\Helper\TwitterBootstrap\OrderControls',
                ),
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
            ),
        );
    }

    public static function getDefaultModuleRouterConfig($defaultNamespace, $prefix = '')
    {

    }
}
