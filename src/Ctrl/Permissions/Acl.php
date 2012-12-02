<?php

namespace Ctrl\Permissions;

use Zend\Permissions\Acl\Acl as ZendAcl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Acl extends ZendAcl
{
    /**
     * @var Resources[]
     */
    protected $systemResources = array();

    public function addSystemResources(Resources $resources)
    {
        $this->systemResources[spl_object_hash($resources)] = $resources;
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

    /**
     * @param $roles \CtrlAuth\Domain\Role[]|array
     * @return Acl
     */
    public function addRoles($roles)
    {
        foreach ($roles as $role) {
            if (!$this->hasRole($role->getName())) {
                parent::addRole($role->getName());
            }
            $authRole = $this->getRole($role->getName());
            foreach ($role->getPermissions() as $permission) {
                if (!$this->hasResource($permission->getResource()->getName())) {
                    $this->addResource($permission->getResource()->getName());
                }
                if ($permission->isAllowed()) {
                    $this->allow($authRole, $this->getResource($permission->getResource()->getName()));
                }
            }
        }
        return $this;
    }

    /**
     * @return array|Resources[]
     */
    public function getSystemResources()
    {
        return $this->systemResources;
    }

    public function getResourceSets()
    {
        $sets = array();
        foreach ($this->getSystemResources() as $r) {
            $sets = array_merge($sets, $r->getSets());
        }
        return $sets;
    }

    public function hasAccessToRouteResource($resource)
    {

    }
}
