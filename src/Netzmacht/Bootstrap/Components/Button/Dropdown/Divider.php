<?php

namespace Netzmacht\Bootstrap\Components\Button\Dropdown;

use Netzmacht\Html\Attributes;

/**
 * Dropdown items divider.
 *
 * @package Netzmacht\Bootstrap\Buttons\Helper\Dropdown
 */
class Divider extends Attributes implements ItemInterface
{
    /**
     * Construct.
     *
     * @param array $attributes Html attributes.
     */
    public function __construct(array $attributes = array())
    {
        $attributes = array_merge_recursive(
            array(
                'role'  => 'presentation',
                'class' => array('divider'),
            ),
            $attributes
        );

        parent::__construct($attributes);
    }

    /**
     * Generate the divider.
     *
     * @return string
     */
    public function generate()
    {
        return sprintf('<li %s></li>', parent::generate());
    }
}
