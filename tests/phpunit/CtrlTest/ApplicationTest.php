<?php

namespace CtrlTest;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zend\Mvc\Application
     */
    protected $application;

    protected $defaultConfig = array();

    protected function setup()
    {
        $config = new \Zend\Config\Config(include __DIR__.'/../../test.config.php');
        $config->merge(new \Zend\Config\Config($this->defaultConfig));

        //var_dump($config->toArray());

        $this->application = \Zend\Mvc\Application::init($config->toArray());
    }

    protected function teardown()
    {
        $this->application = null;
    }

    public function testCanCreateApplication()
    {
        $this->assertInstanceOf('\Zend\Mvc\Application', $this->application);
    }
}
