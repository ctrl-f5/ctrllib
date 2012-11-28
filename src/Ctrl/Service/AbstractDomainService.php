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

    /**
     * Move  models in an ordered collection
     *
     * @param $collection
     * @param $id
     * @param $dir
     * @param array $methods
     * @return mixed
     */
    public function switchOrderInCollection($collection, $id, $dir, $methods = array('getOrder', 'setOrder'))
    {
        if (count($methods) == 2) {
            //prepare for war
            $get = reset($methods);
            $set = end($methods);
            $getBy = function ($collection, $method, $value) {
                foreach ($collection as $model) {
                    if (method_exists($model, $method)) {
                        if ($model->$method() == $value) return $model;
                    }
                }
                return false;
            };

            //get order of source model and check its validity
            $from = $getBy($collection, 'getId', $id);
            $order = $from->$get();
            if (($order >= count($collection) && $dir == 'down') || ($order <= 1 && $dir == 'up')) {
                return $collection;
            }

            if ($dir == 'up') $order--;
            elseif ($dir == 'down') $order++;

            //switch the orders
            $to = $getBy($collection, $get, $order);
            $to->$set($from->$get());
            $from->$set($order);
        }

        return $collection;
    }
}
