<?php

namespace Ctrl\Domain;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

abstract class PersistableServiceLocatorAwareModel
    extends PersistableModel
    implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return ServiceLocatorAwareModel
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Returns a registered DomainService
     *
     * @param string $serviceName
     * @return AbstractDomainService|AbstractDomainModelService
     */
    public function getDomainService($serviceName)
    {
        $manager = $this->getServiceLocator()->get('DomainServiceLoader');
        return $manager->get($serviceName);
    }
}
