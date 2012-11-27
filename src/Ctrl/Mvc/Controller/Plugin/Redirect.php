<?php

namespace Ctrl\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\Redirect as ZendRedirect;
use Zend\Http\Response;
use Zend\Mvc\Exception;
use Zend\Mvc\InjectApplicationEventInterface;
use Zend\Mvc\MvcEvent;

class Redirect extends ZendRedirect
{
    /**
     * redirects to a URL based on a route
     *
     * @param  string $error error message
     * @param  string $route RouteInterface name
     * @param  array $params Parameters to use in url generation, if any
     * @param  array $options RouteInterface-specific options to use in url generation, if any
     * @param  bool $reuseMatchedParams Whether to reuse matched parameters
     * @return Response
     * @throws Exception\DomainException if composed controller does not implement InjectApplicationEventInterface, or
     *         router cannot be found in controller event
     */
    public function toRouteWithError($error, $route = null, array $params = array(), $options = array(), $reuseMatchedParams = false)
    {
        $controller = $this->getController();
        if (!$controller || !method_exists($controller, 'plugin')) {
            throw new Exception\DomainException('Redirect plugin requires a controller that defines the plugin() method');
        }
        $controller->plugin('flashMessenger')->setNamespace('error')->addMessage($error);

        return $this->toRoute($route, $params, $options, $reuseMatchedParams);
    }
}
