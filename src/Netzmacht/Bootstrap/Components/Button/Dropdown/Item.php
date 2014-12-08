<?php

namespace Netzmacht\Bootstrap\Components\Button\Dropdown;

use Netzmacht\Bootstrap\Components\Button\Button;
use Netzmacht\Html\Attributes;

/**
 * Class Item
 * @package Netzmacht\Bootstrap\Buttons\Helper\Dropdown
 */
class Item extends Attributes implements ItemInterface
{

    /**
     * @var
     */
    protected $button;

    /**
     * @param Button $button
     * @param array $attributes
     */
    public function __construct(Button $button, array $attributes = array())
    {
        $attributes = array_merge_recursive(
            array(
                'role'  => 'presenation',
            ),
            $attributes
        );

        $button->removeClass('btn');
        $this->button = $button;

        parent::__construct($attributes);
    }

    /**
     * @return Button
     */
    public function getButton()
    {
        return $this->button;
    }

    /**
     * @return string
     */
    public function generate()
    {
        return sprintf('<li %s>%s%s</li>', parent::generate(), PHP_EOL, $this->getButton()->generate());
    }

}
