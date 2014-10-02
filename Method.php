<?php
namespace Plum\Reflect;

use Plum\Reflect\Impl\AnnotatedTraitImpl;

/**
 * Represents reflection of method
 */
class Method extends \ReflectionMethod implements Annotated
{
    use AnnotatedTraitImpl;

    private $type;

    public function __construct(Type $type, $name, Reflection $reflection)
    {
        parent::__construct($type->name, $name);

        $this->type = $type;
        $this->reflection = $reflection;
    }

    /**
     * Returns the type
     *
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     *
     * @return Parameter[]
     */
    public function getParameters()
    {
        return array_map(function(\ReflectionParameter $p) {
            return new Parameter($this, $p->getPosition(), $this->reflection);
        }, parent::getParameters());
    }
} 
