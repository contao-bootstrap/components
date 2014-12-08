<?php

// Content elements
$GLOBALS['TL_CTE']['links']['bootstrap_button']                     = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Button';
$GLOBALS['TL_CTE']['links']['bootstrap_buttons']                    = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Buttons';

$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselStart'] = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Carousel';
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselPart']  = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Carousel';
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselEnd']   = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Carousel';

$GLOBALS['TL_CTE']['accordion']['bootstrap_accordionGroupStart']    = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\AccordionGroup';
$GLOBALS['TL_CTE']['accordion']['bootstrap_accordionGroupEnd']      = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\AccordionGroup';

$GLOBALS['TL_CTE']['bootstrap_tabs']['bootstrap_tabStart']          = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Tab';
$GLOBALS['TL_CTE']['bootstrap_tabs']['bootstrap_tabPart']           = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Tab';
$GLOBALS['TL_CTE']['bootstrap_tabs']['bootstrap_tabEnd']            = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Tab';

// Frontend modules
$GLOBALS['FE_MOD']['miscellaneous']['bootstrap_modal']  = 'Netzmacht\Bootstrap\Components\Contao\Module\Modal';
$GLOBALS['FE_MOD']['navigationMenu']['bootstrap_navbar'] = 'Netzmacht\Bootstrap\Components\Contao\Module\Navbar';

// Hooks
$GLOBALS['TL_HOOKS']['isVisibleElement'][]       = array('Netzmacht\Bootstrap\Components\Contao\Hooks', 'setRuntimeNavClass');
$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array('Netzmacht\Bootstrap\Components\Contao\Hooks', 'appendModals');

// Event Subscribers
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Netzmacht\Bootstrap\Components\Modal\Subscriber';

// Wrapper settings
$GLOBALS['TL_WRAPPERS']['start'][]      = 'bootstrap_carouselStart';
$GLOBALS['TL_WRAPPERS']['start'][]      = 'bootstrap_accordionGroupStart';
$GLOBALS['TL_WRAPPERS']['separator'][]  = 'bootstrap_carouselPart';
$GLOBALS['TL_WRAPPERS']['stop'][]       = 'bootstrap_carouselEnd';
$GLOBALS['TL_WRAPPERS']['stop'][]       = 'bootstrap_accordionGroupEnd';
$GLOBALS['TL_WRAPPERS']['start'][]      = 'bootstrap_tabStart';
$GLOBALS['TL_WRAPPERS']['stop'][]       = 'bootstrap_tabEnd';
$GLOBALS['TL_WRAPPERS']['separator'][]  = 'bootstrap_tabPart';
