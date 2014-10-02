<?php
namespace Plum\Reflect\Impl\Matcher;

use Plum\Reflect\Matcher;
use Plum\Reflect\Type;

/**
 * Represents and operator matcher
 */
class AndMatcher extends Matcher
{
    private $left;
    private $right;

    public function __construct(Matcher $left, Matcher $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Type $type)
    {
        return
            $this->left->matches($type)
            &&
            $this->right->matches($type);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "{$this->left} and {$this->right}";
    }
}
