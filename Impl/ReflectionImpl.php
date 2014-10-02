<?php
namespace Plum\Reflect\Impl;

use Plum\Reflect\Annotated;
use Plum\Reflect\Matcher;
use Plum\Reflect\Parameter;
use Plum\Reflect\Reflection;
use Plum\Reflect\Type;

/**
 * Implementation of {@link Reflection}
 */
class ReflectionImpl extends Reflection
{
    private $reader;
    private $scanner;

    public function __construct(
        AnnotationReader $reader, TypeScanner $scanner
    )
    {
        $this->reader = $reader;
        $this->scanner = $scanner;
    }

    /**
     * {@inheritdoc}
     */
    public function ofType($name)
    {
        return new Type($name, $this);
    }

    /**
     * {@inheritdoc}
     */
    public function find($namespace, Matcher $matcher)
    {
        $names = $this->scanner->scan($namespace);
        $types = array_map([$this, "ofType"], $names);

        return array_filter($types, [$matcher, "matches"]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAnnotations(Annotated $annotated)
    {
        if ($annotated instanceof \ReflectionClass)
            return $this->reader->getClassAnnotations($annotated);

        if ($annotated instanceof \ReflectionMethod)
            return $this->reader->getMethodAnnotations($annotated);

        if ($annotated instanceof Parameter)
            return $this->reader->getParameterAnnotations($annotated);

        throw new \InvalidArgumentException(
            "Invalid annotated element of ".get_class($annotated)." given"
        );
    }
}
