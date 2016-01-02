<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
class home_category_model extends Base_module_model {
    
    public function __construct()
    {
        parent::__construct('CB_Home_category');
    }
    
    function form_fields($values = array()) 
    {
        $fields = parent::form_fields();
        
        $upload_path = assets_server_path('i_property/', 'images');
        $fields['category']['required']=TRUE;
        $fields['category_path']['required']=TRUE;
        $fields['category_icon']=array('required'=>TRUE, 
                                                  'type'=>'file',
                                                  'upload_path'=>$upload_path, 
                                                  'overwrite'=>TRUE, 
                                                  'xss_clean'=>TRUE,
                                                  'is_image'=>TRUE,
                                                  'allowed_types'=>'jpg|jpeg|bmp|png|gif'
                                      );
        $fields['category_mo_icon']=array('required'=>TRUE, 
                                                  'type'=>'file',
                                                  'upload_path'=>$upload_path, 
                                                  'overwrite'=>TRUE, 
                                                  'xss_clean'=>TRUE,
                                                  'is_image'=>TRUE,
                                                  'allowed_types'=>'jpg|jpeg|bmp|png|gif'
                                      );
        return $fields;
    }
   
}
    
class home_category_model_record extends Base_module_record
{
}

?>
