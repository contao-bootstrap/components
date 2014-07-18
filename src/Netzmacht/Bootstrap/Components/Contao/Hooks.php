<?php

namespace Netzmacht\Bootstrap\Components\Contao;


use Netzmacht\Bootstrap\Core\Bootstrap;

class Hooks
{

	/**
	 * @param \Model $element
	 * @return bool
	 */
	public static function setRuntimeNavClass(\Model $element)
	{
		if(!$element instanceof \ModuleModel) {
			return true;
		}

		$modules = Bootstrap::getConfigVar('navigation.modules', array());

		if(!in_array($element->type, $modules)) {
			return true;
		}

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

		return true;
	}

} 