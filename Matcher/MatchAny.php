<?php
namespace Plum\Reflect\Matcher;

use Plum\Reflect\Matcher;
use Plum\Reflect\Type;

class MatchAny extends Matcher
{
    /**
     * {@inheritdoc}
     */
    public function matches(Type $type)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "any";
    }
}
