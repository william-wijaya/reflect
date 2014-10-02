<?php
namespace Plum\Reflect\Impl\Matcher;

use Plum\Reflect\Matcher;
use Plum\Reflect\Type;

/**
 * Represents inverse matcher which will invert the result of given matcher
 */
class InverseMatcher extends Matcher
{
    private $matcher;

    public function __construct(Matcher $matcher)
    {
        $this->matcher = $matcher;
    }

    /**
     * {@inheritdoc}
     */
    public function not()
    {
        return $this->matcher;
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Type $type)
    {
        return !$this->matcher->matches($type);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "not {$this->matcher}";
    }
}
