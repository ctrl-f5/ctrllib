<?php

namespace CtrlTest\CtrlJs\ViewHelper;

use Ctrl\CtrlJs\ViewHelper\CtrlJsLoader;

class CtrlJsLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CtrlJsLoader
     */
    public $helper = null;

    /**
     * @var string
     */
    public $basePath;

    public function setUp()
    {
        \Zend\View\Helper\Placeholder\Registry::unsetRegistry();

        $this->basePath = __DIR__ . '/_files/modules';

        $renderer = new \Zend\View\Renderer\PhpRenderer();
        $renderer->plugin('basePath')->setBasePath($this->basePath);

        $this->helper = new CtrlJsLoader();
        $this->helper->setView($renderer);
    }

    public function tearDown()
    {
        $this->helper = null;
    }

    public function testCanInvoke()
    {
        $loader = $this->helper;
        $this->assertSame($loader, $loader());
    }

    public function testCanLoadScriptsWithDefaults()
    {
        $out = (string)$this->helper->loadScripts(true);
        $this->assertEquals(4, count(explode(PHP_EOL, $out)));
    }

    public function testCanLoadScriptsWithoutDefaults()
    {
        $out = (string)$this->helper->loadScripts(false);
        $this->assertEquals(3, count(explode(PHP_EOL, $out)));
    }
}
