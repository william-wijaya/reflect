<?php
namespace Plum\Reflect\Matcher;

use Plum\Reflect\Impl\Matcher\AndMatcher;
use Plum\Reflect\Matcher;

/**
 * Matches abstract classes
 */
class MatchAbstractClasses extends AndMatcher
{
    public function __construct()
    {
        parent::__construct(
            new MatchAbstracts(),
            (new MatchInterfaces())->not()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "abstract-class";
    }
}
