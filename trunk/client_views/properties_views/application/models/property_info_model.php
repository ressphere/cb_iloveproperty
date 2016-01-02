<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
class property_info_model extends Base_module_model {
    
   // public $foreign_keys = array('cafe1013Category_id' => 'cafe1013category_model');	
    //public $parsed_fields = array('content', 'content_formatted');
    public function __construct()
    {
        parent::__construct('property_info');
    }
    function form_fields($values = array())
    {
             $fields = parent::form_fields();
            //$fields['published']['order'] = 1000;
             $upload_path = ltrim(assets_server_path('i_property/', 'images'),"/");
             $fields['Property_info_image'] = array('type' => 'file', 
                 'upload_path' => $upload_path, 
                 'overwrite' => TRUE, 
                 'xss_clean' => TRUE,
                 'allowed_types'=>'jpg|jpeg|bmp|png|gif');
            return $fields;
    }
}
class cb_property_info_model_record extends Base_module_record
{
}
?>
