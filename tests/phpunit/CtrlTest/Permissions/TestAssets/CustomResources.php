<?php

namespace CtrlTest\Permissions\TestAssets;

class CustomResources extends \Ctrl\Permissions\Resources
{
    public function getResources($set = null)
    {
        $resources = array_merge(
            parent::getResources(),
            array(
                self::SET_ROUTES => array(
                    'testRoute1',
                    'testRoute2',
                ),
            )
        );

        if ($set) {
            if (isset($set, $resources)) {
                return $this->assertResources($resources[$set], array($set));
            }
            return array();
        }
        return $this->assertResources($resources);
    }
}
