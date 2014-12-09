<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 29.08.13
 * Time: 12:38
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap\Components\Contao\ContentElement;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Bootstrap\Core\Contao\ContentElement\Wrapper;

/**
 * Accordion group content element.
 *
 * @package Netzmacht\Bootstrapgegeg
 */
class AccordionGroup extends Wrapper
{
    /**
     * Template name.
     *
     * @var string
     */
    protected $strTemplate = 'ce_accordion_group';

    /**
     * Compile accordion group.
     *
     * @return void
     */
    protected function compile()
    {
        if ($this->wrapper->isTypeOf(Wrapper\Helper::TYPE_START)) {
            Bootstrap::setConfigVar('runtime.accordion-group', 'accordion-group-' . $this->id);
            Bootstrap::setConfigVar('runtime.accordion-group-first', true);

            $this->Template->groupId = Bootstrap::getConfigVar('runtime.accordion-group');
        } else {
            Bootstrap::setConfigVar('runtime.accordion-group', null);
            Bootstrap::setConfigVar('runtime.accordion-group-first', null);
        }
    }
}
