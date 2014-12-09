<?php

namespace Netzmacht\Bootstrap\Components\Contao\ContentElement;

use Netzmacht\Bootstrap\Components\Button\Factory;
use Netzmacht\Bootstrap\Components\Button\Group;
use Netzmacht\Bootstrap\Components\Button\Toolbar;

/**
 * Buttons content element.
 *
 * @package Netzmacht\Bootstrap
 */
class Buttons extends \ContentElement
{
    /**
     * Template name.
     *
     * @var string
     */
    protected $strTemplate = 'ce_bootstrap_buttons';

    /**
     * Compile the button toolbar.
     *
     * @return void
     */
    protected function compile()
    {
        if (!$this->bootstrap_buttonStyle) {
            $this->bootstrap_buttonStyle = 'btn-default';
        }

        $buttons = Factory::createFromFieldset($this->bootstrap_buttons);
        $buttons->eachChild(array($this, 'addButtonStyle'));

        $this->Template->buttons = $buttons;
    }

    /**
     * Add button style.
     *
     * @param mixed $child Current child.
     *
     * @return void
     */
    public function addButtonStyle($child)
    {
        if ($child instanceof Group || $child instanceof Toolbar) {
            $child->eachChild(array($this, 'addButtonStyle'));
        } else {
            $class = $child->getAttribute('class');
            $class = array_filter($class, function ($item) {
                return strpos($item, 'btn-') !== false;
            });

            if (!$class && $this->bootstrap_buttonStyle) {
                $child->addClass($this->bootstrap_buttonStyle);
            }
        }
    }
}
