<?php
namespace Plum\Reflect\Tests;

use Plum\Reflect\Reflection;
use Plum\Reflect\Type;

class ParameterTest extends \PHPUnit_Framework_TestCase
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
    function it_should_returns_empty_doc_comment($param1 = null, $param2 = null)
    {
        $m = $this->type->getMethod(__FUNCTION__);
        list($p1, $p2) = $m->getParameters();

        $this->assertEmpty($p1->getDocComment());
        $this->assertEmpty($p2->getDocComment());
    }

    /** @test */
    function it_should_returns_doc_comment(/** @dummy */$param = null)
    {
        $m = $this->type->getMethod(__FUNCTION__);
        $p = $m->getParameters()[0];

        $this->assertEquals('/** @dummy */', $p->getDocComment());
    }

    /** @test */
    function it_should_returns_multiline_doc_comment(
        /**
         * @dummy
         */
        $param = null
    )
    {
        $m = $this->type->getMethod(__FUNCTION__);
        $p = $m->getParameters()[0];

        $this->assertEquals(
       '/**
         * @dummy
         */', $p->getDocComment());
    }

    /** @test */
    function it_should_returns_multiple_doc_comment(
        /** @dummy1 */$p1 = null,
        /** @dummy2 */$p2 = null
    )
    {
        $m = $this->type->getMethod(__FUNCTION__);
        list($p1, $p2) = $m->getParameters();

        $this->assertEquals('/** @dummy1 */', $p1->getDocComment());
        $this->assertEquals('/** @dummy2 */', $p2->getDocComment());
    }

    /** @test */
    function it_should_returns_multiple_multiline_doc_comment(
        /** @dummy1 */$p1 = null,
        /**
         * @dummy2
         */$p2 = null
    )
    {
        $m = $this->type->getMethod(__FUNCTION__);
        list($p1, $p2) = $m->getParameters();

        $this->assertEquals('/** @dummy1 */', $p1->getDocComment());
        $this->assertEquals(
       '/**
         * @dummy2
         */', $p2->getDocComment());
    }

    /** @test */
    function it_should_returns_duplicate_parameter_correctly(
        /** @dummy1 */$p = null,
        /**
         * @dummy2
         */
        $p = null,
        /** @dummy3 */$p = null
    )
    {
        $m = $this->type->getMethod(__FUNCTION__);
        list($p1, $p2, $p3) = $m->getParameters();

        $this->assertEquals('/** @dummy1 */', $p1->getDocComment());
        $this->assertEquals(
            '/**
         * @dummy2
         */', $p2->getDocComment());
        $this->assertEquals('/** @dummy3 */', $p3->getDocComment());
    }

    /** @test */
    function it_should_returns_type_hinted_doc_comment(
        /** @dummy1 */\stdClass $class = null,
        /** @dummy2 */\stdClass $class = null)
    {
        $m = $this->type->getMethod(__FUNCTION__);
        list($p1, $p2) = $m->getParameters();

        $this->assertEquals("/** @dummy1 */", $p1->getDocComment());
        $this->assertEquals("/** @dummy2 */", $p2->getDocComment());
    }

    /** @test */
    function it_should_returns_method_instance($dummy = null)
    {
        $m = $this->type->getMethod(__FUNCTION__);
        $p = $m->getParameters()[0];

        $this->assertEquals($m, $p->getDeclaringFunction());
    }

    /** @test */
    function it_should_returns_declaring_type_instance($dummy = null)
    {
        $m = $this->type->getMethod(__FUNCTION__);
        $p = $m->getParameters()[0];

        $this->assertEquals($this->type, $p->getDeclaringClass());
    }

    /** @test */
    function it_should_returns_type_hint_instance(\stdClass $std = null)
    {
        $m = $this->type->getMethod(__FUNCTION__);
        $p = $m->getParameters()[0];

        $this->assertInstanceOf(Type::class, $p->getClass());
        $this->assertEquals(\stdClass::class, $p->getClass()->name);
    }

    /** @test */
    function it_should_returns_null_type_hint_instance($dummy = null)
    {
        $m = $this->type->getMethod(__FUNCTION__);
        $p = $m->getParameters()[0];

        $this->assertNull($p->getClass());
    }

    /** @test */
    function it_should_returns_empty_doc_comment_for_internal_type()
    {
        $t = new Type(\ArrayObject::class, $this->getMock(Reflection::class));
        $p = $t->getConstructor()->getParameters()[0];

        $this->assertEmpty($p->getDocComment());
    }
} 
