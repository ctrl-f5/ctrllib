<?php

namespace Ctrl\Permissions;

class Resources
{
    const SET_GLOBAL = 'global';

    public function getSets()
    {
        return array(
            self::SET_GLOBAL,
        );
    }

    public function getResources($set = null)
    {
        $resources = array();
        $categories = $this->getSets();
        foreach ($this->getSets() as $s) {
            $resources[$s] = array();
        }
        if ($set) {
            if (isset($set, $resources)) {
                return $resources[$set];
            }
            return array();
        }
        return $resources;
    }

    protected function flattenResourceArray(array $resources, $parent = '')
    {
        $flattened = array();
        foreach ($resources as $name => $resource) {
            if (is_string($resource)) {
                $flattened[] = (($parent) ? $parent.'.' : '') . $resource;
            } else if (is_array($resource)) {
                $flattened = array_merge(
                    $flattened,
                    $this->flattenResourceArray($resource, (($parent) ? $parent.'.': '').$name)
                );
            }
        }
        return $flattened;
    }
}
