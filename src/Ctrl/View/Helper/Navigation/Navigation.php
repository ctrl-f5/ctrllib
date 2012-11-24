<?php

namespace Ctrl\View\Helper\Navigation;

use RecursiveIteratorIterator;
use Zend\Navigation\AbstractContainer;
use Zend\Navigation\Page\AbstractPage;
use Zend\View;
use Zend\View\Helper\Navigation as ZendNavigation;

class Navigation extends ZendNavigation
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
        $privilege = $page->getPrivilege();

        if (!$roles) {
            $roles = array($roles);
        }
        if ($resource || $privilege) {
            foreach ($roles as $r) {
                // determine using helper role and page resource/privilege
                return $acl->hasResource($resource) && $acl->isAllowed($r, $resource);
            }
            return false;
        }

        return true;
    }

    /**
     * Retrieve plugin loader for navigation helpers
     *
     * Lazy-loads an instance of Navigation\HelperLoader if none currently
     * registered.
     *
     * @return ShortNameLocator
     */
    public function getPluginManager()
    {
        if (null === $this->plugins) {
            $this->setPluginManager(new PluginManager());
        }
        return $this->plugins;
    }

    protected function inject(\Zend\View\Helper\Navigation\HelperInterface $helper)
    {
        parent::inject($helper);
        if ($helper instanceof Navigation || $helper instanceof Menu) {
            $helper->setRoles($this->getRoles());
        }
    }
}
