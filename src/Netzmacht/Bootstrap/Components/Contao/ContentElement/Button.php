<?php

namespace Netzmacht\Bootstrap\Components\Contao\ContentElement;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Html\Attributes;


/**
 * Class ContentButton
 * @package Netzmacht\Bootstrap
 */
class Button extends \ContentElement
{
	/**
	 * @var string
	 */
	protected $strTemplate = 'ce_bootstrap_button';


	/**
	 * compile button element, inspired by ContentHyperlink
	 */
	protected function compile()
	{
		if ($this->linkTitle == '') {
			$this->linkTitle = $this->url;
		}

		$attributes = new Attributes();
		$attributes->addClass('btn');

		// @See: #6258
		if(TL_MODE != 'BE') {
			$attributes->setAttribute('title', $this->titleText ?: $this->linkTitle);
		}

		if (substr($this->url, 0, 7) == 'mailto:') {
			$attributes->setAttribute('href', \String::encodeEmail($this->url));
		}
		else {
			$attributes->setAttribute('href', ampersand($this->url));
		}

		if (strncmp($this->rel, 'lightbox', 8) !== 0) {
			$attributes->setAttribute('rel', $this->rel);
		}
		else {
			$attributes->setAttribute('data-lightbox', substr($this->rel, 9, -1));
		}

		// Override the link target
		if ($this->target) {
			$attributes->setAttribute('target', '_blank');
		}

		if($this->cssID[1] == '') {
			$attributes->addClass('btn-default');
		}
		else {
			$attributes->addClass($this->cssID[1]);
		}

		if($this->icon) {
			$this->Template->icon = Bootstrap::generateIcon($this->bootstrap_icon);
		}

		// add data attributes
		$this->bootstrap_dataAttributes = deserialize($this->bootstrap_dataAttributes, true);

		if(!empty($this->bootstrap_dataAttributes)) {
			foreach($this->bootstrap_dataAttributes as $attribute) {
				if(trim($attribute['value']) != '' && $attribute['name'] != '') {
					$attributes->setAttribute('data-' . $attribute['name'], $attribute['value']);
				}
			}
		}

		$this->Template->attributes = $attributes;
		$this->Template->link       = $this->linkTitle;
	}

}