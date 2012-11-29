<?php

namespace Ctrl\Permissions;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclFactory implements FactoryInterface
{
    const DEFAULT_CLASS_ACL = 'Ctrl\Permissions\Acl';

    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $config = $serviceManager->get('Configuration');
        if (!isset($config['acl'])) {
            throw new \Ctrl\Exception('acl was not configured');
        }
        $config = $config['acl'];
        $class = self::DEFAULT_CLASS_ACL;
        if (isset($config['class'])) {
            $class = $config['class'];
        }

        /** @var $acl \Ctrl\Permissions\Acl */
        $acl = new $class();

        /*
        * Add all system resources
        */
        if (isset($config['resources'])) {
            foreach ($config['resources'] as $class) {
                /** @var $inst \Ctrl\Permissions\Resources */
                $inst = new $class;
                if ($inst instanceof \Ctrl\Permissions\Resources) {
                    $acl->addSystemResources($inst);
                }
            }
        }

        return $acl;
    }
}
