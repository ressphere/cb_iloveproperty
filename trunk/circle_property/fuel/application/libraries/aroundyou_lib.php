<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
define("DEACTIVATION_DURATION", 1);
require_once('_utils/cb_base_libraries.php');

/**
 * This libraries handle all data manipulation for porperties listing part
 *
 */
class aroundyou_lib extends cb_base_libraries
{
    // ------------ Setup Function ---------------------------------------------
    public $library_name = "aroundyou_lib";
    public $library_code = "LAYou";
    
    
    /*
     * Constructor 
     */
    function __construct()
    {
        // Invoke parent constructor
       parent::__construct();
       date_default_timezone_set("Asia/Kuala_Lumpur");
    }
    
    /*
     * This provide the convert data set to base
     */
    private function property_data_convert()
    {
        $convert_data = array(
        );
        
        return $convert_data;
    }
    
    //--------------------- Generic Function -----------------------------------
    
    // @todo - add, remove, edit company information
    // @todo - get info
    
    
    // ------------ Private Function -------------------------------------------
    
}