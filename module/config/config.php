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
$GLOBALS['TL_HOOKS']['isVisibleElement'][] = array('Netzmacht\Bootstrap\Components\Contao\Hooks', 'setRuntimeNavClass');

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

$GLOBALS['BOOTSTRAP']['wrappers']['tabs'] = array
(
	'start' => array
	(
		'name'          => 'bootstrap_tabStart',
		'triggerCreate' => true, // auto create separators and stop element
		'triggerDelete' => true, // auto delete separators and stop element
	),

	'separator' => array
	(
		'name'          => 'bootstrap_tabPart',
		'autoCreate'    => true, // can be auto created
		'autoDelete'    => true, // can be auto deleted

		// callback to detect how many separators exists
		'countExisting' => array('Netzmacht\Bootstrap\Components\Contao\DataContainer\Content', 'countExistingTabSeparators'),

		// callback to detect how many separators are required
		'countRequired' => array('Netzmacht\Bootstrap\Components\Contao\DataContainer\Content', 'countRequiredTabSeparators'),
	),

	'stop' => array
	(
		'name'       => 'bootstrap_tabEnd',
		'autoCreate' => true,
		'autoDelete' => true,
	),
);


// Bootstrap modal
$GLOBALS['BOOTSTRAP']['modal'] = array
(
	'dismiss'          => '<span aria-hidden="true">&times;</span>',
	'adjustForm'       => true,
	'remoteUrl'        => 'SimpleAjax.php?action=bootstrap_modal&page=%s&modal=%s',
	'remoteDynamicUrl' => 'SimpleAjax.php?action=bootstrap_modal&page=%s&modal=%s&dynamic=%s&id=%s',
);


// navigation stragety is used to render items
$GLOBALS['BOOTSTRAP']['navigation']['strategies']['navbar'] = 'Netzmacht\Bootstrap\Components\Navigation\ItemHelper\NavbarItemHelper';

// navigation modules, used to set runtime nav class
$GLOBALS['BOOTSTRAP']['navigation']['modules'][] = 'navigation';
$GLOBALS['BOOTSTRAP']['navigation']['modules'][] = 'customnav';
$GLOBALS['BOOTSTRAP']['navigation']['modules'][] = 'quicknav';
$GLOBALS['BOOTSTRAP']['navigation']['modules'][] = 'quicklink';
$GLOBALS['BOOTSTRAP']['navigation']['modules'][] = 'articlenav';
$GLOBALS['BOOTSTRAP']['navigation']['modules'][] = 'breadcrumb';

// parse modal templates, as it is usually added after parseTemplate hooks
$GLOBALS['BOOTSTRAP']['templates']['parsers']['callback.replaceClasses']['templates'][]        = 'mod_bootstrap_modal*';
$GLOBALS['BOOTSTRAP']['templates']['modifiers']['callback.replaceImageClasses']['templates'][] = 'mod_bootstrap_modal*';
$GLOBALS['BOOTSTRAP']['templates']['modifiers']['callback.replaceTableClasses']['templates'][] = 'mod_bootstrap_modal*';