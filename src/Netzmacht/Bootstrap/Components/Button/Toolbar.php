<?php

namespace Netzmacht\Bootstrap\Components\Button;

/**
 * Button Toolbar.
 *
 * @package Netzmacht\Bootstrap\Components\Button
 */
class Toolbar extends ChildAware
{
    /**
     * Construct.
     *
     * @param array $attributes Toolbar attributes.
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->addClass('btn-toolbar');
        $this->setAttribute('role', 'toolbar');
    }
}
