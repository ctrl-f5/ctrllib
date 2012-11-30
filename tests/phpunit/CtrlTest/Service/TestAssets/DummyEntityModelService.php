<?php

namespace CtrlTest\Service\TestAssets;

use Ctrl\Service\AbstractDomainModelService;

class DummyEntityModelService extends AbstractDomainModelService
{
    protected $entity = 'CtrlTest\Domain\TestAssets\DummyEntity';
}
