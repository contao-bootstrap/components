<?php

namespace Netzmacht\Bootstrap\Components\Button;

use Netzmacht\Html\Attributes;

class Factory
{

    /**
     * @param $definition
     * @return Group|Toolbar
     */
    public static function createFromFieldset($definition)
    {
        $definition = self::parseDefinition($definition);
        $root       = new Group();
        $group      = $root;

        /** @var bool|Dropdown $dropdown */
        $dropdown = false;

        foreach ($definition as $button) {
            // dont add empty items
            if (self::isInvalidDefinition($button)) {
                continue;
            }

            // encode value
            $button = self::encodeVAlue($button);

            // finish dropdown
            if (self::hasToCloseDropdown($dropdown, $button)) {
                $dropdown = false;
            }

            // create new group
            if ($button['type'] == 'group') {
                $group = self::createNewGroup($root, $button, $dropdown);
            }

            // create dropdown
            elseif ($button['type'] == 'dropdown') {
                $dropdown = static::createDropdown($button['label'], $button['attributes'], true);
                $dropdownGroup = static::createGroup();
                $dropdownGroup->addChild($dropdown);

                $group->addChild($dropdownGroup);
            }

            // add dropdown child
            elseif ($button['type'] == 'child' || $button['type'] == 'header') {
                static::parseDropdownChild($dropdown, $button);
            } elseif ($dropdown !== false) {
                $child = static::createDropdownItem($button['label'], $button['url'], $button['attributes'], true);
                $dropdown->addChild($child);
            } else {
                $child = static::createButton($button['label'], $button['url'], $button['attributes'], true);
                $group->addChild($child);
            }
        }

        return $root;
    }

    /**
     * @param $label
     * @param $url
     * @param array $attributes
     * @param bool $fromFieldset
     * @return Button
     */
    public static function createButton($label, $url, array $attributes=array(), $fromFieldset=false)
    {
        $button = new Button();
        $button->setLabel($label);
        static::applyAttributes($button, $attributes, $fromFieldset);
        $button->setAttribute('href', $url);

        return $button;
    }

    /**
     * @param array $attributes
     * @param bool $fromFieldset
     * @return Group
     */
    public static function createGroup(array $attributes=array(), $fromFieldset=false)
    {
        $group = new Group();
        static::applyAttributes($group, $attributes, $fromFieldset);

        return $group;
    }

    /**
     * @param array $attributes
     * @param bool $fromFieldset
     * @return Toolbar
     */
    public static function createToolbar(array $attributes=array(), $fromFieldset=false)
    {
        $toolbar = new Toolbar();
        static::applyAttributes($toolbar, $attributes, $fromFieldset);

        return $toolbar;
    }

    /**
     * @param string $label
     * @param array $attributes
     * @param bool $fromFieldset
     * @return Dropdown
     */
    public static function createDropdown($label, array $attributes=array(), $fromFieldset=false)
    {
        $dropdown = new Dropdown();
        $dropdown->setLabel($label);

        static::applyAttributes($dropdown, $attributes, $fromFieldset);

        return $dropdown;
    }

    /**
     * @param string $label
     * @param array $attributes
     * @param bool $fromFieldset
     * @return Dropdown\Header
     */
    public static function createDropdownHeader($label, array $attributes=array(), $fromFieldset=false)
    {
        $dropdown = new Dropdown\Header();
        $dropdown->setLabel($label);

        static::applyAttributes($dropdown, $attributes, $fromFieldset);

        return $dropdown;
    }

    /**
     * @param array $attributes
     * @param bool $fromFieldset
     * @return Dropdown\Divider
     */
    public static function createDropdownDivider(array $attributes=array(), $fromFieldset=false)
    {
        $dropdown = new Dropdown\Divider();
        static::applyAttributes($dropdown, $attributes, $fromFieldset);

        return $dropdown;
    }

    /**
     * @param $label
     * @param $url
     * @param array $attributes
     * @param bool $fromFieldset
     * @return Dropdown\Item
     */
    public static function createDropdownItem($label, $url, array $attributes=array(), $fromFieldset=false)
    {
        $button = static::createButton($label, $url, $attributes, $fromFieldset);
        $button->setAttribute('role', 'menuitem');
        $dropdown = new Dropdown\Item($button);

        return $dropdown;
    }

    /**
     * @param Attributes $node
     * @param array $attributes
     * @param bool $fromFieldset
     */
    protected static function applyAttributes(Attributes $node, array $attributes, $fromFieldset=false)
    {
        if (empty($attributes)) {
            return;
        }

        if ($fromFieldset) {
            foreach ($attributes as $attribute) {
                if ($attribute['name']) {
                    if ($attribute['name'] == 'class') {
                        if (!$attribute['value']) {
                            return;
                        }

                        $attribute['value'] = explode(' ', $attribute['value']);
                    }
                    $node->setAttribute($attribute['name'], $attribute['value']);
                }
            }
        } else {
            foreach ($attributes as $name => $value) {
                if ($name) {
                    $node->setAttribute($name, $value);
                }
            }
        }
    }

    /**
     * @param $root
     * @param $button
     *
     * @return Toolbar
     */
    protected static function enableToolbar($root, $button)
    {
        if (!$root instanceof Toolbar) {
            $group = $root;
            $root  = static::createToolbar($button['attributes'], true);

            if ($group instanceof Group) {
                $root->addChild($group);
            }
        }

        return $root;
    }

    private static function parseDropdownChild($dropdown, $button)
    {
        if ($dropdown === false || !$dropdown instanceof Dropdown) {
            // TODO throw exception?
            return;
        }

        if ($button['type'] == 'child') {
            $child = static::createDropdownItem($button['label'], $button['url'], $button['attributes'], true);
        } else {
            if ($dropdown->getChildren()) {
                $child = static::createDropdownDivider();
                $dropdown->addChild($child);
            }

            $child = static::createDropdownHeader($button['label'], $button['attributes'], true);
        }

        $dropdown->addChild($child);
    }

    /**
     * @param $definition
     *
     * @return mixed
     */
    protected static function parseDefinition($definition)
    {
        if (!is_array($definition)) {
            $definition = deserialize($definition, true);

            return $definition;
        }

        return $definition;
    }

    /**
     * @param $button
     *
     * @return bool
     */
    protected static function isInvalidDefinition($button)
    {
        return $button['label'] == '' && $button['type'] != 'group' && $button['type'] != 'dropdown';
    }

    /**
     * @param $button
     *
     * @return mixed
     */
    protected static function encodeVAlue($button)
    {
        if (isset($button['button']) && $button['button'] == 'link') {
            if (substr($button['value'], 0, 7) == 'mailto:') {
                $button['value'] = \String::encodeEmail($button['value']);
            } else {
                $button['value'] = ampersand($button['value']);
            }
        }

        return $button;
    }

    /**
     * @param $root
     * @param $button
     * @param $dropdown
     *
     * @return \Netzmacht\Bootstrap\Components\Button\Group
     */
    protected static function createNewGroup(&$root, $button, &$dropdown)
    {
        $root = self::enableToolbar($root, $button);

        if ($dropdown !== false) {
            $dropdown = false;
        }

        $group = static::createGroup($button['attributes'], true);
        $root->addChild($group);

        return $group;
    }

    /**
     * @param $dropdown
     * @param $button
     *
     * @return bool
     */
    protected static function hasToCloseDropdown($dropdown, $button)
    {
        return $dropdown !== false && ($button['type'] != 'child' && $button['type'] != 'header');
    }
}
