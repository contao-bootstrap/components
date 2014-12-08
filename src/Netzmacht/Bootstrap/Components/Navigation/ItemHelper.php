<?php

namespace Netzmacht\Bootstrap\Components\Navigation;

use Netzmacht\Html\CastsToString;

/**
 * Interface ItemHelper
 * @package Netzmacht\Bootstrap\Components\Navigation
 */
interface ItemHelper extends CastsToString
{

    /**
     * @return \FrontendTemplate
     */
    public function getTemplate();

    /**
     * @return bool
     */
    public function isHeader();

    /**
     * @return array
     */
    public function getItem();

    /**
     * @return string
     */
    public function getDropdownToggle();

    /**
     * @return boolean
     */
    public function IsDropdown();

    /**
     * @param bool $asArray
     * @return string|array
     */
    public function getItemClass($asArray=false);

}
