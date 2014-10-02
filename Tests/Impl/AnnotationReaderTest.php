<?php
namespace Plum\Reflect\Tests\Impl;

use Plum\Reflect\Impl\AnnotationReader;
use Plum\Reflect\Reflection;
use Plum\Reflect\Tests\Fixture\AnnotationFixture;
use Plum\Reflect\Type;

class AnnotationReaderTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    function it_should_read_annotations(/** @AnnotationFixture */$param = null)
    {
        $t = new Type(__CLASS__, $this->getMock(Reflection::class));
        $m = $t->getMethod(__FUNCTION__);
        $p = $m->getParameters()[0];

        $r = new AnnotationReader();
        $annotations = $r->getParameterAnnotations($p);

        $this->assertInstanceOf(AnnotationFixture::class, $annotations[0]);
    }
} 
