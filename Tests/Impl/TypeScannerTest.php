<?php
namespace Plum\Reflect\Tests\Impl;

use Plum\Reflect\Impl\TypeScanner;
use Composer\Autoload\ClassLoader as ComposerLoader;

class TypeScannerTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    function it_should_returns_types_when_namespace_match_exactly()
    {
        $l = new ComposerLoader();
        $l->add("Plum\\Reflect\\Tests\\", realpath(__DIR__."/../"));

        $s = new TypeScanner($l);

        $types = $s->scan("Plum\\Reflect\\Tests\\");

        $this->assertContains("Plum\\Reflect\\Tests\\Fixture\\ScannedClass", $types);
    }

    /** @test */
    function it_should_returns_types_when_namespace_more_general()
    {
        $l = new ComposerLoader();
        $l->add("Plum\\Reflect\\Tests", realpath(__DIR__."/../"));

        $s = new TypeScanner($l);

        $types = $s->scan("Plum\\");

        $this->assertContains("Plum\\Reflect\\Tests\\Fixture\\ScannedClass", $types);
    }

    /** @test */
    function it_should_returns_types_when_prefix_is_more_general()
    {
        $l = new ComposerLoader();
        $l->add("Plum\\Reflect\\", realpath(__DIR__."/../../"));

        $s = new TypeScanner($l);

        $types = $s->scan("Plum\\Reflect\\Tests");

        $this->assertContains("Plum\\Reflect\\Tests\\Fixture\\ScannedClass", $types);
    }
} 
