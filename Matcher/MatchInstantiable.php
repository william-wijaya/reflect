<?php
namespace Plum\Reflect\Matcher;

use Plum\Reflect\Matcher;
use Plum\Reflect\Type;

/**
 * Matches instantiable types
 */
class MatchInstantiable extends Matcher
{
    /**
     * {@inheritdoc}
     */
    public function matches(Type $type)
    {
        return $type->isInstantiable();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "instantiable";
    }
}
