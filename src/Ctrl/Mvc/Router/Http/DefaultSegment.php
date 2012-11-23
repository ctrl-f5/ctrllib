<?php

namespace Ctrl\Mvc\Router\Http;

use Traversable;
use Zend\Mvc\Router\Exception;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;

class DefaultSegment
{
    public static function factory($namespace, $prefix = '', $childroutes = array())
    {
        $config = array(
            'type'    => 'Segment',
            'options' => array(
                'route'    => $prefix.'[/:controller][/:action]',
                'constraints' => array(
                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                ),
                'defaults' => array(
                    '__NAMESPACE__' => $namespace,
                    'controller'    => 'Index',
                    'action'        => 'index',
                ),
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'id' => array(
                    'type'    => 'Segment',
                    'may_terminate' => true,
                    'options' => array(
                        'route'    => '/[:id]',
                        'constraints' => array(
                            'id'     => '[0-9]+',
                        ),
                    ),
                    'child_routes' => array(
                        'query' => array(
                            'type'    => 'Query',
                            'may_terminate' => true,
                        ),
                    ),
                ),
                'query' => array(
                    'type'    => 'Query',
                    'may_terminate' => true,
                ),
            ),
        );

        return self::addChildRoutes($config, $childroutes);
    }

    protected static function addChildRoutes($config, $childRoutes)
    {
        foreach ($childRoutes as $key => $route) {
            // check if we have to go recursive
            // for the moment we just check for a forward slash....
            if (strpos($key, '/') !== false) {

                // retrieve the root part of the route name
                // and check if it exists
                $keyParts = explode('/', $key);
                $currentKey = array_shift($keyParts);
                if (isset($config['child_routes']) && isset($config['child_routes'][$currentKey])) {

                    // rebuild the rest of the key and go recursive
                    // with the selected current root
                    $restKey = implode('/', $keyParts);
                    $config['child_routes'][$currentKey] = self::addChildRoutes(
                        $config['child_routes'][$currentKey],
                        array($restKey => $route)
                    );
                    // we are done for this loop
                    continue;

                } else {
                    throw new \Ctrl\Exception(sprintf('No route found for key %s', $key));
                }

            } else {

                // if the current root has no children yet, add the key
                if (!isset($config['child_routes'])) {
                    $config['child_routes'] = array();
                }
                // merge the child routes, with the new ones first
                $config['child_routes'] = array_merge(
                    array($key => $route),
                    $config['child_routes']
                );

            }
        }
        return $config;
    }
}
