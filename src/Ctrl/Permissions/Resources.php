<?php

namespace Ctrl\Permissions;

class Resources
{
    const SET_GLOBAL = 'global';
    const SET_ROUTES = 'routes';

    public function getSets()
    {
        return array(
            self::SET_GLOBAL,
            self::SET_ROUTES,
        );
    }

    public function getResources($set = null)
    {
        $resources = array();
        foreach ($this->getSets() as $s) {
            $resources[$s] = array();
        }
        if ($set) {
            if (isset($set, $resources)) {
                $resources = $resources[$set];
            }
            return array();
        }

        return $this->assertResources($resources);
    }

    protected function assertResources(array $resources, $tree = array(), $path = array())
    {
        foreach ($resources as $key => $value) {

            // if there is a resource in the key, parse it
            // and add it to the parent path
            $keyPath = $path;
            if (!is_int($key) && is_string($key) && strlen($key)) {
                // create the full path
                $keyResources = $this->getResourcesFromString($key);
                foreach ($keyResources as $resPath) $keyPath[] = $resPath;
                // add the path of the key to the tree
                $tree = $this->createTreePath($tree, $keyPath);
            }

            // if we have a string value
            // parse it as a subpath of the key path
            if (is_string($value)) {
                // create the full path
                $valuePath = $keyPath;
                $valueResources = $this->getResourcesFromString($value);
                foreach ($valueResources as $resPath) $valuePath[] = $resPath;
                // add the path of the resource to the tree
                $tree = $this->createTreePath($tree, $valuePath);
            }
            // if we have an array value
            // recurse with the keypath as the root path
            if (is_array($value)) {
                $tree = $this->assertResources($value, $tree, $keyPath);
            }
        }

        return $tree;
    }

    protected function createTreePath($tree, $path)
    {
        if (count($path)) {
            $current = array_shift($path);
            if (!isset($tree[$current])) {
                $tree[$current] = array();
            }
            $tree[$current] = $this->createTreePath($tree[$current], $path);
        }
        return $tree;
    }

    protected function getResourcesFromString($string, $delimiter = '.')
    {
        return explode($delimiter, $string);
    }

    public function mergeResourceTree($tree = array())
    {
        return $this->assertResources(
            $tree,
            $this->getResources()
        );
    }
}
