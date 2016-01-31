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
        
        $fields['username']['type']='hidden';
        $fields['displayname']['type']='hidden';
        $fields['password']['type']='hidden';
        $fields['phone']['type']='hidden';
        $fields['email']['type']='hidden';
        $fields['new_password_key']['type']='hidden';
        $fields['new_password_requested']['type']='hidden';
        $fields['new_email']['type']='hidden';
        $fields['new_email_key']['type']='hidden';
        $fields['last_ip']['type']='hidden';
        $fields['last_login']['type']='hidden';
        $fields['created']['type']='hidden';
        $fields['country_id']['type']='hidden';
        $fields['modified']['type']='hidden';
        
        $fields['activated']['required']=TRUE;
        $fields['banned']['required']=TRUE;
        $fields['ban_reason']['required']=TRUE;
        $fields['prop_listing_limit']['required']=TRUE;

        return $fields;
    }
}

class users_model_record extends Base_module_record {
 
}


?>
