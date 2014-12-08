<?php

namespace Netzmacht\Bootstrap\Components\Button\Dropdown;

use Netzmacht\Html\Attributes;

/**
 * Class Divider
 * @package Netzmacht\Bootstrap\Buttons\Helper\Dropdown
 */
class Divider extends Attributes implements ItemInterface
{

    /**
     * @param array $attributes
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
     * @return string
     */
    public function generate()
    {
        return sprintf('<li %s></li>', parent::generate());
    }

}
