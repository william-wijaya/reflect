<?php
namespace Plum\Reflect;
use Plum\Reflect\Impl\AnnotatedTraitImpl;

/**
 * Represents reflection of type (class / interface)
 */
class Type extends \ReflectionClass implements Annotated
{
    use AnnotatedTraitImpl;

    public function __construct($name, Reflection $reflection)
    {
        parent::__construct($name);

        $this->reflection = $reflection;
    }

    /**
     * {@inheritdoc}
     *
     * @return Method
     */
    public function getMethod($name)
    {
        return new Method($this, $name, $this->reflection);
    }

    /**
     * {@inheritdoc}
     *
     * @return Method[]
     */
    public function getMethods($filter = null)
    {
        $methods = func_num_args()
            ? parent::getMethods($filter)
            : parent::getMethods();

        return array_map(function(\ReflectionMethod $m) {
            return $this->getMethod($m->name);
        }, $methods);
    }

    /**
     * {@inheritdoc}
     *
     * @return Method|null
     */
    public function getConstructor()
    {
        $c = parent::getConstructor();
        if (!$c)
            return;

        return $this->getMethod($c->name);
    }

}
