<?php

namespace Netzmacht\Bootstrap\Components\Contao;

use Netzmacht\Bootstrap\Core\Bootstrap;

/**
 * Class Hooks contains hooks which are required for the components.
 *
 * @package Netzmacht\Bootstrap\Components\Contao
 */
class Hooks
{
    /**
     * Set runtime navigation class.
     *
     * This method is triggered by the isVisibleElement Hook. This means that when being logged in as backend user
     * using the frontend preview it does not work!
     *
     * @param \Model $element   Current element model.
     * @param bool   $isVisible Visible state.
     *
     * @return bool
     */
    public static function setRuntimeNavClass(\Model $element, $isVisible)
    {
        // load module if it is a module include element
        if ($element instanceof \ContentModel && $element->type == 'module') {
            $element = \ModuleModel::findByPK($element->module);
        }

        if (!$element instanceof \ModuleModel) {
            return $isVisible;
        }

        // do not limit for navigation module. so every module can access it

        // bootstrap_inNavbar is dynamically set of navbar module
        if ($element->bootstrap_inNavbar) {
            $class = 'nav navbar-nav';

            if ($element->bootstrap_navbarFloating == 'right') {
                $class .= 'navbar-right';
            }
        } elseif ($element->bootstrap_navClass) {
            $class = $element->bootstrap_navClass;
        } else {
            $class = 'nav nav-default';
        }

        Bootstrap::setConfigVar('runtime.nav-class', $class);

        return $isVisible;
    }

    /**
     * Append modals to the html body.
     *
     * @param string $buffer Frontend template output buffer.
     *
     * @return string
     */
    public function appendModals($buffer)
    {
        $modals = implode('', Bootstrap::getConfigVar('runtime.modals', array()));
        $modals = str_replace(array('{{request_token}}', '[{]', '[}]'), array(REQUEST_TOKEN, '{{', '}}'), $modals);

        return str_replace('</body>', $modals . '</body>', $buffer);
    }
}
