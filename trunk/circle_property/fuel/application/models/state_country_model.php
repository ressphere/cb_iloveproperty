<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('_utils/cb_base_module_model.php');

class state_country_model extends cb_base_module_model {
    // ------------ Setup Function ---------------------------------------------
    public $model_name = "state_country";
    public $model_code = "MSC";
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
            // Storing id
            array("name" => "state_id", "must_have" => true, "is_id" => true),
            array("name" => "country_id", "must_have" => true, "is_id" => true),
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
                "table" => "state", 
                "editable" => false,
                "id_column" => "state_id",
                "data_column" => array(
                    array("data" => "state", "column" => "name"),
                ),
            ),
            array(
                "table" => "country", 
                "editable" => false,
                "id_column" => "country_id",
                "data_column" => array(
                    array("data" => "country", "column" => "name"),
                ),
            ),
        );
        
        return $model_id_list;
    }
    
    // -- Special handler --
    // To map the id with corresponding table, since all model is place in this file
    //  therefore, calling it own file "state_country"
    public $foreign_keys  = array(
        'state_id' => 'state_model',
        'country_id' => 'country_model',
        );
    
    //--------------------- Generic Function -----------------------------------
    // Empty for now
    
}

class state_country_record_model extends Base_module_record
{
}

?>
