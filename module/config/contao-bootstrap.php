<?php

return array(
	'wrappers' => array(
		'accordion' => array(
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
		),

		'carousel' => array(
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
		),

		'tabs' => array(
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
		),
	),

	'modal' => array(
		'dismiss'          => '<span aria-hidden="true">&times;</span>',
		'adjustForm'       => true,
	),

	'navigation' => array(
		'item-helper' => array(
			'dropdown' => 'Netzmacht\Bootstrap\Components\Navigation\ItemHelper\DropdownItemHelper'
		),
	),

	'templates' => array(
		'parsers' => array(
			'callback.replaceClasses' => array(
				'templates' => array('mod_bootstrap_modal*'),
			),
		),

		'modifiers' => array(
			'callback.replaceImageClasses' => array(
				'templates' => array('mod_bootstrap_modal*'),
			),

			'callback.replaceTableClasses' => array(
				'templates' => array('mod_bootstrap_modal*'),
			),
		),
	),
);