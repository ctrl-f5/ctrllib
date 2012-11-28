<?php

namespace Ctrl\Log;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Log\LoggerInterface;

class LogFactory implements FactoryInterface
{
    const DEFAULT_LOG_CLASS = '\Ctrl\Log\Logger';

    /**
     * Create Log Service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Logger|LoggerInterface
     * @throws \Ctrl\Exception
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // fetch application config and check for log configuration
        $config = $serviceLocator->get('Configuration');
        if (!isset($config['app_log'])) {
            throw new \Ctrl\Exception('can\'t create log service: no config found');
        }
        // descent to the log configuration
        $config = $config['app_log'];

        /**
         * check if the config provides a custom logger class
         * and check the created class against the constraints
         */
        $class = (isset($config['class'])) ? $config['class'] : self::DEFAULT_LOG_CLASS;

        // does it even exist?
        if (!class_exists($class)) {
            throw new \Ctrl\Exception('Invalid class provider in app_log config: '.$class);
        }

        // create and check for logger interface
        /** @var $logger \Ctrl\Log\Logger */
        $logger = new $config['class']();
        if (!($logger instanceof LoggerInterface)) {
            throw new \Ctrl\Exception('log class must implement \Zend\Log\LoggerInterface');
        }

        // add writers if any are configured
        if (isset($config['writers'])) {
            foreach ($config['writers'] as $wr) {
                $logger->addWriter(
                    $wr['writer'],
                    (isset($wr['priority']) ? $wr['priority']: 1),
                    (isset($wr['options']) ? $wr['options']: array())
                );
            }
        }

        // register global error and exception handlers if needed
        if (isset($config['registerErrorHandler']) && $config['registerErrorHandler']) {
            $logger->registerErrorHandler($logger);
        }
        if (isset($config['registerExceptionHandler']) && $config['registerExceptionHandler']) {
            $logger->registerExceptionHandler($logger);
        }

        // ready for some logging
        return $logger;
    }
}
