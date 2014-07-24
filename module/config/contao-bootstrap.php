<?php

return array(
	'wrappers' => array(
		'accordion' => array(
			'start' => array
			(
				'name'          => 'bootstrap_accordionGroupStart',
				'auto-create'    => true,
				'auto-delete'    => true,
				'trigger-create' => true,
				'trigger-delete' => true,
			),

			'stop' => array
			(
				'name'          => 'bootstrap_accordionGroupEnd',
				'auto-create'    => true,
				'auto-delete'    => true,
				'trigger-create' => true,
				'trigger-delete' => true,
			),
		),

		'carousel' => array(
			'start' => array(
				'name'           => 'bootstrap_carouselStart',
				'auto-create'    => true,
				'trigger-create' => true,
				'trigger-delete' => true,
			),

			'separator' => array(
				'name'           => 'bootstrap_carouselPart',
				'trigger-create' => false,
				'auto-delete'    => true,

			),

			'stop' => array(
				'name'           => 'bootstrap_carouselEnd',
				'auto-create'    => true,
				'auto-delete'    => true,
			),
		),

		'tabs' => array(
			'start' => array
			(
				'name'           => 'bootstrap_tabStart',
				'trigger-create' => true, // auto create separators and stop element
				'trigger-delete' => true, // auto delete separators and stop element
			),

			'separator' => array
			(
				'name'           => 'bootstrap_tabPart',
				'auto-create'    => true, // can be auto created
				'auto-delete'    => true, // can be auto deleted

				// callback to detect how many separators exists
				'count-existing' => array('Netzmacht\Bootstrap\Components\Contao\DataContainer\Content', 'countExistingTabSeparators'),

				// callback to detect how many separators are required
				'count-required' => array('Netzmacht\Bootstrap\Components\Contao\DataContainer\Content', 'countRequiredTabSeparators'),
			),

			'stop' => array
			(
				'name'        => 'bootstrap_tabEnd',
				'auto-create' => true,
				'auto-delete' => true,
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
			'callback_replace-classes' => array(
				'templates' => array('mod_bootstrap_modal*'),
			),
		),

		'modifiers' => array(
			'callback_replace-image-classes' => array(
				'templates' => array('mod_bootstrap_modal*'),
			),

			'callback_replace-table-classes' => array(
				'templates' => array('mod_bootstrap_modal*'),
			),
		),
	),
);