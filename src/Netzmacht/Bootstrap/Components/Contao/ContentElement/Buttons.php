<?php

namespace Netzmacht\Bootstrap\Components\Contao\ContentElement;

use Netzmacht\Bootstrap\Components\Button\Factory;
use Netzmacht\Bootstrap\Components\Button\Button;
use Netzmacht\Bootstrap\Components\Button\ChildAware;
use Netzmacht\Bootstrap\Components\Button\Group;
use Netzmacht\Bootstrap\Components\Button\Toolbar;

/**
 * Class ContentToolbar
 * @package Netzmacht\Bootstrap
 */
class Buttons extends \ContentElement
{

	/**
	 * @var string
	 */
	protected $strTemplate = 'ce_bootstrap_buttons';


	/**
	 * compile the button toolbar
	 */
	protected function compile()
	{
		if(!$this->bootstrap_buttonStyle) {
			$this->bootstrap_buttonStyle = 'btn-default';
		}

		$buttons = Factory::createFromFieldset($this->bootstrap_buttons);
		$buttons->eachChild(array($this, 'addButtonStyle'));

		$this->Template->buttons = $buttons;
	}


	/**
	 * @param $child
	 */
	public function addButtonStyle($child)
	{
		if($child instanceof Group || $child instanceof Toolbar) {
			$child->eachChild(array($this, 'addButtonStyle'));
		}
		else {
			$child->addClass($this->bootstrap_buttonStyle);
		}
	}

}