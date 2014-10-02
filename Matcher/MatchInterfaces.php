<?php
namespace Plum\Reflect\Matcher;

use Plum\Reflect\Matcher;
use Plum\Reflect\Type;

/**
 * Matches interface types
 */
class MatchInterfaces extends Matcher
{
    /**
     * {@inheritdoc}
     */
    public function matches(Type $type)
    {
        return $type->isInterface();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "interface?";
    }
}
