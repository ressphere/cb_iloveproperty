<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'CBWS_Service_Base.php';

/**
 * Circle Property Service
 *    To handle all service related to property
 * 
 */
class CB_AroundYOu extends CBWS_Service_Base{
    //--------------------- Global Variable ----------------------
    // Library that interact with dedicated database
    public $library_name = "aroundyou_lib";
    
    // Error handler
    public $service_name = "cb_aroundyou";
    public $service_code = "SAYou";
    
    //--------------------- Setup Function ----------------------
    /**
     * Normal Constructor
     * *** Please don't touch this unless is necessary ***
     * 
     * @param Array (optional)Data that contain all product information using key and value
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Contain list of serivce supported with auth
     * Service list content mean
     *     - True = Require AUTH
     *     - FALSE = Not require AUTH
     * 
     * @Return Array list of auth servie
     */
    public function service_list()
    {
        $service_list = array(
            "test_service"  => TRUE,
        );
        return $service_list;
    }
    
    /**
     * Contain all accepted View key 
     *  Using view key is due to view key unlikely to change
     * 
     * @return Array List of the supported data
     */
    public function accepted_key()
    {
        // @todo - enchance to become input must_have check 
        
        // Contain all the accepted key
        // Format:
        //   True = Accepted key
        //   False = Disabled key
        $accept_key = array(     
        );
        
        return $accept_key;
    }
    
    /*
     * Setting function which contain all name change for data key value
     * Array key for view to model or vise versa
     * 
     * @Return Array That contain view and model keys
     */
    public function data_key_v_and_m()
    {
        // This array store all the keys need to be change from view to model
        // Format: 
        //    "view_key_name" => "model_key_name"
        $array_key_change = array(
        );
        
        return $array_key_change;
    }
    
    
    //--------------------- Test Function ----------------------
    /*
     * Test service
     */
    public function test_service($input_data_array)
    {
        $this->set_data("Info: Complete CB_AroundYou:test_service Service",$input_data_array);
        
    }
    
    
    //--------------------- Service Function ----------------------
    // Please refer to library (aroundyou_lib)
    //--------------------- Internal Function ----------------------
    
}

?>
