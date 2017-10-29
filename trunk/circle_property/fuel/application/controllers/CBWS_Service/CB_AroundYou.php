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
    private $company_library_name = "aroundyou_lib";
    
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
            
            // Company user related
            "create_company_user" => TRUE,
            "get_full_company_user_data" => TRUE,
            
            // Company info related
            
            // Fast track
            "fast_clean_data" => TRUE,
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
            // Comapny Product
            // Company benefit
            
            // Common info
            "common__user_id" => TRUE,
            "common__company_user_id" => TRUE,
            "common__company_id" => TRUE,
            
            // Company information
            "info__logo" => TRUE,
            "info__phone" => TRUE,
            "info__fax" => TRUE,
            "info__email" => TRUE,
            "info__about_us" => TRUE,
            "info__head_pic" => TRUE,
            
            // Operation period
            "operation__period" => TRUE,
            "operation__time_start" => TRUE,
            "operation__time_end"  => TRUE,
            "operation__auto" => TRUE,
            "operation__manual_date_start" => TRUE,
            
            // Company type
            "company_type__main"  => TRUE,
            "company_type__sub"  => TRUE,
            
            // Location
            "location__country"  => TRUE,
            "location__state"  => TRUE,
            "location__area"  => TRUE,
            "location__post_code"  => TRUE,
            "location__map"  => TRUE,
            "location__street"  => TRUE,
            "location__property_name"  => TRUE,
            
            // admin changable info
            "admin_user__activated" => TRUE,
            "admin_user__banned" => TRUE,
            "admin_user__banned_reason" => TRUE,
            "admin_user__company_count_limit" => TRUE,
            "admin_company__product_count_limit" => TRUE,
            "admin_company__activated" => TRUE,
            "admin_company__activated_date" => TRUE,
            "admin_company__activated_duration" => TRUE
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
    /*
     * To create user for company
     */
    public function create_company_user($input_data_array)
    {
        // Filter away the unwanted key
        $user_info = $this->data_key_init($input_data_array, true);
        
        // Build libraries info array data
        $library_data = array(
            'library' => $this->company_library_name,
            'function' => "aroundyou_lib__company_user_add_edit",
            'data' => json_encode($user_info)
        );
        
        // Call libraries to create user
        $insert_return = $this->invoke_library_function($library_data);
        if($this->is_error){return 0;} // function invoke_library_function will help to handle if error 
        
        // Result handle
        $return_info = array(
            "common__company_user_id" => $insert_return['data']['common__company_user_id']
        );
        
        $this->set_data("Info: Complete CB_AroundYou:create_user Service",$return_info);
        
    }
    
    /*
     * To obtain all user data related to company
     */
    public function get_full_company_user_data($input_data_array)
    {
        // Filter away the unwanted key
        $user_info = $this->data_key_init($input_data_array, true);
        
        // Build libraries info array data
        $library_data = array(
            'library' => $this->company_library_name,
            'function' => "aroundyou_lib__get_company_user_data",
            'data' => json_encode($user_info)
        );
        
        // Call libraries to create user
        $insert_return = $this->invoke_library_function($library_data);
        if($this->is_error){return 0;} // function invoke_library_function will help to handle if error 
        
        // Result handle
        $return_info = $insert_return["data"];
        
        $this->set_data("Info: Complete CB_AroundYou:get_full_company_user_data Service",$return_info);
        
    }
    
    /*
     * To clear off ALL company data which related to spcified id
     */
    public function fast_clean_data($input_data_array)
    {
        // @todo - push this to later as most of libraries not there and not tested
        /*
        // Filter away the unwanted key
        $user_info = $this->data_key_init($input_data_array, true);
        
        // Get company user id and company id
        $library_data = array(
            'library' => $this->company_library_name,
            'function' => "company_user_add_edit",
            'data' => json_encode($user_info)
        );
        
        
        // *** Remove link data on aroundyou_link_company_benefit
        
        // *** Remove product data on aroundyou_product
        
        // *** Remove company info on aroundyou_company
        
        // *** Remove company user on aroundyou_users
        
        
        $library_data = array(
            'library' => $this->company_library_name,
            'function' => "company_user_add_edit",
            'data' => json_encode($user_info)
        );
        
        // Call libraries to create user
        $insert_return = $this->invoke_library_function($library_data);
        if($this->is_error){return 0;} // function invoke_library_function will help to handle if error 
        
        // Result handle
        $return_info = array(
            "common__company_user_id" => $insert_return['data']['common__company_user_id']
        );
        
        $this->set_data("Info: Complete CB_AroundYou:create_user Service",$return_info);
        
        */
    }
    
    //--------------------- Internal Function ----------------------
    
}

?>
