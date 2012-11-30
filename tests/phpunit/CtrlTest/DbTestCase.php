<?php

namespace CtrlTest;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class DbTestCase extends ApplicationTestCase
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    protected function getEntityManager(array $metadata)
    {
        if (!$this->entityManager) {
            $config = Setup::createXMLMetadataConfiguration($metadata, true, TESTS_DOCTRINE_PROXY_DIR);
            //$conn = array('driver' => 'pdo_sqlite', 'path' =>  __DIR__ . '/db/test.db');
            $conn = array('driver' => 'pdo_sqlite', 'memory' => true);
            $this->entityManager = EntityManager::create($conn, $config);
        }
        return $this->entityManager;
    }

    public function createSchema(EntityManager $entityManager)
    {
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        $schemaTool->createSchema($classes);
    }

    public function dropSchema(EntityManager $entityManager)
    {
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        $schemaTool->updateSchema(array());
    }

    public function testNothing() {}
}
