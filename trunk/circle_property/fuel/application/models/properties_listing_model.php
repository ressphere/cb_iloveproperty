<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('_utils/cb_base_module_model.php');

class properties_listing_model extends cb_base_module_model {
    // ------------ Setup Function ---------------------------------------------
    public $model_name = "properties_listing";
    public $model_code = "MPL";
    
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
            
            array("name" => "activate", "must_have" => false, "is_id" => false),    // Must handle in libraries, set false due to edit requirement 
            array("name" => "activate_time", "must_have" => false, "is_id" => false), // Must handle in libraries, set false due to edit requirement (format 2015-02-07 07:06:35)
            array("name" => "auction", "must_have" => false, "is_id" => false),
            array("name" => "bathrooms", "must_have" => false, "is_id" => false),
            array("name" => "bedrooms", "must_have" => false, "is_id" => false),
            array("name" => "buildup", "must_have" => false, "is_id" => false),
            array("name" => "create_time", "must_have" => false, "is_id" => false), // Must handle in libraries, set false due to edit requirement (format 2015-02-07 07:06:35)
            array("name" => "edit_time", "must_have" => false, "is_id" => false),  // (format 2015-02-07 07:06:35)
            array("name" => "landarea", "must_have" => false, "is_id" => false),
            array("name" => "monthly_maintanance", "must_have" => false, "is_id" => false),
            array("name" => "occupied", "must_have" => true, "is_id" => false),
            array("name" => "currency", "must_have" => true, "is_id" => false),
	    array("name" => "size_measurement_code", "must_have" => false, "is_id" => false),
            array("name" => "price", "must_have" => true, "is_id" => false),
            array("name" => "ref_tag", "must_have" => false, "is_id" => false),
            array("name" => "remark", "must_have" => false, "is_id" => false),
            array("name" => "car_park", "must_have" => false, "is_id" => false),

            // Storing id
            array("name" => "land_title_type_id", "must_have" => false, "is_id" => true),
            array("name" => "map_location_id", "must_have" => true, "is_id" => true),
            array("name" => "property_name_id", "must_have" => true, "is_id" => true),
            array("name" => "property_type_id", "must_have" => false, "is_id" => true),
            array("name" => "reserve_type_id", "must_have" => false, "is_id" => true),
            array("name" => "furnished_type_id", "must_have" => false, "is_id" => true),
            array("name" => "tenure_id", "must_have" => false, "is_id" => true),
            array("name" => "user_id", "must_have" => true, "is_id" => true),
            
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
                "table" => "land_title_type", 
                "editable" => false,
                "id_column" => "land_title_type_id",
                "data_column" => array(
                    array("data" => "land_title_type", "column" => "land_title_type"),
                ),
            ),
            array(
                "table" => "map_location", 
                "editable" => true,
                "id_column" => "map_location_id",
                "data_column" => array(
                    array("data" => "map_location", "column" => "map_location"),
                    array("data" => "street", "column" => "street"),
                    array("data" => "state", "column" => "state"),
                    array("data" => "area", "column" => "area"),
                    array("data" => "post_code", "column" => "post_code"),
                    array("data" => "country", "column" => "country"),
                ),
            ),
            array(
                "table" => "property_name", 
                "editable" => true,
                "id_column" => "property_name_id",
                "data_column" => array(
                    array("data" => "property_name", "column" => "property_name"),
                ),
            ),
            array(
                "table" => "property_type", 
                "editable" => false,
                "id_column" => "property_type_id",
                "data_column" => array(
                    array("data" => "property_type", "column" => "property_type"),
                    array("data" => "property_category", "column" => "property_category"),
                    array("data" => "service_type", "column" => "service_type"),
                ),
            ),
            array(
                "table" => "reserve_type", 
                "editable" => false,
                "id_column" => "reserve_type_id",
                "data_column" => array(
                    array("data" => "reserve_type", "column" => "reserve_type"),
                ),
            ),
            array(
                "table" => "furnished_type", 
                "editable" => false,
                "id_column" => "furnished_type_id",
                "data_column" => array(
                    array("data" => "furnished_type", "column" => "furnished_type"),
                ),
            ),
            array(
                "table" => "tenure", 
                "editable" => false,
                "id_column" => "tenure_id",
                "data_column" => array(
                    array("data" => "tenure", "column" => "tenure"),
                ),
            ),
        );
        
        return $model_id_list;
    }
    
    /*
     * Overlay API
     * Call back API to perform task before data being save and bsfore ID convert 
     *  & key check, perform following task
     *    1. Reference tag generation
     * 
     * @param Array Listing data to be modified
     * @return Array Listing data after modified
     */
    public function insert_data_callback($dataset)
    {
        // Skip tag generation if already have one
        if (!array_key_exists("ref_tag",$dataset))
        {
            // --- Tag generate --- Start ----
            // Perform tag generation
            $this->load->model('properties_ref_model'); 
            $properties_ref_model = $this->properties_ref_model;
            $ref_model_obj = $properties_ref_model->find_one(array("category" => $dataset["service_type"]));

            if(is_object($ref_model_obj))
            {
                // Prefix data retrieve
                $ref_prefix = $ref_model_obj->prefix;
                $ref_number = $ref_model_obj->number;

                // Update data
                $ref_model_obj->number = $ref_number + 1;
                $ref_tag_id = $ref_model_obj->save();

                // Check the ref tag update
                if ($ref_tag_id !== false)
                {
                    // Combine and get ref
                    $ref_tag = $ref_prefix . $ref_number;
                    $dataset["ref_tag"] = $ref_tag;
                    $this->ref_tag = $ref_tag;
                }
                else
                {
                    $this->set_error(
                            $this->model_code."-IDC-1", 
                            "Internal error, please contact admin", 
                            "Fail to update properties_ref_model at ".$this->model_name);
                }        
            }
            else
            {
                $this->set_error(
                            $this->model_code."-IDC-2", 
                            "Internal error, please contact admin", 
                            "Fail to obtain ref search result object for category is ".json_encode($dataset)." at ".$this->model_name);
            }
            // --- Tag generate --- End ----
            
        }
        else
        {
            $this->ref_tag = $dataset["ref_tag"];
        }
        
        return $dataset;
    }
    
    //--------------------- Generic Function -----------------------------------
    
    
    
    // ------------ model setup ------------------------------------------------
    // Following section is use to control the fuelcms dashboard and impact usual behaviorual
    
    // -- Special handler --
    // To map the id with corresponding table, since all model is place in this file
    //  therefore, calling it own file "properties_listing_model"
    
    public $foreign_keys  = array(
        'map_location_id' => 'map_location_model',
        
        'property_name_id' => 'property_name_model',
        'property_type_id' => 'property_type_model',
        'reserve_type_id' => 'reserve_type_model',
        'furnished_type_id' => 'furnished_type_model',
        'tenure_id' => 'tenure_model',
        'user_id' => 'users_model',
        );
    
    /*
     * This API will impact all the query statement for this model
     */
    function _common_query()
    {
    }
    
}

class properties_listing_record_model extends Base_module_record
{
}

?>
