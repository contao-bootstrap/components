<?php

// Content elements
$GLOBALS['TL_CTE']['links']['bootstrap_button']                     = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Button';
$GLOBALS['TL_CTE']['links']['bootstrap_buttons']                    = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Buttons';

$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselStart'] = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Carousel';
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselPart']  = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Carousel';
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselEnd']   = 'Netzmacht\Bootstrap\Components\Contao\ContentElement\Carousel';


// Frontend modules
$GLOBALS['FE_MOD']['miscellaneous']['bootstrap_modal'] = 'Netzmacht\Bootstrap\Components\Contao\Module\Modal';


// Event Subscribers
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Netzmacht\Bootstrap\Components\Modal\Subscriber';

// Wrapper settings
$GLOBALS['TL_WRAPPERS']['start'][]      = 'bootstrap_carouselStart';
$GLOBALS['TL_WRAPPERS']['stop'][]       = 'bootstrap_carouselEnd';
$GLOBALS['TL_WRAPPERS']['separator'][]  = 'bootstrap_carouselPart';


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


// Bootstrap modal
$GLOBALS['BOOTSTRAP']['modal'] = array
(
	'dismiss'          => '&times;',
	'adjustForm'       => true,
	'remoteUrl'        => 'SimpleAjax.php?page=%s&amp;modal=%s',
	'remoteDynamicUrl' => 'SimpleAjax.php?page=%s&amp;modal=%s&amp;dynamic=%s&amp;id=%s',
);