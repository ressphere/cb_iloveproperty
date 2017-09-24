<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('_utils/cb_base_module_model.php');

class aroundyou_users_model extends cb_base_module_model {
    // ------------ Setup Function ---------------------------------------------
    public $model_name = "aroundyou_users";
    public $model_code = "MA_U";
    
    /*
     * Constructor 
     */
    public function __construct()
    {
        // Main entries table
        parent::__construct($this->model_name);
    }
    
    
    /*
     * Overlay API
     * Contain all support column list, which contain following information
     *  1. name         - Name of the column
     *  2. must_have    - Column that must exist
     * 
     * @return Array List of the column name and settings
     */
    public function column_list()
    {
        $column_list = array (
            /*
            array("name" => "aroundyou_users__activated", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_users__banned", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_users__ban_reason", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_users__company_count_limit", "must_have" => false, "is_id" => false),
            
            // Storing id
            array("name" => "users_id", "must_have" => true, "is_id" => true),
            */
        );
        
        return $column_list;
    }
    
    //--------------------- Generic Function -----------------------------------
    
    // ------------ model setup ------------------------------------------------
    // Following section is use to control the fuelcms dashboard and impact usual behaviorual
    
    // -- Special handler --
    // To map the id with corresponding table, since all model is place in this file
    //  therefore, calling it own file "aroundyou_users_model"
    
    public $foreign_keys  = array(
                                    //'users_id' => array(FUEL_FOLDER => 'users_model', 'where' => array('users.id' => 'aroundyou_users.user_id') )
                                    'users_id' => 'users_model'
                                    );
    
    /*
     * This API will impact all the query statement for this model
     */
    function _common_query()
    {
        //parent::_common_query();
        //$this->db->join('users', 'aroundyou_users.users_id = users.id', "LEFT");
    }
    
    
    /*
     * This is to display the fuel admin summary page for "Aroundyou Users"
     */
    function list_items($limit = NULL, $offset = NULL, $col = 'name', $order = 'asc', $just_count = FALSE)
    {
        $this->db->join('users', 'aroundyou_users.users_id = users.id', "LEFT");
        $this->db->select('
            aroundyou_users.id,
            users.username,
            aroundyou_users__modified,
            aroundyou_users__company_count_limit,
            aroundyou_users__activated,
            aroundyou_users__banned,
            aroundyou_users__ban_reason,
            ');
        $data = parent::list_items($limit, $offset, $col, $order, $just_count);
        return $data;
        
    }
    
    /*
     * This to form the admin fuel page display and edit for "Aroundyou Users"
     */
    function form_fields($values = array(), $related = array())
    {
        $fields = parent::form_fields($values, $related);
        
        // Hide from page display
        $fields['aroundyou_users__modified']['displayonly'] = True;
        
        // Prepare for user id selection
        foreach($fields['users_id']['options'] as $option)
        {
            $users[$option['id']] = $option['username'];
        }
        $fields['users_id'] = array(
            'type' => 'select', 
            'options' => $users, 
            'model' => 'users_model',
            'require' => True
            );
       
        // Activation form handle
        $fields['aroundyou_users__activated'] = array(
            'type' => 'select',
            'options' => array(0 => 'Not Activated', 1 => 'Activated')
            );
        
        // Band form handle
        $fields['aroundyou_users__banned'] = array(
            'type' => 'select',
            'options' => array(0 => 'Not Banned', 1 => 'Is Banned')
            );
        
        return $fields;
    }
    
    
    /**
    * Overwrites the parent option_list method
    *   -> To handle id ambigous when table join
    *
    * @access	public
    * @param	string	the name of the field to be used as the key (optional)
    * @param	string	the name of the filed to be used as the value (optional)
    * @param	mixed	the where condition to apply (optional)
    * @param	mixed	the order in which to return the results (optional)
    * @return	array 	
    */	
  /* public function options_list($key = 'id', $val = 'name', $where = array(), $order = TRUE)
   {
        //$this->db->join('users', 'aroundyou_users.users_id = users.id', "LEFT");

        if (empty($key)) $key = 'id';
        if (empty($val)) $val = 'name';

        // needed to prevent ambiguity
        if (strpos($key, '.') === FALSE)
        {
                $key = 'aroundyou_users.'.$key;
        }

        // needed to prevent ambiguity
        if (strpos($val, '.') === FALSE)
        {
                $val = 'aroundyou_users.'.$val;
        }

        $options = parent::options_list($key, $val, $where, $order);
        return $options;
   }
    */
}

class aroundyou_users_record_model extends Base_module_record
{
}

?>
