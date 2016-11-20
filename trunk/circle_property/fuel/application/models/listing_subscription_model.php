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
    public $foreign_keys = array('user_id' =>  array(FUEL_FOLDER => 'users_model'));
 
    public function __construct()
    {
        parent::__construct('listing_subscription', 'users');
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }
    
    function form_fields($values = array()) 
    {
        $fields = parent::form_fields($values);
        $fields['number_of_listing'] = array('type' => 'number', 
            'represents' => 'int|smallint|mediumint|bigint', 
            'negative' => FALSE, 
            'decimal' => TRUE, 'required'=>TRUE);
        
        $fields['created_time']['required']=TRUE;
        $fields['created_time']['default']= date("Y-m-d h:i:sa", now());
        
        $fields['duration']['required']=TRUE;
        $fields['duration']['label'] = "Duration (months)";
        $users = array();
        foreach($fields['user_id']['options'] as $option)
        {
            $users[$option['id']] = $option['username'];
        }
        $fields['user_id']['type'] = 'tags';
        $fields['user_id']['options'] = $users;
        $fields['user_id']['require'] = TRUE;
        reset($users);
        $first_key = key($users);
        $fields['user_id']["default"] = $first_key;
        
        
        return $fields;
    }
    
    /*
    * This API will impact all the query statement for this model
    */
    function _common_query()
    {
    }
    
    
}

class listing_subscription_model_record extends Base_module_record {
 
}

?>
