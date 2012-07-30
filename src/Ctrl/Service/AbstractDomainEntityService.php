<?php

namespace Ctrl\Service;

use Zend\ServiceManager;

abstract class AbstractDomainEntityService extends AbstractDomainService
{
    protected $entity = '';

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT e FROM '.$this->entity.' e')
            ->getResult();
    }

    public function getById($id)
    {
        $entities = $this->getEntityManager()
            ->createQuery('SELECT e FROM '.$this->entity.' e WHERE e.id = :id')
            ->setParameter('id', $id)
            ->getResult();
        return $entities[0];
    }
}
