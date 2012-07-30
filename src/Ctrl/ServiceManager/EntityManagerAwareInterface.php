<?php

namespace Ctrl\ServiceManager;

interface EntityManagerAwareInterface
{
    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager);
    public function getEntityManager();
}
