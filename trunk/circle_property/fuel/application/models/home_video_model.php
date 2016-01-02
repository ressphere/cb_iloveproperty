<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
class home_video_model extends Base_module_model {
    
    public function __construct()
    {
        parent::__construct('CB_Home_video');
    }
    
    function form_fields($values = array()) 
    {
        $fields = parent::form_fields();
        
        $fields['video_name']['required']=TRUE;
        $fields['video_path']['required']=TRUE;
        return $fields;
    }
   
}
    
class home_video_model_record extends Base_module_record
{
}

?>
