<?php

namespace Netzmacht\Bootstrap\Components\Button;

use Netzmacht\Html\CastsToString;
use Netzmacht\Html\Attributes;

/**
 * Class ChildAware is used for elements with children.
 *
 * @package Netzmacht\Bootstrap\Components\Button
 */
class ChildAware extends Attributes implements CastsToString
{
    /**
     * List of child elements.
     *
     * @var CastsToString[]
     */
    protected $children = array();

    /**
     * Add a child.
     *
     * @param CastsToString|string $child Child.
     *
     * @return $this
     */
    public function addChild($child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Add multiple children.
     *
     * @param array|CastsToString[] $children Children being added.
     *
     * @return $this
     */
    public function addChildren(array $children)
    {
        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * Run a callback for each child.
     *
     * @param \Callable $callback Callback which accepts the child as argument.
     *
     * @return $this
     */
    public function eachChild($callback)
    {
        foreach ($this->children as $child) {
            call_user_func($callback, $child);
        }

        return $this;
    }

    /**
     * Get children.
     *
     * @return CastsToString[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Generate the element.
     *
     * @return string
     */
    public function generate()
    {
        return sprintf(
            '<div %s>%s%s%s</div>%s',
            $this->generateAttributes(),
            PHP_EOL,
            $this->generateChildren(),
            PHP_EOL,
            PHP_EOL
        );
    }

    /**
     * Generate children.
     *
     * @return string
     */
    protected function generateChildren()
    {
        $buffer = '';

        foreach ($this->children as $child) {
            $buffer .= $child->generate();
        }

        return $buffer;
    }

    /**
     * Generate the attributes.
     *
     * @return string
     */
    protected function generateAttributes()
    {
        return parent::generate();
    }
}
