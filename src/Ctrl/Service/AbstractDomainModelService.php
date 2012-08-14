<?php

namespace Ctrl\Service;

use Ctrl\Domain\Model;
use Ctrl\Domain\PersistableModel;
use Ctrl\Form\Form;
use Ctrl\Domain\Exception as DomainException;
use Zend\ServiceManager;

abstract class AbstractDomainModelService extends AbstractDomainService
{
    /**
     * @var string
     */
    protected $entity = '';

    /**
     * @return array|PersistableModel[]
     */
    public function getAll()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT e FROM '.$this->entity.' e')
            ->getResult();
    }

    /**
     * @param $id
     * @return PersistableModel
     * @throws \Exception
     */
    public function getById($id)
    {
        $entities = $this->getEntityManager()
            ->createQuery('SELECT e FROM '.$this->entity.' e WHERE e.id = :id')
            ->setParameter('id', $id)
            ->getResult();
        if (!count($entities)) {
            //TODO: fix exception
            throw new \Exception($this->entity.' not found with id: '.$id);
        }
        return $entities[0];
    }

    /**
     * @param PersistableModel $model
     */
    public function persist(PersistableModel $model)
    {
        $this->getEntityManager()->persist($model);
        $this->getEntityManager()->flush();
    }

    /**
     * @param PersistableModel $model
     * @return AbstractDomainModelService
     * @throws DomainException
     */
    public function remove(PersistableModel $model)
    {
        if ($this->canRemove($model)) {
            $this->getEntityManager()->remove($model);
            $this->getEntityManager()->flush();
            return $this;
        }
        throw DomainException::modelPersistanceException($model);
    }

    public function canRemove(PersistableModel $model)
    {
        return true;
    }

    /**
     * @param Model $model
     * @return Form
     * @throws \Ctrl\Exception
     */
    public function getForm(Model $model = null)
    {
        throw new \Ctrl\Exception('Not implemented');
    }
}
