<?php

namespace Ctrl\Service;

use Ctrl\Domain\PersistableModel;
use Ctrl\Domain\ArrayCollection;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;


abstract class AbstractDomainModelService
    extends AbstractDomainService
    implements \Zend\EventManager\EventManagerAwareInterface
{
    /**
     * The full namespaced class name of the Domain Model
     * that this DomainService instance Represents
     *
     * @var string
     */
    protected $entity = '';

    /**
     * @var EventManager
     */
    protected $events;

    /**
     * Returns all models in the collection
     *
     * @return array|PersistableModel[]|ArrayCollection
     */
    public function getAll()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT e FROM '.$this->entity.' e')
            ->getResult();
    }

    /**
     * Returns the model instance identified by the passed value
     *
     * @param mixed|int $id
     * @return PersistableModel
     * @throws EntityNotFoundException
     */
    public function getById($id)
    {
        $entities = $this->getEntityManager()
            ->createQuery('SELECT e FROM '.$this->entity.' e WHERE e.id = :id')
            ->setParameter('id', $id)
            ->getResult();
        if (!count($entities)) {
            throw new \Ctrl\Service\EntityNotFoundException($this->entity.' not found with id: '.$id);
        }
        return $entities[0];
    }

    /**
     * Persist the model to storage
     *  may attempt to persist related models
     *  depending on configuration
     *
     * @param PersistableModel $model
     */
    public function persist(PersistableModel $model)
    {
        $this->getEntityManager()->persist($model);
        $this->getEntityManager()->flush();
    }

    /**
     * Remove the model to storage
     *  may attempt to persist related models
     *  depending on configuration
     *
     * @param \Ctrl\Domain\PersistableModel $model
     * @return AbstractDomainModelService
     */
    public function remove(PersistableModel $model)
    {
        $this->getEntityManager()->remove($model);
        $this->getEntityManager()->flush();
        return $this;
    }

    /**
     * Inject an EventManager instance
     *
     * @param  EventManagerInterface $eventManager
     * @return AbstractDomainModelService
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
