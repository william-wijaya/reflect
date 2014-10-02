<?php
namespace Plum\Reflect;

/**
 * Represents annotated element
 *
 * @package Plum\Reflect
 */
interface Annotated
{
    /**
     * Get annotations of the element
     *
     * @param string|object|null $annotation
     *
     * @return array
     */
    public function getAnnotations($annotation = null);

    /**
     * Get annotation of the element
     *
     * @param string|object $annotation
     * @return null|object
     */
    public function getAnnotation($annotation);

    /**
     * Checks whether the element is annotated with given annotation
     *
     * @param string|object $annotation
     * @return bool
     */
    public function isAnnotatedWith($annotation);
} 
