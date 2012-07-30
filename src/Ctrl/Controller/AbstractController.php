<?php

namespace Ctrl\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;

class AbstractController extends AbstractActionController
{
    /**
     * @var ServiceManager
     */
    protected $domainServiceLocator;

    /**
     * @return ServiceManager
     */
    public function getDomainServiceLocator()
    {
        if (!$this->domainServiceLocator) {
            $this->domainServiceLocator = $this->getServiceLocator()->get('DomainServiceLoader');
        }
        return $this->domainServiceLocator;
    }

    /**
     * @param $name
     * @return \Ctrl\Service\AbstractDomainService
     */
    public function getDomainService($name)
    {
        return $this->getServiceLocator()
            ->get('DomainServiceLoader')
            ->get($name);
    }

    /**
     * @param $param
     * @param $default
     * @return \Zend\Mvc\Controller\Plugin\Params|mixed
     */
    public function params($param = null, $default = null)
    {
        return parent::params($param, $default);
    }
}
