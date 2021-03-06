<?php

namespace Ctrl\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Ctrl\Service\AbstractDomainService;
use Ctrl\Service\AbstractDomainModelService;

class AbstractController extends AbstractActionController
{
    /**
     * @var ServiceManager
     */
    protected $domainServiceLocator;

    /**
     * @var string
     */
    protected $controllerName = 'index';

    /**
     * @var string
     */
    protected $defaultAction = 'index';

    /**
     * @var \Ctrl\Log\Logger
     */
    protected $logger;

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
     * Returns a registered AbstractDomainService
     *
     * @param $name
     * @return AbstractDomainService|AbstractDomainModelService
     */
    public function getDomainService($name)
    {
        return $this->getDomainServiceLocator()
            ->get($name);
    }

    /**
     * Sets a logger
     *
     * @param \Zend\Log\Logger $logger
     * @return AbstractController
     */
    public function setLogger(\Zend\Log\Logger $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return \Ctrl\Log\Logger
     */
    public function getLogger()
    {
        if (!$this->logger) {
            $this->logger = $this->getServiceLocator()->get('Log');
        }
        return $this->logger;
    }

    /**
     * The methods below provide subclasses with code completion
     * they contain method overrides or calls that would
     * normally trigger a controller plugin.
     */

    /**
     * @return Request
     */
    public function getRequest()
    {
        return parent::getRequest();
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return parent::getResponse();
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

    /**
     * @return \Zend\Mvc\Controller\Plugin\Url
     */
    public function url()
    {
        return parent::url();
    }

    /**
     * @return \Ctrl\Mvc\Controller\Plugin\Redirect
     */
    public function redirect()
    {
        return parent::redirect();
    }

    /**
     * @return \Zend\Mvc\Controller\Plugin\FlashMessenger
     */
    public function flashMessenger()
    {
        return parent::flashMessenger();
    }
}
