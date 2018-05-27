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
            
            // Company user related
            //"create_modi_company_user" => TRUE,
            //"get_full_company_user_data" => TRUE,
            
            // Company info related
            //"create_modi_company_info" => TRUE,
            //"get_full_company_info_data" => TRUE,
            
            // Search related
            
            // Fast track
            //"fast_clean_data" => TRUE,
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
            "users_id" => TRUE,
            "aroundyou_users_id" => TRUE,
            "aroundyou_company_id" => TRUE,
            "aroundyou_users__activated" => TRUE,
            //"aroundyou_users__modified" => TRUE,
            //"aroundyou_company__modified" => TRUE,
            
            // admin changable info
            "aroundyou_users__banned" => TRUE,
            "aroundyou_users__ban_reason" => TRUE,
            "aroundyou_users__company_count_limit" => TRUE,
            "aroundyou_company__product_count_limit" => TRUE,
            "aroundyou_company__benefit_count_limit" => TRUE,
            "aroundyou_company__activated" => TRUE,
            "aroundyou_company__activate_date" => TRUE,
            "aroundyou_company__duration" => TRUE,
            
            // Company information
            "aroundyou_company__logo" => TRUE,
            "aroundyou_company__phone" => TRUE,
            "aroundyou_company__fax" => TRUE,
            "aroundyou_company__email" => TRUE,
            "aroundyou_company__about_us_intro" => TRUE,
            "aroundyou_company__detail_head_pic" => TRUE,
            
            // Operation period
            "aroundyou_operation_period__display" => TRUE,
            "aroundyou_operation_period__type" => TRUE,
            "aroundyou_operation_period__one_time" => TRUE,
            "aroundyou_company__operation_time_start" => TRUE,
            "aroundyou_company__operation_time_end"  => TRUE,
            "aroundyou_company__operation_auto" => TRUE,
            "aroundyou_company__operation_manual_date_start" => TRUE,
            
            // Company type
            "aroundyou_company_type__main_category"  => TRUE,
            "aroundyou_company_type__sub_category"  => TRUE,
            
            // Company product and benefit
            "info__company_product_list" => TRUE,
            "info__company_benefit_list" => TRUE,
            
            // Location
            "location__company_country"  => TRUE,
            "location__company_state"  => TRUE,
            "location__company_area"  => TRUE,
            "location__company_post_code"  => TRUE,
            "location__company_map"  => TRUE,
            "location__company_street"  => TRUE,
            "location__company_property_name"  => TRUE
            
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
            // Common info
            "common__user_id" => "users_id",
            "common__company_user_id" => "aroundyou_users_id",
            "common__company_id" => "aroundyou_company_id",
            "common__company_user_activated" => "aroundyou_users__activated",
            "common__users_modification" => "aroundyou_users__modified",
            "common__company_modification" => "aroundyou_company__modified",
            
            // admin changable info
            "admin_user__banned" => "aroundyou_users__banned",
            "admin_user__ban_reason" => "aroundyou_users__ban_reason",
            "admin_user__company_count_limit" => "aroundyou_users__company_count_limit",
            "admin_company__product_count_limit" => "aroundyou_company__product_count_limit",
            "admin_company__benefit_count_limit" => "aroundyou_company__benefit_count_limit",
            "admin_company__activated" => "aroundyou_company__activated",
            "admin_company__activated_date" => "aroundyou_company__activate_date",
            "admin_company__activated_duration" => "aroundyou_company__duration",
            
            // Company information
            "info__company_logo" => "aroundyou_company__logo",
            "info__company_phone" => "aroundyou_company__phone",
            "info__company_fax" => "aroundyou_company__fax",
            "info__company_email" => "aroundyou_company__email",
            "info__company_about_us" => "aroundyou_company__about_us_intro",
            "info__company_head_pic" => "aroundyou_company__detail_head_pic",
            
            // Operation period
            "operation__period_display" => "aroundyou_operation_period__display",
            "operation__period_type" => "aroundyou_operation_period__type",
            "operation__period_one_time" => "aroundyou_operation_period__one_time",
            "operation__time_start" => "aroundyou_company__operation_time_start",
            "operation__time_end"  => "aroundyou_company__operation_time_end",
            "operation__auto" => "aroundyou_company__operation_auto",
            "operation__manual_date_start" => "aroundyou_company__operation_manual_date_start",
            
            // Company type
            "company_type__main"  => "aroundyou_company_type__main_category",
            "company_type__sub"  => "aroundyou_company_type__sub_category",
            
            // Company product and benefit
            //"info__company_product_list" => TRUE,
            //"info__company_benefit_list" => TRUE,
            
            // Location
            //"location__company_country"  => "country",
            //"location__company_state"  => "state",
            //"location__company_area"  => "area",
            //"location__company_post_code"  => "post_code",
            //"location__company_map"  => "map_location",
            //"location__company_street"  => "street",
            //"location__company_property_name"  => "property_name"
            
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
     * To create user for company user
     */
    public function create_modi_company_user($input_data_array)
    {
        // Filter away the unwanted key
        $user_info = $this->data_key_init($input_data_array, true);

        // Build libraries info array data
        $library_data = array(
            'library' => $this->library_name,
            'function' => "aroundyou_lib__company_user_add_edit",
            'data' => json_encode($user_info)
        );
        
        // Call libraries to create user
        $insert_return = $this->invoke_library_function($library_data);
        if($this->is_error){return 0;} // function invoke_library_function will help to handle if error 
        
        // Result handle
        $return_info = array(
            "common__company_user_id" => $insert_return['data']['aroundyou_users_id']
        );
        
        $this->set_data("Info: Complete CB_AroundYou:create_user Service",$return_info);
        
        // file dump -- for testing purpose -- Start --
        /*
        $current = "\n------------------------------\n";
        $current .= "CB_AroundYou  -- create_modi_company_user\n";
        $current .= "data type is : ".gettype($input_data_array)."\n";
        $current .= "initial data is : ".json_encode($input_data_array)."\n";
        $current .= "filter data is : ".json_encode($user_info);
        error_log($current, 3, "D:/webdev/resphere_test_dump.txt");   
        // file dump -- for testing purpose -- End --*/
        
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
            'library' => $this->library_name,
            'function' => "aroundyou_lib__get_company_user_data",
            'data' => json_encode($user_info)
        );
        
        // Call libraries to create user
        $insert_return = $this->invoke_library_function($library_data);
        if($this->is_error){return 0;} // function invoke_library_function will help to handle if error 
        
        // Result handle
        $return_info = $insert_return["data"];
        $return_info_changed = $this->CBWS_Service_Base__data_value_convertor($return_info, false);
        
        $this->set_data("Info: Complete CB_AroundYou:get_full_company_user_data Service",$return_info_changed);
        
    }
    
    /*
     * To create user for company info
     */
    public function create_modi_company_info($input_data_array)
    {
        // Filter away the unwanted key
        $user_info = $this->data_key_init($input_data_array, true);
        
        // @todo - add support to invoke libraries when support complete
        
        /*
        // Build libraries info array data
        $library_data = array(
            'library' => $this->library_name,
            'function' => "aroundyou_lib__company_user_add_edit",
            'data' => json_encode($user_info)
        );
        
        // Call libraries to create user
        $insert_return = $this->invoke_library_function($library_data);
        if($this->is_error){return 0;} // function invoke_library_function will help to handle if error 
        
        // Result handle
        $return_info = array(
            "common__company_user_id" => $insert_return['data']['aroundyou_users_id']
        );
        
        $this->set_data("Info: Complete CB_AroundYou:create_user Service",$return_info);
        
        // file dump -- for testing purpose -- Start --
        /*
        $current = "\n------------------------------\n";
        $current .= "CB_AroundYou  -- create_modi_company_user\n";
        $current .= "data type is : ".gettype($input_data_array)."\n";
        $current .= "initial data is : ".json_encode($input_data_array)."\n";
        $current .= "filter data is : ".json_encode($user_info);
        error_log($current, 3, "D:/webdev/resphere_test_dump.txt");   
        // file dump -- for testing purpose -- End --*/
        
    }
    
    /*
     * To obtain all user data related to company
     */
    public function get_full_company_info_data($input_data_array)
    {
        /*
        // Filter away the unwanted key
        $user_info = $this->data_key_init($input_data_array, true);
        
        // Build libraries info array data
        $library_data = array(
            'library' => $this->library_name,
            'function' => "aroundyou_lib__get_company_user_data",
            'data' => json_encode($user_info)
        );
        
        // Call libraries to create user
        $insert_return = $this->invoke_library_function($library_data);
        if($this->is_error){return 0;} // function invoke_library_function will help to handle if error 
        
        // Result handle
        $return_info = $insert_return["data"];
        $return_info_changed = $this->CBWS_Service_Base__data_value_convertor($return_info, false);
        
        $this->set_data("Info: Complete CB_AroundYou:get_full_company_user_data Service",$return_info_changed);
        */
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
            'library' => $this->library_name,
            'function' => "company_user_add_edit",
            'data' => json_encode($user_info)
        );
        
        
        // *** Remove link data on aroundyou_link_company_benefit
        
        // *** Remove product data on aroundyou_product
        
        // *** Remove company info on aroundyou_company
        
        // *** Remove company user on aroundyou_users
        
        
        $library_data = array(
            'library' => $this->library_name,
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
