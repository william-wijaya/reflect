<?php
namespace Plum\Reflect;

use Plum\Reflect\Impl\AnnotatedTraitImpl;

/**
 * Represents reflection of parameter
 */
class Parameter extends \ReflectionParameter implements Annotated
{
    use AnnotatedTraitImpl;

    private $method;

    public function __construct(Method $method, $name, Reflection $reflection)
    {
        parent::__construct([$method->class, $method->name], $name);

        $this->method = $method;
        $this->reflection = $reflection;
    }

    /**
     * {@inheritdoc}
     *
     * @return Type|null
     */
    public function getClass()
    {
        $c = parent::getClass();
        if ($c)
            return new Type($c->name, $this->reflection);
    }

    /**
     * Returns the method
     *
     * @return Method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * {@inheritdoc}
     *
     * @return Method
     */
    public function getDeclaringFunction()
    {
        $m = parent::getDeclaringFunction();

        return $this->getDeclaringClass()->getMethod($m->name);
    }

    /**
     * {@inheritdoc}
     *
     * @return Type|null
     */
    public function getDeclaringClass()
    {
        $c = parent::getDeclaringClass();
        if ($c)
            return new Type($c->name, $this->reflection);
    }

    /**
     * Returns the doc comment
     *
     * @return string
     */
    public function getDocComment()
    {
        if ($this->method->isInternal())
            return "";

        $lines = file($this->method->getFileName());
        $methodLines = array_slice(
            $lines, $this->method->getStartLine() - 1,
            $this->method->getEndLine() - $this->method->getStartLine()
        );
        $methodString = implode($methodLines);
        preg_match('/function\s*\w+?(\(.*?\))\s*[\{|;]/s', $methodString, $matches);

        $methodSignature = $matches[1];

        if ($this->getPosition() === 0) {
            if (preg_match(
                '/\(\s*?(\/\*\*.+?\*\/).*?\$' . $this->name . '/s',
                $methodSignature, $matches
                ))
                return $matches[1];

            return "";
        }

        if (preg_match_all(
            '/,\s*?(\/\*\*.+?\*\/).*?\$' . $this->name . '/s',
            $methodSignature, $matches
            ))
            return $matches[1][$this->getPosition() - 1];

        return "";
    }
} 
