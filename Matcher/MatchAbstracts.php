<?php
namespace Plum\Reflect\Matcher;

use Plum\Reflect\Matcher;
use Plum\Reflect\Type;

/**
 * Matches abstract types (abstract classes and interfaces)
 */
class MatchAbstracts extends Matcher
{

    /**
     * {@inheritdoc}
     */
    public function matches(Type $type)
    {
        return $type->isAbstract();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "abstract?";
    }
}
