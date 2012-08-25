<?php

namespace Ctrl\Mvc\View\Http;

use Zend\Mvc\MvcEvent;
use Zend\Filter\Word\CamelCaseToDash as CamelCaseToDashFilter;
use Zend\Mvc\View\Http\InjectTemplateListener as ZendInjectTemplateListener;

class InjectTemplateListener extends ZendInjectTemplateListener
{
    /**
     * Inject a template into the view model, if none present
     *
     * Template is derived from the controller found in the route match, and,
     * optionally, the action, if present.
     *
     * @param  MvcEvent $e
     * @return void
     */
    public function injectTemplate(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $controller = $e->getTarget();
        if (is_object($controller)) {
            $controller = get_class($controller);
        }
        if (!$controller) {
            $controller = $routeMatch->getParam('controller', '');
        }
        if (strpos($controller, 'Ctrl\\Module') !== 0) {
            return;
        }

        parent::injectTemplate($e);
    }

    /**
     * Determine the top-level and first child namespace of the controller
     *
     * @param  string $controller
     * @return string
     */
    protected function deriveModuleNamespace($controller)
    {
        if (!strstr($controller, '\\')) {
            return '';
        }
        $parts = explode('\\', $controller);
        $ns = array(array_shift($parts)); //add root, 'Ctrl'
        array_shift($parts); //remove 'Ḿodule'namespace
        $ns[] = array_shift($parts); // add module name
        return implode('/', $ns);
    }
}
