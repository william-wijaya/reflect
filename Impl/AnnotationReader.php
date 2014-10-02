<?php
namespace Plum\Reflect\Impl;

use Doctrine\Common\Annotations\Annotation\Target;
use Doctrine\Common\Annotations\AnnotationReader as DoctrineReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Plum\Reflect\Parameter;

class AnnotationReader extends DoctrineReader
{
    private $parser;
    private $phpParser;

    private $getClassImportsMethod;
    private $getIgnoredAnnotationNamesMethod;

    public function __construct()
    {
        parent::__construct();

        $r = new \ReflectionClass(DoctrineReader::class);

        $parserProperty = $r->getProperty("parser");
        $parserProperty->setAccessible(true);

        $phpParserProperty = $r->getProperty("phpParser");
        $phpParserProperty->setAccessible(true);

        $this->parser = $parserProperty->getValue($this);
        $this->phpParser = $phpParserProperty->getValue($this);

        $this->getClassImportsMethod =
            $r->getMethod("getClassImports");

        $this->getIgnoredAnnotationNamesMethod =
            $r->getMethod("getIgnoredAnnotationNames");

        $this->getClassImportsMethod->setAccessible(true);
        $this->getIgnoredAnnotationNamesMethod->setAccessible(true);

        foreach (spl_autoload_functions() as $l)
            AnnotationRegistry::registerLoader($l);
    }

    /**
     * Returns parameter annotations
     *
     * @param Parameter $parameter
     *
     * @return array
     */
    public function getParameterAnnotations(Parameter $parameter)
    {
        $class = $parameter->getDeclaringClass();
        $method = $parameter->getDeclaringFunction();
        $context = "parameter {$class->name}::{$method->name}(\${$parameter->name})";

        $this->parser->setTarget(Target::TARGET_ALL);
        $this->parser->setImports(
            $this->getClassImportsMethod->invoke($this, $class));
        $this->parser->setIgnoredAnnotationNames(
            $this->getIgnoredAnnotationNamesMethod->invoke($this, $class));

        return $this->parser->parse($parameter->getDocComment(), $context);
    }
} 
