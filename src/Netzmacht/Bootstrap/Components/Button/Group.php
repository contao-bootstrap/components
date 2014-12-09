<?php

namespace Netzmacht\Bootstrap\Components\Button;

/**
 * Button group.
 *
 * @package Netzmacht\Bootstrap\Components\Button
 */
class Group extends ChildAware
{
    /**
     * Construct.
     *
     * @param array $attributes Html attributes.
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->addClass('btn-group');
    }
}
