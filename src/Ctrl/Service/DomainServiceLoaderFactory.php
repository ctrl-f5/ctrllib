<?php

namespace Ctrl\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config;
use Zend\EventManager\EventManagerAwareInterface;
use Ctrl\ServiceManager\EntityManagerAwareInterface;

class DomainServiceLoaderFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface|ServiceManager $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $serviceConfig = new Config(
            isset($config['domain_services']) ? $config['domain_services'] : array()
        );

        $domainServiceFactory = new ServiceManager($serviceConfig);
        $serviceLocator->addPeeringServiceManager($domainServiceFactory);

        $domainServiceFactory->addInitializer(function ($instance) use ($serviceLocator) {
            if ($instance instanceof ServiceLocatorAwareInterface)
                $instance->setServiceLocator($serviceLocator->get('Zend\ServiceManager\ServiceLocatorInterface'));

            if ($instance instanceof EventManagerAwareInterface)
                $instance->setEventManager($serviceLocator->get('EventManager'));

            if ($instance instanceof EntityManagerAwareInterface)
                $instance->setEntityManager($serviceLocator->get('doctrine.entitymanager.orm_default'));
        });

        return $domainServiceFactory;
    }
}
