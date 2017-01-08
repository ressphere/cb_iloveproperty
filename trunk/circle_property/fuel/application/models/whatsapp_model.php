<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
class whatsapp_model extends Base_module_model {
    
    public function __construct()
    {
        parent::__construct('whatsapp');
    }
    
    function form_fields($values = array()) 
    {
        $fields = parent::form_fields($values);
        $fields['username']['required']=TRUE;
        $fields['access_code']['required']=TRUE;
        return $fields;
    }
    
    function on_before_validate($values) 
    { 
        return parent::on_before_validate($values);
    }
}

class whatsapp_model_record extends Base_module_record {
 
}


?>
