<?php 
/*
|--------------------------------------------------------------------------
| Form builder 
|--------------------------------------------------------------------------
|
| Specify field types and other Form_builder configuration properties
| This file is included by the fuel/modules/fuel/config/form_builder.php file
*/
$fields['my_custom_field'] = array();
$fields['tags'] = array(
	'class'		=> 'MY_custom_fields',
	'function'	=> 'select2',
	'css' => 'select2/select2',
	'js' => array('select2/select2'),
        'filepath'	=> FUEL_PATH.'../../application/libraries/MY_custom_fields.php',
	'represents' => array('name' => 'tags'),
);
include(FUEL_PATH.'config/custom_fields.php');

/* End of file form_builder.php */
/* Location: ./application/config/form_builder.php */