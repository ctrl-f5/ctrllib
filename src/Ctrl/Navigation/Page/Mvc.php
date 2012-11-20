<?php

namespace Ctrl\Navigation\Page;

use Zend\Navigation\Page\Mvc as MvcPage;

class Mvc extends MvcPage
{
    /**
     * Returns whether page should be considered active or not
     *
     * This method will compare the page's route name and mvc params with the
     * matched route's name and params
     *
     * @param  bool $recursive  [optional] whether page should be considered
     *                          active if any child pages are active. Default is
     *                          false.
     * @return bool             whether page should be considered active or not
     */
    public function isActive($recursive = false)
    {
        if (!$this->active) {

            //do we have a matched route?

            if ($this->routeMatch instanceof \Zend\Mvc\Router\RouteMatch) {
                if (null !== $this->getRoute()
                    && $this->routeMatch->getMatchedRouteName() === $this->getRoute()
                ) {

                    //get default params and set defaults
                    $myParams = $this->params;
                    if (!isset($myParams['controller'])) $myParams['controller'] = 'index';
                    if (!isset($myParams['action'])) $myParams['action'] = 'index';
                    
                    //check the controller and action params
                    if (strtolower($this->routeMatch->getParam('__CONTROLLER__')) == strtolower($myParams['controller'])
                        && $this->routeMatch->getParam('action') == $myParams['action']
                    ) {
                        $this->active = true;
                        return true;
                    }
                    //if recursive check the sub pages
                    if ($recursive) {
                        foreach ($this->pages as $page) {
                            if ($page->isActive(true)) {
                                return true;
                            }
                        }
                    }
                    //matched route but no valid mvc parameters
                    return false;
                }
            }

            //no matched route so try parent logic
            return parent::isActive($recursive);
        }

        return true;
    }
}
