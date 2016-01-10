<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
class users_model extends Base_module_model {
    
    public function __construct()
    {
        parent::__construct('users');
    }
    
    function form_fields($values = array()) 
    {
        $fields = parent::form_fields();
        
        $fields['username']['required']=TRUE;
        $fields['displayname']['required']=TRUE;
        $fields['password']['required']=TRUE;
        $fields['phone']['required']=TRUE;
        $fields['email']['required']=TRUE;
        $fields['activated']['required']=TRUE;
        $fields['ban_reason']['required']=TRUE;
        $fields['country_id']['required']=TRUE;
        $fields['prop_listing_limit']['required']=TRUE;

        return $fields;
    }
}

class users_model_record extends Base_module_record {
 
}


?>
