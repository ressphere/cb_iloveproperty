<?php 
/*
|--------------------------------------------------------------------------
| MY Custom Modules
|--------------------------------------------------------------------------
|
| Specifies the module controller (key) and the name (value) for fuel
*/


/*********************** EXAMPLE ***********************************

$config['modules']['quotes'] = array(
	'preview_path' => 'about/what-they-say',
);

$config['modules']['projects'] = array(
	'preview_path' => 'showcase/project/{slug}',
	'sanitize_images' => FALSE // to prevent false positives with xss_clean image sanitation
);

*********************** /EXAMPLE ***********************************/



/*********************** OVERWRITES ************************************/

$config['module_overwrites']['categories']['hidden'] = TRUE; // change to FALSE if you want to use the generic categories module
$config['module_overwrites']['tags']['hidden'] = TRUE; // change to FALSE if you want to use the generic tags module

// Main page modules
$config['modules']['home_category'] = array('sanitize_images' => FALSE);
$config['modules']['home_about_us'] = array('sanitize_images' => FALSE);
$config['modules']['home_video'] = array('sanitize_images' => FALSE);

// Property modules
$config['modules']['properties_listing'] = array('sanitize_images' => FALSE);
$config['modules']['facilities_properties_listing'] = array('sanitize_images' => FALSE);
$config['modules']['property_photo'] = array('sanitize_images' => FALSE);

$config['modules']['country'] = array('sanitize_images' => FALSE);
$config['modules']['facilities'] = array('sanitize_images' => FALSE);
$config['modules']['land_title_type'] = array('sanitize_images' => FALSE);
$config['modules']['location'] = array('sanitize_images' => FALSE);
$config['modules']['map_location'] = array('sanitize_images' => FALSE);
$config['modules']['properties_ref'] = array('sanitize_images' => FALSE);
$config['modules']['property_name'] = array('sanitize_images' => FALSE);
$config['modules']['property_type'] = array('sanitize_images' => FALSE);
$config['modules']['reserve_type'] = array('sanitize_images' => FALSE);
$config['modules']['furnished_type'] = array('sanitize_images' => FALSE);
$config['modules']['state'] = array('sanitize_images' => FALSE);
$config['modules']['tenure'] = array('sanitize_images' => FALSE);

//$config['modules']['property_info'] = array('sanitize_images' => FALSE);
//$config['modules']['property_package'] = array('sanitize_images' => FALSE);
//$config['modules']['property_member_transaction'] = array('sanitize_images' => FALSE);
/*********************** /OVERWRITES ************************************/
