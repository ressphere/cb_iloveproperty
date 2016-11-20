<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(FUEL_PATH.'models/base_module_model.php');
require_once(APPPATH . 'libraries/phpass-0.1/PasswordHash.php');
require_once(APPPATH . 'controllers/base.php');
require_once(APPPATH . 'controllers/_utils/GeneralFunc.php');
class users_model extends Base_module_model {
    private $password_in_clear = NULL;
    public $foreign_keys = array('country_id' => 'country_model');
    public $boolean_fields = array('agent', 'activated','banned');
    public $auto_validate_fields = array('username' => 'valid_email',);
    public function __construct()
    {
        parent::__construct('users');
        $this->db->select('
            id,
            displayname,
            phone,
            username,
            country_id,
            activated,
            banned,
            ban_reason,
            prop_listing_limit,
            agent');
        
    }
    
    function form_fields($values = array()) 
    {
        $fields = parent::form_fields($values);
        $fields['id']['type']='hidden';
        $fields['password']['type']='hidden';
        $fields['new_password_key']['type']='hidden';
        $fields['new_password_requested']['type']='hidden';
        $fields['new_email']['type']='hidden';
        $fields['new_email_key']['type']='hidden';
        $fields['last_ip']['type']='hidden';
        $fields['last_login']['type']='hidden';
        $fields['created']['type']='hidden';
        $fields['oldpassword']['type']='hidden';
        $fields['modified']['type']='hidden';
        $fields['email']['type']='hidden';
        $fields['prop_listing_limit']['type']='hidden';
        
        $fields['displayname']['required']=TRUE;
        $fields['phone']['required']=TRUE;
        $fields['username']['required']=TRUE;
        //$fields['email']['required']=TRUE;
        $fields['country_id']['required']=TRUE;
        $fields['activated']['required']=TRUE;
        $fields['banned']['required']=FALSE;
        $fields['ban_reason']['required']=FALSE;
        //$fields['prop_listing_limit']['required']=TRUE;
        
        return $fields;
    }
    function random_password( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }
    function on_before_validate($values) {
        
        $values['email'] = $values['username'];
        if($values['username'] == "" || $values['username'] == NULL)
        {
            $this->password_in_clear = $password = $this->random_password();
            $ci = CI_Controller::get_instance();
            $ci->load->helper('url');
            $ci->load->library('session');
            $ci->load->library('extemplate');
            $ci->load->library("email");
            $ci->load->config('tank_auth', TRUE);
            
            $hasher = new PasswordHash($ci->config->item('phpass_hash_strength', 'tank_auth'),
                    $ci->config->item('phpass_hash_portable', 'tank_auth'));
            $hashed_password = $hasher->HashPassword($password);

            $values["password"] = $hashed_password;
            $values["created"] = datetime_now();
            $values['username'] = trim($values['email']);

            $values["last_ip"] = $_SERVER['REMOTE_ADDR'];
       
            
            $data = $values;
            $data['site_name'] = 'http://www.ressphere.com';
            $data['password'] = $this->password_in_clear;
            
            if ($ci->config->item('email_account_details'))
            {
              base::_begin_send_email('Welcome to', $data['email'], $data, $ci);
            }
        }
        
        return parent::on_before_validate($values);
    }
    
    public function model_id_list()
    {
        $model_id_list = array (
        );
        
        return $model_id_list;
    }
    
    
}

class users_model_record extends Base_module_record {
 
}


?>
