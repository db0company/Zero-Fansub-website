<?php

require_once dirname(__FILE__).'/../../../class/util/check.php';

/**
 * Test class for Check.
 * Generated by PHPUnit on 2012-06-17 at 19:11:26.
 */
class CheckTest extends PHPUnit_Framework_TestCase
{
    public function testInputCheckWithoutDefault()
    {
        $this->assertEquals("a", Check::getInputIn("a", array("a", "b")));
        $this->assertEquals("b", Check::getInputIn("b", array("a", "b")));
        $this->assertEquals(null, Check::getInputIn("c", array("a", "b")));
    }
    
    public function testInputCheckWithDefault()
    {
        $this->assertEquals("a", Check::getInputIn("a", array("a", "b"), "d"));
        $this->assertEquals("b", Check::getInputIn("b", array("a", "b"), "d"));
        $this->assertEquals("d", Check::getInputIn("c", array("a", "b"), "d"));
    }
    
    public function testNumericInputCheckWithoutDefault()
    {
        $this->assertEquals(1, Check::getNumericInput(1));
        $this->assertEquals(2, Check::getNumericInput(2));
        $this->assertEquals(null, Check::getNumericInput("a"));
    }
    
    public function testNumericInputCheckWithDefault()
    {
        $this->assertEquals(1, Check::getNumericInput(1, 10));
        $this->assertEquals(2, Check::getNumericInput(2, 10));
        $this->assertEquals(10, Check::getNumericInput("a", 10));
    }
}
?>