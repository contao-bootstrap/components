<?php

namespace Netzmacht\Bootstrap\Components\Contao\ContentElement;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Html\Attributes;

/**
 * Button content element.
 *
 * @package Netzmacht\Bootstrap
 */
class Button extends \ContentElement
{
    /**
     * Template name.
     *
     * @var string
     */
    protected $strTemplate = 'ce_bootstrap_button';

    /**
     * Compile button element, inspired by ContentHyperlink.
     *
     * @return void
     */
    protected function compile()
    {
        $attributes = new Attributes();

        $this->setLinkTitle($attributes);
        $this->setHref($attributes);
        $this->setCssClass($attributes);
        $this->enableLightbox($attributes);
        $this->setDataAttributes($attributes);

        // Override the link target
        if ($this->target) {
            $attributes->setAttribute('target', '_blank');
        }

        if ($this->bootstrap_icon) {
            $this->Template->icon = Bootstrap::generateIcon($this->bootstrap_icon);
        }

        $this->Template->attributes = $attributes;
        $this->Template->link       = $this->linkTitle;
    }

    /**
     * Set title link.
     *
     * @param Attributes $attributes Link attributes.
     *
     * @return void
     */
    protected function setLinkTitle(Attributes $attributes)
    {
        if ($this->linkTitle == '') {
            $this->linkTitle = $this->url;
        }
        // See Contao issue: #6258
        if (TL_MODE !== 'BE') {
            $attributes->setAttribute('title', $this->titleText ?: $this->linkTitle);
        }
    }

    /**
     * Set Link href.
     *
     * @param Attributes $attributes Link attributes.
     *
     * @return void
     */
    protected function setHref(Attributes $attributes)
    {
        if (substr($this->url, 0, 7) == 'mailto:') {
            $attributes->setAttribute('href', \String::encodeEmail($this->url));
        } else {
            $attributes->setAttribute('href', ampersand($this->url));
        }
    }

    /**
     * Set css classes.
     *
     * @param Attributes $attributes Link attributes.
     *
     * @return void
     */
    protected function setCssClass(Attributes $attributes)
    {
        $attributes->addClass('btn');

        if ($this->cssID[1] == '') {
            $attributes->addClass('btn-default');
        } else {
            $attributes->addClass($this->cssID[1]);
        }
    }

    /**
     * Enable lightbox.
     *
     * @param Attributes $attributes Link attributes.
     *
     * @return void
     */
    protected function enableLightbox(Attributes $attributes)
    {
        if (!$this->rel) {
            return;
        }

        if (strncmp($this->rel, 'lightbox', 8) !== 0) {
            $attributes->setAttribute('rel', $this->rel);
        } else {
            $attributes->setAttribute('data-lightbox', substr($this->rel, 9, -1));
        }
    }

    /**
     * Set data attributes.
     *
     * @param Attributes $attributes Link attributes.
     *
     * @return void
     */
    protected function setDataAttributes(Attributes $attributes)
    {
        // add data attributes
        $this->bootstrap_dataAttributes = deserialize($this->bootstrap_dataAttributes, true);

        if (empty($this->bootstrap_dataAttributes)) {
            return;
        }

        foreach ($this->bootstrap_dataAttributes as $attribute) {
            if (trim($attribute['value']) != '' && $attribute['name'] != '') {
                $attributes->setAttribute('data-' . $attribute['name'], $attribute['value']);
            }
        }
    }
}
