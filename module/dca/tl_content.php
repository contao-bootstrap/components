<?php


// bootstrap_button palette
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_button extends _bootstrap_empty_'] = array
(
	'link'      => array('url', 'target', 'linkTitle', 'titleText', 'rel', 'bootstrap_icon', 'bootstrap_dataAttributes'),
	'expert'    => array(':hide', 'guests', 'cssID', 'space'),
	'invisible' => array(':hide', 'invisible', 'start', 'stop'),
);

$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_buttons extends _bootstrap_default_'] = array
(
	'config' => array('bootstrap_buttons', 'bootstrap_buttonStyle'),
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_buttonStyle'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttonStyle'],
	'exclude'   => true,
	'inputType' => 'text',
	'reference' => &$GLOBALS['TL_LANG']['tl_content'],
	'eval'      => array('tl_class' => 'w50',),
	'sql'       => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_buttons'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons'],
	'exclude'   => true,
	'inputType' => 'multiColumnWizard',

	'eval'      => array(
		'tl_class'       => 'bootstrapMultiColumnWizard hideSubLabels',
		'decodeEntities' => true,
		'columnFields'   => array
		(
			'type'       => array
			(
				'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_type'],
				'exclude'   => true,
				'inputType' => 'select',
				'options'   => array('link', 'group', 'dropdown', 'child', 'header'),
				'reference' => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_types'],
				'eval'      => array('style' => 'width: 90px;', 'valign' => 'top'),
			),

			'label'      => array
			(
				'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_label'],
				'exclude'   => true,
				'inputType' => 'text',
				'eval'      => array('style' => 'width: 90px', 'valign' => 'top', 'allowHtml' => true,),
			),

			'url'        => array
			(
				'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_url'],
				'exclude'   => true,
				'inputType' => 'text',
				'eval'      => array('style' => 'width: 90px', 'valign' => 'top', 'rgxp' => 'url', 'decodeEntities' => true, 'tl_class' => 'wizard'),
				'wizard'    => array
				(
					array('Netzmacht\Bootstrap\Core\Contao\DataContainer\Module', 'pagePicker')
				),
			),

			'attributes' => array
			(
				'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_attributes'],
				'exclude'   => true,
				'inputType' => 'multiColumnWizard',
				'options'   => array('data-dismiss="modal"', 'class="btn-default"'),
				'eval'      => array
				(

					'decodeEntities' => true,
					'columnFields'   => array
					(
						'name'  => array
						(
							'inputType' => 'text',
							'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_attributes_name'],
							'options'   => array('class', 'title', 'data-'),
							'exclude'   => true,
							'eval'      => array
							(
								'includeBlankOption' => true,
								'style'              => 'width: 100px;',
								'placeholder'        => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_attributes_name'],
							),
						),

						'value' => array
						(
							'inputType' => 'text',
							'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_attributes_value'],
							'exclude'   => true,
							'eval'      => array('style' => 'width: 100px', 'placeholder' => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_attributes_value']),
						),
					),
				),
			),
		),
	),
	'sql'       => "blob NULL"
);
