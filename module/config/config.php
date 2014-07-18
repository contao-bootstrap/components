<?php

// Content elements
$GLOBALS['TL_CTE']['links']['bootstrap_button']                     = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Button';
$GLOBALS['TL_CTE']['links']['bootstrap_buttons']                    = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Buttons';

$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselStart'] = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Carousel';
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselPart']  = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Carousel';
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselEnd']   = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Carousel';

$GLOBALS['TL_CTE']['accordion']['bootstrap_accordionGroupStart']    = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\AccordionGroup';
$GLOBALS['TL_CTE']['accordion']['bootstrap_accordionGroupEnd']      = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\AccordionGroup';


// Frontend modules
$GLOBALS['FE_MOD']['miscellaneous']['bootstrap_modal']  = 'Netzmacht\Bootstrap\Components\Contao\Module\Modal';
$GLOBALS['FE_MOD']['navigationMenu']['bootstrap_navbar'] = 'Netzmacht\Bootstrap\Components\Contao\Module\Navbar';


// Event Subscribers
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Netzmacht\Bootstrap\Components\Modal\Subscriber';


// Wrapper settings
$GLOBALS['TL_WRAPPERS']['start'][]      = 'bootstrap_carouselStart';
$GLOBALS['TL_WRAPPERS']['start'][]      = 'bootstrap_accordionGroupStart';
$GLOBALS['TL_WRAPPERS']['separator'][]  = 'bootstrap_carouselPart';
$GLOBALS['TL_WRAPPERS']['stop'][]       = 'bootstrap_carouselEnd';
$GLOBALS['TL_WRAPPERS']['stop'][]       = 'bootstrap_accordionGroupEnd';


// Bootstrap wrapper configuration
$GLOBALS['BOOTSTRAP']['wrappers']['carousel'] = array(
	'start' => array(
		'name'          => 'bootstrap_carouselStart',
		'autoCreate'    => true,
		'triggerCreate' => true,
		'triggerDelete' => true,
	),

	'separator' => array(
		'name'          => 'bootstrap_carouselPart',
		'triggerCreate' => false,
		'autoDelete'    => true,

	),

	'stop' => array(
		'name'          => 'bootstrap_carouselEnd',
		'autoCreate'    => true,
		'autoDelete'    => true,
	),
);

$GLOBALS['BOOTSTRAP']['wrappers']['accordion'] = array(
	'start' => array
	(
		'name'          => 'bootstrap_accordionGroupStart',
		'autoCreate'    => true,
		'autoDelete'    => true,
		'triggerCreate' => true,
		'triggerDelete' => true,
	),

	'stop' => array
	(
		'name'          => 'bootstrap_accordionGroupEnd',
		'autoCreate'    => true,
		'autoDelete'    => true,
		'triggerCreate' => true,
		'triggerDelete' => true,
	),
);


// Bootstrap modal
$GLOBALS['BOOTSTRAP']['modal'] = array
(
	'dismiss'          => '&times;',
	'adjustForm'       => true,
	'remoteUrl'        => 'SimpleAjax.php?page=%s&amp;modal=%s',
	'remoteDynamicUrl' => 'SimpleAjax.php?page=%s&amp;modal=%s&amp;dynamic=%s&amp;id=%s',
);

// #navClass# placeholder is used for injecting defined nav classes to the rendered items
$GLOBALS['BOOTSTRAP']['templates']['modifiers']['callback.setRuntimeNavClass'] = array
(
	'type'      => 'callback',
	'replace'   => array('Netzmacht\Bootstrap\Components\Contao\Hooks', 'setRuntimeNavClass'),
	'templates' => array
	(
		'mod_navigation*',
		'mod_customnav*',
	),
);

$GLOBALS['BOOTSTRAP']['navigation']['strategies']['navbar'] = 'Netzmacht\Bootstrap\Components\Navigation\ItemHelper\NavbarItemHelper';