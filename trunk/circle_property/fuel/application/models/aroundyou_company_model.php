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
        $column_list = array (
            array("name" => "aroundyou_company__logo", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_company__phone", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_company__fax", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_company__email", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_company_type_id", "must_have" => true, "is_id" => true),
            
            array("name" => "aroundyou_operation_period_id", "must_have" => false, "is_id" => true),
            array("name" => "aroundyou_company__operation_time_start", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_company__operation_time_end", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_company__operation_auto", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_company__operation_manual_date_start", "must_have" => false, "is_id" => false),
            
            array("name" => "aroundyou_company__detail_head_pic", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_company__about_us_intro", "must_have" => false, "is_id" => false),
            
            array("name" => "aroundyou_company__product_count_limit", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_company__benefit_count_limit", "must_have" => false, "is_id" => false),
            
            array("name" => "aroundyou_map_location_id", "must_have" => false, "is_id" => true),
            
            array("name" => "aroundyou_users_id", "must_have" => false, "is_id" => true),
            
            array("name" => "aroundyou_company__activated", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_company__activate_date", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_company__duration", "must_have" => false, "is_id" => false), 
        );
        
        return $column_list;
    }
    
    /*
     * Overlay API
     * Contain relationship between data name, related model and column
     *  1. table        - table that require to refer
     *  2. editable     - Should insert data if not found or not
     *  3. id_column      - Column name for current table
     *  4. data_column  - data and reference column in the model
     * 
     * @return Array List of model and data relationship
     */
    public function model_id_list()
    {
        $model_id_list = array (
            array(
                "table" => "aroundyou_company_type", 
                "editable" => true,
                "id_column" => "aroundyou_company_type_id",
                "data_column" => array(
                    array("data" => "aroundyou_company_type__main_category", "column" => "aroundyou_company_type__main_category"),
                    array("data" => "aroundyou_company_type__sub_category", "column" => "aroundyou_company_type__sub_category"),
                ),
            ),
            array(
                "table" => "aroundyou_operation_period", 
                "editable" => true,
                "id_column" => "aroundyou_operation_period_id",
                "data_column" => array(
                    array("data" => "aroundyou_operation_period__display", "column" => "aroundyou_operation_period__display"),
                    array("data" => "aroundyou_operation_period__type", "column" => "aroundyou_operation_period__type"),
                    array("data" => "aroundyou_operation_period__one_time", "column" => "aroundyou_operation_period__one_time"),
                ),
            ),
            array(
                "table" => "aroundyou_map_location", 
                "editable" => true,
                "id_column" => "aroundyou_map_location_id",
                "data_column" => array(
                    array("data" => "location__company_property_name", "column" => "property_name"),
                    array("data" => "location__company_street", "column" => "street"),
                    array("data" => "location__company_map", "column" => "map_location"),
                    array("data" => "location__company_post_code", "column" => "post_code"),
                    array("data" => "location__company_area", "column" => "area"),
                    array("data" => "location__company_state", "column" => "state"),
                    array("data" => "location__company_country", "column" => "country"),
                ),
            ),
        );
        
        return $model_id_list;
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
