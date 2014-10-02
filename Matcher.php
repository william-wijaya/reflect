<?php
namespace Plum\Reflect;

use Plum\Reflect\Impl\Matcher\AndMatcher;
use Plum\Reflect\Impl\Matcher\InverseMatcher;
use Plum\Reflect\Impl\Matcher\OrMatcher;

abstract class Matcher
{
    /**
     * Evaluates whether given type matches criteria
     *
     * @param Type $type
     *
     * @return bool
     */
    public abstract function matches(Type $type);

    /**
     * Returns unique string representation of the matcher
     *
     * @return string
     */
    public abstract function __toString();

    /**
     *
     * @param Matcher $matcher
     * @return Matcher
     */
    public function orMatches(Matcher $matcher)
    {
        return new OrMatcher($this, $matcher);
    }

    /**
     *
     * @param Matcher $matcher
     * @return Matcher
     */
    public function andMatches(Matcher $matcher)
    {
        return new AndMatcher($this, $matcher);
    }

    /**
     * Inverse the matcher
     *
     * @return Matcher
     */
    public function not()
    {
        return new InverseMatcher($this);
    }

    /**
     * @param Matcher $matcher
     * @return Matcher
     */
    public function orNotMatches(Matcher $matcher)
    {
        return $this->orMatches($matcher->not());
    }

    /**
     * @param Matcher $matcher
     * @return Matcher
     */
    public function andNotMatches(Matcher $matcher)
    {
        return $this->andMatches($matcher->not());
    }
} 
