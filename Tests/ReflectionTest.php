<?php
namespace Plum\Reflect\Tests;

use Plum\Reflect\Reflection;
use Plum\Reflect\Tests\Fixture\AnnotationFixture;

/**
 * @AnnotationFixture
 * @AnnotationFixture
 */
class ReflectionTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    function it_should_returns_type_annotations()
    {
        $r = Reflection::create();
        $t = $r->ofType(__CLASS__);

        $a = $r->getAnnotations($t);

        $this->assertInternalType("array", $a);
        $this->assertCount(2, $a);

        foreach ($a as $annotation)
            $this->assertInstanceOf(AnnotationFixture::class, $annotation);
    }

    /**
     * @AnnotationFixture
     */
    function test_it_should_returns_method_annotations()
    {
        $r = Reflection::create();
        $m = $r
            ->ofType(__CLASS__)
            ->getMethod(__FUNCTION__);

        $a = $r->getAnnotations($m);

        $this->assertInternalType("array", $a);
        $this->assertCount(1, $a);

        $this->assertInstanceOf(AnnotationFixture::class, reset($a));
    }

    /** test */
    function it_should_returns_parameter_annotations(
        /** @AnnotationFixture */$param = null
    )
    {
        $r = Reflection::create();
        $p = $r
            ->ofType(__CLASS__)
            ->getMethod(__FUNCTION__)
            ->getParameters()[0];

        $a = $r->getAnnotations($p);

        $this->assertInternalType("array", $a);
        $this->assertCount(1, $a);

        $this->assertInstanceOf(AnnotationFixture::class, reset($a));
    }
} 
