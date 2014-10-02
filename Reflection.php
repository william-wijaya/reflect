<?php
namespace Plum\Reflect;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Plum\Reflect\Impl\AnnotationReader;
use Plum\Reflect\Impl\ReflectionImpl;
use Plum\Reflect\Impl\TypeScanner;
use Composer\Autoload\ClassLoader as ComposerLoader;

abstract class Reflection
{
    /**
     * Returns the type reflection instance of given name
     *
     * @param string $name
     * @return Type
     */
    public abstract function ofType($name);

    /**
     * Find types in given namespace which matches given matcher
     *
     * @param string $namespace
     * @param Matcher $matcher
     * @return Type[]
     */
    public abstract function find($namespace, Matcher $matcher);

    /**
     * Get annotations of given element
     *
     * @param Annotated $annotated
     * @return array
     */
    public abstract function getAnnotations(Annotated $annotated);

    /**
     * Returns reflection instance
     *
     * @return Reflection
     *
     * @throws \LogicException
     */
    public static function create()
    {
        foreach(spl_autoload_functions() as $l) {
            AnnotationRegistry::registerLoader($l);

            if (is_array($l) && $l[0] instanceof ComposerLoader)
                $composer = $l[0];
        }

        if (!isset($composer)) throw new \LogicException(
            "Composer autoloader is required in order to instantiate ".
            "reflection instance"
        );

        $reader = new AnnotationReader();
        $scanner = new TypeScanner($composer);

        return new ReflectionImpl($reader, $scanner);
    }
} 
