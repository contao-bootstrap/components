<?php

namespace Netzmacht\Bootstrap\Components\Button\Dropdown;

use Netzmacht\Html\Attributes;


class Header extends Attributes implements ItemInterface
{

	/**
	 * @var string
	 */
	protected $label;


	/**
	 * @param array $attributes
	 */
	function __construct(array $attributes = array())
	{
		$attributes = array_merge_recursive(
			array(
				'role'  => 'presentation',
				'class' => array('dropdown-header'),
			),
			$attributes
		);

		parent::__construct($attributes);
	}


	/**
	 * @param string $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}


	/**
	 * @return string
	 */
	public function getLabel()
	{
		return $this->label;
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		return sprintf('<li %s>%s</li>',
			parent::generate(),
			$this->label
		);
	}

} 