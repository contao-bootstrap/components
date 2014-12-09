<?php

namespace Netzmacht\Bootstrap\Components\Button;

use Netzmacht\Html\Attributes;
use Netzmacht\Html\CastsToString;

/**
 * Button element.
 *
 * @package Netzmacht\Bootstrap\Components\Button
 */
class Button extends Attributes implements CastsToString
{
    /**
     * Button tag.
     *
     * @var string
     */
    protected $tag = 'a';

    /**
     * Button label.
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
                'class' => array('btn'),
            ),
            $attributes
        );

        parent::__construct($attributes);
    }

    /**
     * Set the tag.
     *
     * @param string $tag Html tag name.
     *
     * @return $this
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get the tag.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set the label.
     *
     * @param mixed $label Button label.
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
     * @return string|CastsToString
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Generate the button.
     *
     * @return string
     */
    public function generate()
    {
        return sprintf(
            '<%s %s>%s</%s>%s',
            $this->tag,
            parent::generate(),
            $this->label,
            $this->tag,
            PHP_EOL
        );
    }
}
