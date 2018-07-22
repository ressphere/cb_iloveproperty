<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('_utils/cb_base_module_model.php');

class aroundyou_company_ref_model extends cb_base_module_model {
    // ------------ Setup Function ---------------------------------------------
    public $model_name = "aroundyou_company_ref";
    public $model_code = "MAyou_CR";
    
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
            array("name" => "prefix", "must_have" => true, "is_id" => false), 
            array("name" => "description", "must_have" => true, "is_id" => false), 
            array("name" => "number", "must_have" => true, "is_id" => false), 
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
    
    // ------------ model setup ------------------------------------------------
    // Following section is use to control the fuelcms dashboard
    
    /*
     * Further input restrict
     *      -- Currently don't have -- 
     */
    public function form_fields($values = array(), $related = array())
    {
        $fields = parent::form_fields($values, $related);
        return $fields;
    }
    
}

class aroundyou_company_ref_record_model extends Base_module_record
{
}

?>
