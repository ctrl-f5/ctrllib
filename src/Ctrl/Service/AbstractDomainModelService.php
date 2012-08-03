<?php

namespace Ctrl\Service;

use Ctrl\Domain\Model;
use Ctr\Form\Form;
use DevCtrl\Domain\Exception;
use Zend\ServiceManager;

abstract class AbstractDomainModelService extends AbstractDomainService
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

    /**
     * @param Model $model
     * @return Form
     * @throws Exception
     */
    public function getForm(Model $model)
    {
        throw new Exception('Not implemented');
    }
}
