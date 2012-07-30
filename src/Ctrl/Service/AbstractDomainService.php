<?php

namespace Ctrl\Service;

use Zend\ServiceManager;

abstract class AbstractDomainService implements
    ServiceManager\ServiceLocatorAwareInterface,
    \Ctrl\ServiceManager\EntityManagerAwareInterface
{
    /**
     * @var ServiceManager\ServiceLocatorInterFace
     */
    protected $serviceLocator = null;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager = null;

    /**
     * @param \Doctrine\ORM\EntityManager $manager
     * @return AbstractService
     */
    public function setEntityManager(\Doctrine\ORM\EntityManager $manager)
    {
        $this->entityManager = $manager;
        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityManager|null
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param ServiceManager\ServiceLocatorInterFace $serviceLocator
     */
    public function setServiceLocator(ServiceManager\ServiceLocatorInterFace $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @returns ServiceManager\ServiceLocatorInterFace
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function getDomainService($serviceName)
    {
        $manager = $this->getServiceLocator()->get('DomainServiceLoader');
        $serviceName .= 'DomainService';
        return $manager->get($serviceName);
    }
}
