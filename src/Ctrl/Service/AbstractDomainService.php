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
