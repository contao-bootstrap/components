<?php

namespace Netzmacht\Bootstrap\Components\Button;

class Group extends ChildAware
{

	/**
	 * @param array $attributes
	 */
	function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->addClass('btn-group');
	}

} 