<?php

namespace Netzmacht\Bootstrap\Components\Button;

use Netzmacht\Html\Attributes;
use Netzmacht\Html\CastsToString;

class Button extends Attributes implements CastsToString
{

	/**
	 * @var string
	 */
	protected $tag = 'a';

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
				'class' => array('btn'),
			),
			$attributes
		);

		parent::__construct($attributes);
	}


	/**
	 * @param string $tag
	 */
	public function setTag($tag)
	{
		$this->tag = $tag;
	}


	/**
	 * @return string
	 */
	public function getTag()
	{
		return $this->tag;
	}


	/**
	 * @param mixed $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}


	/**
	 * @return mixed
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
		return sprintf(
			'<%s %s>%s</%s>%s',
			$this->tag,
			parent::generate(),
			$this->label,
			$this->tag,
			PHP_EOL
		);
	}

} 