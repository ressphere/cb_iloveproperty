<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('_utils/cb_base_module_model.php');

class aroundyou_map_location_model extends cb_base_module_model {
    // ------------ Setup Function ---------------------------------------------
    public $model_name = "aroundyou_map_location";
    public $model_code = "MAYou_ML";
    
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
            array("name" => "property_name", "must_have" => false, "is_id" => false),
            array("name" => "street", "must_have" => false, "is_id" => false),
            array("name" => "map_location", "must_have" => false, "is_id" => false),
            array("name" => "location_id", "must_have" => false, "is_id" => true),
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
                "table" => "location", 
                "editable" => true,
                "id_column" => "location_id",
                "data_column" => array(
                    array("data" => "state", "column" => "state"),
                    array("data" => "area", "column" => "area"),
                    array("data" => "post_code", "column" => "post_code"),
                    array("data" => "country", "column" => "country"),
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
        'location_id' => 'location_model',
        );
    
    
}

class aroundyou_map_location_record_model extends Base_module_record
{
}

?>
