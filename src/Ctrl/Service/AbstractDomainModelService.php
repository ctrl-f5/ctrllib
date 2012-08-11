<?php

namespace Ctrl\Service;

use Ctrl\Domain\Model;
use Ctrl\Domain\PersistableModel;
use Ctrl\Form\Form;
use DevCtrl\Domain\Exception;
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
     */
    public function remove(PersistableModel $model)
    {
        $this->getEntityManager()->remove($model);
        $this->getEntityManager()->flush();
    }

    public function canRemove(PersistableModel $model)
    {
        return true;
    }

    /**
     * @param Model $model
     * @return Form
     * @throws Exception
     */
    public function getForm(Model $model = null)
    {
        throw new Exception('Not implemented');
    }
}
