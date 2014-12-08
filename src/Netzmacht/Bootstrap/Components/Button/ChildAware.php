<?php

namespace Netzmacht\Bootstrap\Components\Button;

use Netzmacht\Html\CastsToString;
use Netzmacht\Html\Attributes;

class ChildAware extends Attributes implements CastsToString
{
    /**
     * @var CastsToString[]
     */
    protected $children = array();

    /**
     * @param $child
     * @return $this
     */
    public function addChild($child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * @param array $children
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
     * @param $callback
     */
    public function eachChild($callback)
    {
        foreach ($this->children as $child) {
            call_user_func($callback, $child);
        }
    }

    /**
     * @return CastsToString
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
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
     * @return string
     */
    protected function generateAttributes()
    {
        return parent::generate();
    }
}
