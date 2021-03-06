<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('_utils/cb_base_module_model.php');

class aroundyou_product_model extends cb_base_module_model {
    // ------------ Setup Function ---------------------------------------------
    public $model_name = "aroundyou_product";
    public $model_code = "MAYou_P";
    
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
            array("name" => "aroundyou_product__benefit_tag", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_product__img", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_product__title", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_product__info", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_product__price", "must_have" => false, "is_id" => false),
            array("name" => "aroundyou_product__currency_code", "must_have" => false, "is_id" => false),
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
        "aroundyou_company_id" => "aroundyou_company_model"
        );
    
    
}

class aroundyou_product_record_model extends Base_module_record
{
}

?>
