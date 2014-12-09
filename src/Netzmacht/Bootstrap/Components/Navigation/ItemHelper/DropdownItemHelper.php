<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Components\Navigation\ItemHelper;

use Netzmacht\Bootstrap\Components\Navigation\ItemHelper;
use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Html\Attributes;

/**
 * Class NavbarItemHelper
 * @package Netzmacht\Bootstrap\Navigation\ItemHelper
 */
class DropdownItemHelper extends Attributes implements ItemHelper
{
    /**
     * @var array
     */
    protected $item;

    /**
     * @var \FrontendTemplate
     */
    protected $template;

    /**
     * @var bool
     */
    protected $isHeader = false;

    /**
     * @var bool
     */
    protected $isDropdown = false;

    /**
     * @var array
     */
    protected $itemClass = array();

    /**
     * @param array $item
     * @param \FrontendTemplate $template
     * @param array $attributes
     */
    public function __construct(array $item, \FrontendTemplate $template, $attributes = array())
    {
        $this->item     = $item;
        $this->template = $template;

        parent::__construct($attributes);

        $this->initialize();
    }

    /**
     * @return \FrontendTemplate
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return boolean
     */
    public function isHeader()
    {
        return $this->isHeader;
    }

    /**
     * @return array
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @return string
     */
    public function getDropdownToggle()
    {
        return Bootstrap::getConfigVar('dropdown.toggle');
    }

    /**
     * @return boolean
     */
    public function isDropdown()
    {
        return $this->isDropdown;
    }

    /**
     * @param bool $asArray
     * @return string|array
     */
    public function getItemClass($asArray=false)
    {
        if ($asArray) {
            return $this->itemClass;
        }

        return implode(' ', $this->itemClass);
    }

    /**
     *
     */
    private function initialize()
    {
        $level = intval(substr($this->template->level, 6))+1;

        $this->initializeAttributes();
        $this->initializeCssClass();

        if ($this->item['type'] == 'm17Folder' || $this->item['type'] == 'folder') {
            $this->isHeader = ($level != 1 && ($level % 2) == 1);
        }

        if ($this->item['subitems'] && $level == 2) {
            $this->isDropdown = true;
        }
    }

    private function initializeAttributes()
    {
        $pass = array('href', 'accesskey', 'tabindex');
        foreach ($pass as $attribute) {
            $this->setAttribute($attribute, $this->item[$attribute]);
        }

        $title = $this->item['pageTitle'] ?: $this->item['title'];
        $this->setAttribute('title', $title);

        if ($this->item['nofollow']) {
            $this->setAttribute('rel', 'nofollow');
        }
    }

    private function initializeCssClass()
    {
        if ($this->item['class']) {
            $classes = trimsplit(' ', $this->item['class']);
            foreach ($classes as $class) {
                $this->itemClass[] = $class;
            }

            if (in_array('trail', $this->itemClass)) {
                $this->itemClass[] = 'active';
            }
        }
    }
}
