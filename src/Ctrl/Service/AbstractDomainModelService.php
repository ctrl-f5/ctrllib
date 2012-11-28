<?php

namespace Ctrl\Service;

use Ctrl\Domain\Model;
use Ctrl\Domain\PersistableModel;
use Ctrl\Form\Form;
use Ctrl\Domain\Exception as DomainException;
use Zend\ServiceManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

abstract class AbstractDomainModelService
    extends AbstractDomainService
    implements \Zend\EventManager\EventManagerAwareInterface
{
    /**
     * @var string
     */
    protected $entity = '';

    /**
     * @var EventManager
     */
    protected $events;

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

    /**
     * Inject an EventManager instance
     *
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        $this->events = $eventManager;
        return $this;
    }

    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }
}
