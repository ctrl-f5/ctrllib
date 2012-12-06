<?php

namespace Ctrl\Permissions;

use Zend\Permissions\Acl\Role\Registry as BaseRegistry;
use Zend\Permissions\Acl\Role\RoleInterface;
use CtrlAuth\Domain\Role;

class RoleRegistry extends BaseRegistry
{
    /**
     * @param RoleInterface|Role $role
     * @param null $parents
     * @return Registry|\Zend\Permissions\Acl\Role\Registry
     */
    public function add(RoleInterface $role, $parents = null)
    {
        if (!($role instanceof Role)) {
            return parent::add($role, $parents);
        }
        $roleId = $role->getRoleId();

        $roleParents = array();
        /** @var $child Role */
        foreach ($role->getParents() as $parent) {
            $roleParents[$parent->getName()] = $parent;
        }

        $children = array();
        /** @var $child Role */
        foreach ($role->getChildren() as $child) {
            $children[$child->getName()] = $child;
        }

        $this->roles[$roleId] = array(
            'instance' => $role,
            'parents'  => $roleParents,
            'children' => $children,
        );
        return $this;
    }
}
