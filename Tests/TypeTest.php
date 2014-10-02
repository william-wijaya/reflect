<?php
namespace Plum\Reflect\Tests;

use Plum\Reflect\Method;
use Plum\Reflect\Reflection;
use Plum\Reflect\Type;

class TypeTest extends \PHPUnit_Framework_TestCase
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
    function it_should_returns_method_instance()
    {
        $m = $this->type->getMethod(__FUNCTION__);

        $this->assertInstanceOf(Method::class, $m);
    }

    /** @test */
    function it_should_returns_method_accordingly()
    {
        $m = $this->type->getMethod(__FUNCTION__);

        $this->assertEquals(__FUNCTION__, $m->name);
    }

    /** @test */
    function it_should_returns_method_instances()
    {
        foreach ($this->type->getMethods() as $m)
            $this->assertInstanceOf(Method::class, $m);
    }

    /** @test */
    function it_should_returns_method_instance_for_constructor()
    {
        $c = $this->type->getConstructor();

        $this->assertInstanceOf(Method::class, $c);
        $this->assertTrue($c->isConstructor());
    }
} 
