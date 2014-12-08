<?php

namespace Netzmacht\Bootstrap\Components\Button;

class Toolbar extends ChildAware
{

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->addClass('btn-toolbar');
        $this->setAttribute('role', 'toolbar');
    }

    /**
     * @param Group $child
     * @return $this
     */
    public function addChild($child)
    {
        return parent::addChild($child);
    }

}
