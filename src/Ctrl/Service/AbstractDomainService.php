<?php

namespace Ctrl\Service;

use Ctrl\Service\AbstractDomainModelService;
use Zend\ServiceManager;
use Zend\ServiceManager\ServiceLocatorInterface;

use Doctrine\ORM\EntityManager;

abstract class AbstractDomainService implements
    ServiceManager\ServiceLocatorAwareInterface,
    \Ctrl\ServiceManager\EntityManagerAwareInterface
{
    /**
     * @var ServiceLocatorInterFace
     */
    protected $serviceLocator = null;

    /**
     * @var EntityManager
     */
    protected $entityManager = null;

    /**
     * @param EntityManager $manager
     * @return AbstractService
     */
    public function setEntityManager(EntityManager $manager)
    {
        $this->entityManager = $manager;
        return $this;
    }

    /**
     * @return EntityManager|null
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param ServiceLocatorInterFace $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterFace $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @returns ServiceLocatorInterFace
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Retrieves a registered DomainService by name
     *
     * @param $serviceName
     * @return AbstractDomainService|AbstractDomainModelService
     */
    public function getDomainService($serviceName)
    {
        $manager = $this->getServiceLocator()->get('DomainServiceLoader');
        return $manager->get($serviceName);
    }
}
