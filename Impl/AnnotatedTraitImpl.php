<?php
namespace Plum\Reflect\Impl;

use Plum\Reflect\Reflection;

trait AnnotatedTraitImpl
{
    /**
     * The reflection instance
     *
     * @var Reflection
     */
    private $reflection;

    /**
     * {@inheritdoc}
     */
    public function getAnnotations($annotation = null)
    {
        $annotations = $this->reflection->getAnnotations($this);
        if ($annotation === null)
            return $annotations;

        $filter = is_object($annotation)
            ? function ($a) use ($annotation) {
                return $a == $annotation;
            }
            : function ($a) use ($annotation) {
                return $a instanceof $annotation;
            };

        return array_filter($annotations, $filter);
    }

    /**
     * {@inheritdoc}
     */
    public function getAnnotation($annotation)
    {
        $annotations = $this->getAnnotations($annotation);
        if (!$annotations)
            return;

        return reset($annotations);
    }

    /**
     * {@inheritdoc}
     */
    public function isAnnotatedWith($annotation)
    {
        return (bool)$this->getAnnotation($annotation);
    }
} 
