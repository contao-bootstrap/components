<?php

namespace Netzmacht\Bootstrap\Components\Navigation;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Html\Attributes;

/**
 * Class Helper
 * @package Netzmacht\Bootstrap\Navigation
 */
class Helper
{

	/**
	 * @var \FrontendTemplate
	 */
	protected $template;

	/**
	 * @var bool
	 */
	protected $newList = true;

	/**
	 * @var Attributes
	 */
	protected $listAttributes;

	/**
	 * @var \ModuleModel
	 */
	protected $module;

	/**
	 * @var callable
	 */
	protected $itemHelperFactory;


	/**
	 * @param \FrontendTemplate $template
	 * @param Callable $itemHelperFactory
	 */
	function __construct(\FrontendTemplate $template, $itemHelperFactory)
	{
		$this->template          = $template;
		$this->listAttributes    = new Attributes();
		$this->itemHelperFactory = $itemHelperFactory;

		$this->initialize();
	}


	/**
	 * @param \FrontendTemplate $template
	 * @param $strategy
	 * @throws \InvalidArgumentException
	 * @return static
	 */
	public static function create(\FrontendTemplate $template, $strategy)
	{
		$factory = Bootstrap::getConfigVar('navigation.strategies' . $strategy);

		if(!$factory) {
			throw new \InvalidArgumentException(sprintf('Navigation strategy "%s" is not registered', $strategy));
		}

		return new static($template, $factory);
	}


	/**
	 * @return \FrontendTemplate
	 */
	public function getTemplate()
	{
		return $this->template;
	}


	/**
	 * @param array $item
	 * @return ItemHelper
	 */
	public function getItemHelper(array $item)
	{
		if(is_string($this->itemHelperFactory)) {
			$class  = $this->itemHelperFactory;
			$helper = new $class($item, $this->template);
		}
		else {
			$helper = call_user_func($this->itemHelperFactory, $item, $this->template);
		}

		return $helper;
	}


	/**
	 * @return bool
	 */
	public function isChildrenList()
	{
		return $this->newList;
	}


	/**
	 * @param boolean $newList
	 */
	public function setChildrenList($newList)
	{
		$this->newList = $newList;
	}


	/**
	 * @param Attributes $listAttributes
	 */
	public function setListAttributes(Attributes $listAttributes)
	{
		$this->listAttributes = $listAttributes;
	}


	/**
	 * @return Attributes
	 */
	public function getListAttributes()
	{
		return $this->listAttributes;
	}

	/**
	 * Initialize
	 */
	private function initialize()
	{
		$level      = substr($this->template->level, 6);
		$attributes = $this->listAttributes;

		$attributes->addClass($this->template->level);

		switch($level) {
			case '1':
				$class = Bootstrap::getConfigVar('runtime.nav-class');
				if($class) {
					$attributes->addClass('nav');
					$attributes->addClass($class);
					Bootstrap::setConfigVar('runtime.nav-class', '');
				}
				else {
					$attributes->addClass('__NAVCLASS__');
				}

				break;

			case '2':
				$attributes->addClass('dropdown-menu');
				break;

			default:
				$attributes->addClass('dropdown-menu')->addClass('collapse');
				break;
		}

		if($level > 1) {
			$disableChildrenList = !($this->template->items && ($level != 1 && ($level % 2) == 1));
			$this->setChildrenList($disableChildrenList);
		}
	}
} 