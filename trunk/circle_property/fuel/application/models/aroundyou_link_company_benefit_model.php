<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('_utils/cb_base_module_model.php');

class aroundyou_link_company_benefit_model extends cb_base_module_model {
    // ------------ Setup Function ---------------------------------------------
    public $model_name = "aroundyou_link_company_benefit";
    public $model_code = "MAYou_LCB";
    
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
            array("name" => "aroundyou_company_id", "must_have" => false, "is_id" => true),
            array("name" => "aroundyou_benefit_id", "must_have" => false, "is_id" => true),
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
        'aroundyou_company_id' => 'aroundyou_company_model',
        'aroundyou_benefit_id' => 'aroundyou_benefit_model',
        );
    
    
}

class aroundyou_link_company_benefit_record_model extends Base_module_record
{
}

?>
