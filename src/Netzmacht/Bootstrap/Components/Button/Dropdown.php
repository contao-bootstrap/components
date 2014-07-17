<?php

namespace Netzmacht\Bootstrap\Components\Button;


use Netzmacht\Bootstrap\Components\Button\Dropdown\ItemInterface;
use Netzmacht\Bootstrap\Core\Bootstrap;

class Dropdown extends ChildAware
{

	/**
	 * @var Button
	 */
	protected $toggle;

	/**
	 * @param array $attributes
	 */
	function __construct(array $attributes = array())
	{
		$attributes = array_merge_recursive(
			array(
				'class'       => array('btn', 'dropdown-toggle'),
				'data-toggle' => 'dropdown'
			),
			$attributes
		);

		$this->toggle = new Button();

		parent::__construct($attributes);
	}


	/**
	 * @param $label
	 */
	public function setLabel($label)
	{
		$this->toggle->setLabel($label);
	}


	/**
	 * @return mixed
	 */
	public function getLabel()
	{
		return $this->toggle->getLabel();
	}


	/**
	 * @param ItemInterface $child
	 * @return $this
	 */
	public function addChild($child)
	{
		return parent::addChild($child);
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		$toggle = clone $this->toggle;
		$toggle->addAttributes($this->attributes);
		$toggle->setLabel($toggle->getLabel() . ' ' . Bootstrap::getConfigVar('dropdown.toggle'));

		return sprintf(
			'%s<ul class="dropdown-menu">%s%s</ul>',
			$toggle,
			PHP_EOL,
			$this->generateChildren()
		);
	}


	/**
	 * @return string
	 */
	protected function generateChildren()
	{
		$buffer = '';

		foreach($this->children as $child) {
			$buffer .= $child->generate();
			$buffer .= PHP_EOL;
		}

		return $buffer;
	}
} 