<?php
namespace Plum\Reflect\Tests\Impl;

use Plum\Reflect\Annotated;
use Plum\Reflect\Impl\AnnotationReader;
use Plum\Reflect\Impl\ReflectionImpl;
use Plum\Reflect\Impl\TypeScanner;
use Plum\Reflect\Method;
use Plum\Reflect\Parameter;
use Plum\Reflect\Type;

class ReflectionImplTest extends \PHPUnit_Framework_TestCase
{
    /** @test @dataProvider provideAnnotatedElements */
    function it_should_delegate_accordingly(Annotated $annotated, $method)
    {
        $r = $this->getMock(AnnotationReader::class);
        $r->expects($this->once())->method($method);

        $s = $this->getMockBuilder(TypeScanner::class)
            ->disableOriginalConstructor()
            ->getMock();

        (new ReflectionImpl($r, $s))
            ->getAnnotations($annotated);
    }

    function provideAnnotatedElements()
    {
        return [
            [
                $this->getMockBuilder(Type::class)
                    ->disableOriginalConstructor()
                    ->getMock(),
                "getClassAnnotations"
            ],
            [
                $this->getMockBuilder(Method::class)
                    ->disableOriginalConstructor()
                    ->getMock(),
                "getMethodAnnotations"
            ],
            [
                $this->getMockBuilder(Parameter::class)
                    ->disableOriginalConstructor()
                    ->getMock(),
                "getParameterAnnotations"
            ],
        ];
    }
} 
