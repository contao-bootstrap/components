<?php

TemplateLoader::addFiles(array
(
	'ce_bootstrap_buttons'   => 'system/modules/bootstrap-components/templates',
	'ce_bootstrap_button'    => 'system/modules/bootstrap-components/templates',
	'ce_bootstrap_carousel'  => 'system/modules/bootstrap-components/templates',
	'ce_accordion'           => 'system/modules/bootstrap-components/templates',
	'ce_accordion_group'     => 'system/modules/bootstrap-components/templates',
	'ce_accordion_start'     => 'system/modules/bootstrap-components/templates',
	'ce_bootstrap_tab'       => 'system/modules/bootstrap-components/templates',
	'mod_bootstrap_modal'    => 'system/modules/bootstrap-components/templates',
	'mod_navbar'             => 'system/modules/bootstrap-components/templates',
	'mod_navbar_container'   => 'system/modules/bootstrap-components/templates',
	'navbar'                 => 'system/modules/bootstrap-components/templates',
	'navbar_brand'           => 'system/modules/bootstrap-components/templates',
	'navbar_toggle'          => 'system/modules/bootstrap-components/templates',
	'nav_bootstrap_dropdown' => 'system/modules/bootstrap-components/templates',
));

if(version_compare(VERSION, '3.3', '<')) {
	TemplateLoader::addFiles(array
	(
		'formhelper_layout_bootstrap_hidden' => 'system/modules/bootstrap-modal/templates/3.2',
	));
}
else {
	TemplateLoader::addFiles(array
	(
		'formhelper_layout_bootstrap_hidden' => 'system/modules/bootstrap-modal/templates/3.3',
	));
}