<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('_utils/cb_base_module_model.php');

class property_photo_model extends cb_base_module_model {
    // ------------ Setup Function ---------------------------------------------
    public $model_name = "property_photo";
    public $model_code = "MPP";
    
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
            
            array("name" => "path", "must_have" => true, "is_id" => false),
            array("name" => "description", "must_have" => false, "is_id" => false), // Default current timestamp (format 2015-02-07 07:06:35)

            // Storing id
            array("name" => "property_id", "must_have" => true, "is_id" => true),
            
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
            // Property id should be pass in, to reduce unneccessary search
        );
        
        return $model_id_list;
    }
    
    //--------------------- Generic Function -----------------------------------
    // Empty for now
    
    
    // ------------ model setup ------------------------------------------------
    // Following section is use to control the fuelcms dashboard and impact usual behaviorual
    
    // -- Special handler --
    // To map the id with corresponding table, since all model is place in this file
    //  therefore, calling it own file "property_photo_model"
    public $foreign_keys  = array(
        'property_id' => 'properties_listing_model',
        );

    
}

class property_photo_record_model extends Base_module_record
{
}

?>
