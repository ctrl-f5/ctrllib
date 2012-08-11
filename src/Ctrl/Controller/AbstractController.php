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
     * @return AbstractDomainService|AbstractDomainModelService
     */
    public function getDomainService($name)
    {
        return $this->getServiceLocator()
            ->get('DomainServiceLoader')
            ->get($name);
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
     * @return \Zend\Mvc\Controller\Plugin\Redirect
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

    protected function redirectToIndexWithError($error, $id = null, $controller = null, $action = null)
    {
        if (!$controller) $controller = $this->controllerName;
        if (!$action) $action = $this->defaultAction;

        $this->flashMessenger()->setNamespace('error')->addMessage($error);
        $params = array(
            'controller' => $controller,
            'action' => $action,
        );

        $route = 'default';
        if ($id) {
            $params['id'] = $id;
            $route .= '/id';
        }
        return $this->redirect()->toRoute($route, $params);
    }
}
