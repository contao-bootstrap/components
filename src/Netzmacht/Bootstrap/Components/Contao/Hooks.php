<?php

namespace Netzmacht\Bootstrap\Components\Contao;


use Netzmacht\Bootstrap\Core\Bootstrap;

class Hooks
{

	/**
	 * @param \Template $template
	 * @return mixed|string
	 */
	public static function setRuntimeNavClass(\Template $template)
	{
		$class = '';

		if($template->bootstrap_inNavbar) {
			if($template->bootstrap_navbarFloating == 'right') {
				$class = 'navbar-right';
			}
		}
		elseif($template->bootstrap_navClass) {
			$class = $template->bootstrap_navClass;
		}
		else {
			$class = 'nav nav-default';
		}

		Bootstrap::setConfigVar('runtime.nav-class', $class);
	}

} 