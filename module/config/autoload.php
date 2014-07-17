<?php

TemplateLoader::addFiles(array
(
	'ce_bootstrap_buttons'                     => 'system/modules/bootstrap-components/templates',
	'ce_bootstrap_button'                      => 'system/modules/bootstrap-components/templates',
	'ce_bootstrap_carousel'                    => 'system/modules/bootstrap-components/templates',
	'mod_bootstrap_modal'                      => 'system/modules/bootstrap-modal/templates',
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