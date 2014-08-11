<?php

namespace Netzmacht\Bootstrap\Components\Contao\Module;

use Netzmacht\Bootstrap\Core\Bootstrap;


/**
 * Class NavbarModule
 * @package Netzmacht\Bootstrap\Components\Contao\Module
 */
class Navbar extends \Module
{
	/**
	 * @var string
	 */
	protected $strTemplate = 'mod_navbar';


	/**
	 * @param        $module
	 * @param string $column
	 */
	public function __construct($module, $column='main')
	{
		parent::__construct($module, $column);

		if($this->bootstrap_navbarTemplate != '') {
			$this->strTemplate = $this->bootstrap_navbarTemplate;
		}
	}


	/**
	 * Compile the current element
	 */
	protected function compile()
	{
		$config  = deserialize($this->bootstrap_navbarModules, true);
		$modules = array();
		$ids     = array();

		// get ids
		foreach($config as $index => $module) {
			$ids[$index] = intval($module['module']);
		}

		// prefetch modules, so only 1 query is required
		$ids        = implode(',', $ids);
		$collection = \ModuleModel::findBy(array('tl_module.id IN(' . $ids . ')'), array());
		$models     = array();

		if($collection) {
			while($collection->next()) {
				$model = $collection->current();
				$model->bootstrap_inNavbar = true;

				$models[$model->id] = $model;
			}
		}

		foreach ($config as $module) {
			$id = $module['module'];

			if($id != '' && array_key_exists($id, $models)) {
				$modules[] = $this->generateModule($module, $models[$id]);
			}
		}

		if($this->cssID[1] == '') {
			$cssID    = $this->cssID;
			$cssID[1] = 'navbar-default';

			$this->cssID = $cssID;
		}

		$this->Template->modules = $modules;
	}


	/**
	 * @param $module
	 * @param \ModuleModel $model
	 * @return array
	 */
	protected function generateModule($module, \ModuleModel $model)
	{
		$class = $module['cssClass'];

		if($module['floating']) {
			if($class != '') {
				$class .= ' ';
			}

			$class .= 'navbar-' . $module['floating'];
		}

		// TODO: Do we have to make this list configurable?
		if(in_array($model->type, array('navigation', 'customnav', 'quicklink'))) {
			$navClass = 'nav navbar-nav';

			if($module['floating']) {
				$navClass .= ' navbar-' . $module['floating'];
			}

			Bootstrap::setConfigVar('runtime.nav-class', $navClass);
		}

		$rendered = $this->getFrontendModule($model);
		Bootstrap::setConfigVar('runtime.nav-class', '');

		return array(
			'type'   => 'module',
			'module' => $rendered,
			'id'     => $module['module'],
			'class'  => $class,
		);
	}

} 