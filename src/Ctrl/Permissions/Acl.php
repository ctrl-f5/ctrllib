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

    protected function getRoleRegistry()
    {
        if (null === $this->roleRegistry) {
            $this->roleRegistry = new RoleRegistry();
        }
        return $this->roleRegistry;
    }

    public function addSystemResources(Resources $resources)
    {
        $this->systemResources[spl_object_hash($resources)] = $resources;
        $this->assertResourceTree((array)$resources->getResources());
    }

    public function getResourceTree()
    {
        $tree = array();
        foreach ($this->systemResources as $resource) {
            $tree = $resource->mergeResourceTree($tree);
        }

        return $tree;
    }

    protected function assertResourceTree(array $resources, $parent = null)
    {
        foreach ($resources as $key => $val) {
            $current = ($parent) ? $parent . '.' . $key : $key;
            if (!$this->hasResource($current)) {
                $this->addResource($current, $parent);
            }
            $this->assertResourceTree($val, $current);
        }
    }

    public function getResourceNameFromPath($path)
    {
        return implode('.', $path);
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

    public function isAllowedListResource($role, $list, $resource = null)
    {
        if ($resource) {
            $resource = $list.'.'.$resource;
        } else {
            $resource = $list;
        }

        return $this->isAllowed($role, $resource);
    }

    public function dumpRoleRegistry()
    {
        return $this->roleRegistry;
    }

    public function hasResourceOrParent($resource)
    {
        if ($this->hasResource($resource)) {
            return $resource;
        }

        if (strpos($resource, '.') === false) {
            return false;
        }

        return $this->hasResourceOrParent(
            substr($resource, 0, strrpos($resource, '.'))
        );
    }
}
