<?php

namespace Netzmacht\Bootstrap\Components\Contao;


use Netzmacht\Bootstrap\Core\Bootstrap;

class Hooks
{

	/**
	 * @param \Model $element
	 * @param $isVisible
	 * @return bool
	 */
	public static function setRuntimeNavClass(\Model $element, $isVisible)
	{
		// load module if it is a module include element
		if($element instanceof \ContentModel && $element->type == 'module') {
			$element = \ModuleModel::findByPK($element->module);
		}

		if(!$element instanceof \ModuleModel) {
			return $isVisible;
		}

		// do not limit for navigation module. so every module can access it

		// bootstrap_inNavbar is dynamically set of navbar module
		if($element->bootstrap_inNavbar) {
			$class = 'nav navbar-nav';

			if($element->bootstrap_navbarFloating == 'right') {
				$class .= 'navbar-right';
			}
		}
		elseif($element->bootstrap_navClass) {
			$class = $element->bootstrap_navClass;
		}
		else {
			$class = 'nav nav-default';
		}

		Bootstrap::setConfigVar('runtime.nav-class', $class);

		return $isVisible;
	}

} 