<?php

namespace Netzmacht\Bootstrap\Components\Contao\ContentElement;

use Netzmacht\Bootstrap\Core\Contao\ContentElement\Wrapper;
use Netzmacht\Html\Attributes;

/**
 * Carousel content element.
 *
 * @package Netzmacht\Bootstrap\Components\Contao\ContentElement
 */
class Carousel extends Wrapper
{
    /**
     * Template name.
     *
     * @var string
     */
    protected $strTemplate = 'ce_bootstrap_carousel';

    /**
     * Carousel identifier pattern.
     *
     * @var string
     */
    protected $identifier = 'carousel-%s';

    /**
     * Compile wrapper element.
     *
     * @return void
     */
    protected function compile()
    {
        if ($this->wrapper->isTypeOf(Wrapper\Helper::TYPE_START)) {
            $cssID = $this->cssID;

            if ($cssID[0] == '') {
                $cssID[0]    = sprintf($this->identifier, $this->id);
                $this->cssID = $cssID;
            }

            $attributes = new Attributes();
            $attributes
                ->addClass('carousel')
                ->addClass('slide')
                ->setAttribute('id', $cssID[0]);

            if ($cssID[1]) {
                $attributes->addClass($cssID[1]);
            }

            if ($this->bootstrap_autostart) {
                $attributes->setAttribute('data-ride', 'carousel');
            }

            if ($this->bootstrap_interval > 0) {
                $attributes->setAttribute('data-interval', $this->bootstrap_interval);
            }

            $this->Template->attributes = $attributes;
            $this->Template->count      = $this->wrapper->countRelatedElements();
        } else {
            $start = \ContentModel::findByPk($this->bootstrap_parentId);

            if ($start !== null) {
                $start->cssID          = deserialize($start->cssID, true);
                $this->Template->start = $start;

                if ($start->cssID[0] == '') {
                    $cssID       = $start->cssID;
                    $cssID[0]    = sprintf($this->identifier, $start->id);
                    $this->cssID = $cssID;
                } else {
                    $this->cssID = $start->cssID;
                }
            }
        }

        $this->Template->identifier = $this->cssID[0];
        $this->Template->wrapper    = $this->wrapper;
    }
}
