<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Components\Panel;

use Netzmacht\Bootstrap\Core\Bootstrap;

/**
 * Class Helper
 * @package Netzmacht\Bootstrap\Panel\Panel
 */
class Helper
{
    /**
     * @return string
     */
    public static function getGroup()
    {
        return Bootstrap::getConfigVar('runtime.accordion-group');
    }

    /**
     * @param \Template $template
     * @return string
     */
    public static function preparePanel(\Template $template)
    {
        self::setAccordionState($template);
        self::setPanelClass($template);

        return static::getGroup();
    }

    /**
     * @param \Template $template
     */
    public static function setAccordionState(\Template $template)
    {
        $group = static::getGroup();

        if ($group) {
            if (Bootstrap::getConfigVar('runtime.accordion-group-first')) {
                $template->accordion = 'collapse in';
                Bootstrap::setConfigVar('runtime.accordion-group-first', false);
            } else {
                $template->accordion = 'collapse';
            }
        } else {
            $template->accordion = $template->accordion == 'accordion' ? 'collapse' : $template->accordion;
        }
    }

    /**
     * @param \Template $template
     */
    public static function setPanelClass(\Template $template)
    {
        if ($template->class) {
            $template->class = 'panel panel-default';
        }
    }

}
