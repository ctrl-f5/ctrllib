<?php

class FirstTest extends PHPUnit_Framework_TestCase
{
    public function testIfTestsWork()
    {
        $this->assertTrue(true);
    }
    
    public function testIfAutoloadWorks()
    {
        $this->assertTrue(class_exists('Zend\Version\Version'));
    }
}