<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('_utils/cb_base_module_model.php');

class aroundyou_company_model extends cb_base_module_model {
    // ------------ Setup Function ---------------------------------------------
    public $model_name = "aroundyou_company";
    public $model_code = "MAYou_C";
    
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
        $this->set_error($this->model_code."-CL-0", 
                "Internal error, please contact admin", 
                "Using fuel model to resolve ".$this->model_name." and not this old way");
        
        return $column_list;
    }
    
    //--------------------- Generic Function -----------------------------------
    
    // ------------ model setup ------------------------------------------------
    // Following section is use to control the fuelcms dashboard and impact usual behaviorual
    
    // -- Special handler --
    // To map the id with corresponding table, since all model is place in this file
    //  therefore, calling it own file "aroundyou_users_model"
    
    public $foreign_keys  = array(
        'aroundyou_company_type_id' => 'aroundyou_company_type_model',
        'aroundyou_operation_period_id' => 'aroundyou_operation_period_model',
        'aroundyou_map_location_id' => 'aroundyou_map_location_model',
        'aroundyou_users_id' => 'aroundyou_users_model',
        );

    /*
     * This is to display the fuel admin summary page for "Aroundyou Users"
     */
    function list_items($limit = NULL, $offset = NULL, $col = 'name', $order = 'asc', $just_count = FALSE)
    {
        /*
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
         */
        $data = parent::list_items($limit, $offset, $col, $order, $just_count);
        return $data;
        
    }
    
    /*
     * This to form the admin fuel page display and edit for "Aroundyou Users"
     */
    function form_fields($values = array(), $related = array())
    {
        $fields = parent::form_fields($values, $related);
        
        // Email handle
        $fields['aroundyou_company__email'] = array(
            'type' => 'email', 
            );
        
        
        // Prepare for user id selection
        $CI =& get_instance();
        $related_aroundyou_users_model = $this->load_related_model('aroundyou_users_model');
        $related_users_model = $this->load_related_model('users_model');
        
        $users = array();
        foreach($fields['aroundyou_users_id']['options'] as $key => $option)
        {
            $aroundyou_user_info = $CI->$related_aroundyou_users_model->find_all(array("id" => $key), "","","","array");
            $user_info =  $CI->$related_users_model->find_all(array("id" => $aroundyou_user_info[0]["users_id"]), "","","","array");
            $users[$key] = $user_info[0]["username"];
        }
        
        $fields['aroundyou_users_id'] = array(
            'name' => "User Reigster Company",
            'type' => 'select', 
            'options' => $users, 
            //'model' => 'aroundyou_users_model',
            'require' => true,
        );
        
        // Operation with auto
        $fields['aroundyou_company__operation_auto'] = array(
            'type' => 'select',
            'options' => array(0 => 'Not Activated', 1 => 'Activated'),
            'require' => true
        );
        
        // Hide from page display
        $fields['aroundyou_company__modified'] = array(
            'type' => 'datetime|timestamp',
            'displayonly' => True,
            
            );
        
        // Activated or not
        $fields['aroundyou_company__activated'] = array(
            'type' => 'select',
            'options' => array(0 => 'Not Activated', 1 => 'Activated'),
            'require' => true
        );
        
        return $fields;
    }
    
    /*
     * This will be call before update the data
     *  ->To resolve the form can't update the modified date issue
     */
    function on_before_post($values)
    {
        $_POST['aroundyou_company__modified'] = datetime_now();
        return $values;
    }
    
}

class aroundyou_company_record_model extends Base_module_record
{
}

?>
