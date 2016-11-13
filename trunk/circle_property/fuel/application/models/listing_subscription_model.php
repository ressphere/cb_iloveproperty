<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of listing_subscription
 *
 * @author user
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(FUEL_PATH.'models/base_module_model.php');
require_once(APPPATH . 'libraries/phpass-0.1/PasswordHash.php');
class listing_subscription_model extends Base_module_model {
    public $foreign_keys = array('user_id' => 'users_model');
    public function __construct()
    {
        parent::__construct('listing_subscription');
        $this->db->select('
            id,
            user_id,
            number_of_listing,
            created_time,
            duration');
        
    }
   
    
    function form_fields($values = array()) 
    {
        $fields = parent::form_fields();
        date_default_timezone_set('Asia/Kuala_Lumpur');
   
        $fields['user_id']['required']=TRUE;
        $fields['number_of_listing']['required']=TRUE;
        $fields['number_of_listing']['default']=1;
        $fields['created_time']['required']=TRUE;
        $fields['created_time']['default']= date("Y-m-d h:i:sa", now());
        
        $fields['duration']['required']=TRUE;
        $fields['duration']['label'] = "Duration (months)";
        return $fields;
    }
   
    
    
}

class listing_subscription_model_record extends Base_module_record {
 
}

?>
