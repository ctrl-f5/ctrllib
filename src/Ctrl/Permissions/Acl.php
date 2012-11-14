<?php

namespace Ctrl\Permissions;

use Zend\Permissions\Acl\Acl as ZendAcl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Acl extends ZendAcl
{
    public function addResources(Resources $resources)
    {
        foreach ($resources->getSets() as $set) {
            if (!$this->hasResource($set)) {
                $this->addResource($set);
            }
            $this->assertResources((array)$resources->getResources($set), $set);
        }
    }

    protected function assertResources(array $resources, $parent = null)
    {
        foreach ($resources as $name => $resource) {
            if (is_string($resource)) {
                $this->addResource($resource, $parent);
            } else if (is_array($resource)) {
                $this->addResource($name, $parent);
                $this->assertResources($resource, $name);
            }
        }
    }
}
