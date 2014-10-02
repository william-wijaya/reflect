<?php
namespace Plum\Reflect\Tests;

use Plum\Reflect\Parameter;
use Plum\Reflect\Reflection;
use Plum\Reflect\Type;

class MethodTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Type
     */
    private $type;

    /** @before */
    function setUp()
    {
        $r = $this->getMock(Reflection::class);
        $this->type = new Type(__CLASS__, $r);
    }

    /** @test */
    function it_should_returns_type()
    {
        $m = $this->type->getMethod(__FUNCTION__);

        $this->assertEquals($this->type, $m->getType());
    }

    /** @test */
    function it_should_returns_parameter_instance($dummy = null)
    {
        $m = $this->type->getMethod(__FUNCTION__);
        $p = $m->getParameters()[0];

        $this->assertInstanceOf(Parameter::class, $p);
    }

    /** @test */
    function it_should_returns_parameter_accordingly($dummy = null)
    {
        $m = $this->type->getMethod(__FUNCTION__);
        $p = $m->getParameters()[0];

        $this->assertEquals("dummy", $p->name);
    }

    /** @test */
    function it_should_duplicate_parameters_accordingly(
        $dummy = null, $dummy = null
    )
    {
        $m = $this->type->getMethod(__FUNCTION__);
        list($p1, $p2) = $m->getParameters();

        $this->assertNotEquals($p1->getPosition(), $p2->getPosition());
    }
} 
