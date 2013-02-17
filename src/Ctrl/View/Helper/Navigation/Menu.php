<?php

namespace Ctrl\View\Helper\Navigation;

use RecursiveIteratorIterator;
use Zend\Navigation\AbstractContainer;
use Zend\Navigation\Page\AbstractPage;
use Zend\View;
use Zend\View\Exception;
use Zend\View\Helper\Navigation\Menu as ZendMenu;

/**
 * Helper for rendering menus from navigation containers
 *
 * @category   Zend
 * @package    Zend_View
 * @subpackage Helper
 */
class Menu extends ZendMenu
{
    /**
     * CSS class to use for the ul element
     *
     * @var string
     */
    protected $ulClass = 'nav';

    /**
     * @var \Zend\Permissions\Acl\Role\GenericRole[]
     */
    protected $roles = array();

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Determines whether a page should be accepted by ACL when iterating
     *
     * Rules:
     * - If helper has no ACL, page is accepted
     * - If page has a resource or privilege defined, page is accepted
     *   if the ACL allows access to it using the helper's role
     * - If page has no resource or privilege, page is accepted
     *
     * @param  AbstractPage $page  page to check
     * @return bool                whether page is accepted by ACL
     */
    protected function acceptAcl(AbstractPage $page)
    {
        if (!$acl = $this->getAcl()) {
            // no acl registered means don't use acl
            return true;
        }

        $role = $this->getRole();
        $roles = $this->getRoles();
        $resource = $page->getResource();
        if ($resource === NULL) {
            return true;
        }
        $resource = $this->acl->hasResourceOrParent(
            $resource
        );
        if ($resource === false || $resource === NULL) {
            return false;
        }

        if (!$roles) {
            $roles = array($role);
        }

        if ($resource) {
            foreach ($roles as $r) {
                /**
                 * TODO: for now this has been set to allow an item if its resource is not found
                 */
                if (!$acl->hasResource($resource) || $acl->isAllowed($r, $resource)) {
                    return true;
                }
            }
            return false;
        }

        return true;
    }
}
