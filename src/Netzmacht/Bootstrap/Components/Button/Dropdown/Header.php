<?php

namespace Netzmacht\Bootstrap\Components\Button\Dropdown;

use Netzmacht\Html\Attributes;

/**
 * Dropdown header.
 *
 * @package Netzmacht\Bootstrap\Components\Button\Dropdown
 */
class Header extends Attributes implements ItemInterface
{
    /**
     * Header label.
     *
     * @var string
     */
    protected $label;

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
                'class' => array('dropdown-header'),
            ),
            $attributes
        );

        parent::__construct($attributes);
    }

    /**
     * Set the label.
     *
     * @param string $label Header label.
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Generate the header.
     *
     * @return string
     */
    public function generate()
    {
        return sprintf(
            '<li %s>%s</li>',
            parent::generate(),
            $this->label
        );
    }
}
