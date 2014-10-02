<?php
namespace Plum\Reflect\Matcher;

use Plum\Reflect\Matcher;
use Plum\Reflect\Type;

class MatchAnnotatedWith extends Matcher
{
    private $annotation;

    public function __construct($annotation)
    {
        $this->annotation = $annotation;
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Type $type)
    {
        return $type->isAnnotatedWith($this->annotation);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "is-annotated-with(@".(
            is_object($this->annotation)
                ? get_class($this->annotation)
                : $this->annotation
        ).")";
    }
}
