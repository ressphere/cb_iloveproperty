<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('_utils/cb_base_module_model.php');

class country_model extends cb_base_module_model {
    // ------------ Setup Function ---------------------------------------------
    public $model_name = "country";
    public $model_code = "MC";
    
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
            array("name" => "name", "must_have" => true, "is_id" => false),
            array("name" => "country_code", "must_have" => false, "is_id" => false),
            array("name" => "longitude", "must_have" => false, "is_id" => false),
            array("name" => "latitude", "must_have" => false, "is_id" => false),
            array("name" => "flag_image", "must_have" => false, "is_id" => false),
            array("name" => "currency_code", "must_have" => false, "is_id" => false),
            array("name" => "currency_name", "must_have" => false, "is_id" => false),
            array("name" => "currency_image", "must_have" => false, "is_id" => false),
            
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
        );
        
        return $model_id_list;
    }
    
    //--------------------- Generic Function -----------------------------------
    // Empty for now
    
}

class country_record_model extends Base_module_record
{
}
?>
