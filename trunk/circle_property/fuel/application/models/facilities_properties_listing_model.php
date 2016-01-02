<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('_utils/cb_base_module_model.php');

class facilities_properties_listing_model extends cb_base_module_model {
    // ------------ Setup Function ---------------------------------------------
    public $model_name = "facilities_properties_listing";
    public $model_code = "MFPL";
    
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
            array("name" => "facilities_id", "must_have" => true, "is_id" => false),
            array("name" => "property_id", "must_have" => true, "is_id" => false),
            
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
                "table" => "facilities", 
                "editable" => false,
                "id_column" => "facilities_id",
                "data_column" => array(
                    array("data" => "facility_name", "column" => "name"),
                ),
            ),
        );
        
        return $model_id_list;
    }
    
    //--------------------- Generic Function -----------------------------------
    // Empty for now
    
    // ------------ model setup ------------------------------------------------
    // Following section is use to control the fuelcms dashboard and impact usual behaviorual
    
    
    // -- Special handler --
    // To map the id with corresponding table, since all model is place in this file
    //  therefore, calling it own file "facilities_properties_listing_model"
    public $foreign_keys  = array(
        'property_id' => 'properties_listing_model',
        'facilities_id' => 'facilities_model',
        );
    
    /*
     * This API will impact the result dump when other perform query through this model
     */
    function _common_query()
    {
        // join necessary table for display purpose
        $this->db->join("facilities","facilities.id = facilities_properties_listing.facilities_id");
        
        // Change query statement
        $this->db->select('facilities.name', FALSE);
    }
    
}

class facilities_properties_listing_model_record_model extends Base_module_record
{

}

?>
