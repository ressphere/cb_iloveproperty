<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
define("DEACTIVATION_DURATION", 1);
require_once('_utils/cb_base_libraries.php');

/**
 * This libraries handle all data manipulation for aroundyou <-- Heavy work
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
     * Contain list of serivce supported with auth
     * Service list content mean
     *     - True = Require AUTH
     *     - FALSE = Not require AUTH
     * 
     * @Return Array list of auth servie
     */
    public function library_service_list()
    {
        $service_list = array(
            //"test_service"  => TRUE,
            
            // Company user related
            "aroundyou_lib__company_user_add_edit" => TRUE,
            
            
            // Company info related
            "aroundyou_lib__get_company_user_data" => TRUE,
            "aroundyou_lib__company_info_add_edit" => TRUE,
            "aroundyou_lib__create_modi_company_info" => TRUE,
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
    public function library_accepted_key()
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
    public function library_data_key_v_and_m()
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
    
    //--------------------- Generic Function -----------------------------------
    
    /*
     * To create or modified the company user information
     * @access public
     * 
     * @param String Json input that contain information that require to store/modified
     *  Input field (all string input unless specified):
     *      users_id
     *      aroundyou_users_id - int
     *      aroundyou_users__activated - 0/1
     *      aroundyou_users__banned
     *      aroundyou_users__ban_reason
     *      aroundyou_users__company_count_limit - int
     * 
     * @return String Company user id, aroundyou_users_id
     */
    function aroundyou_lib__company_user_add_edit ($input_data_json)
    {
        // Change input data to model support data, overwrite
        //$input_data_raw = json_decode($input_data_json, TRUE);
        //$input_data_array = $this->data_value_convertor($input_data_raw, $this->aroundyou_lib__company_data_convert(), TRUE); 
        $input_data_array = $this->library_data_key_init($input_data_json, TRUE); 
        
        // Extract input information
        $user_id = $this->array_value_extract($input_data_array, "users_id", TRUE);
        $company_user_id = $this->array_value_extract($input_data_array, "aroundyou_users_id", TRUE);
        
        if($user_id == NULL && $company_user_id == NULL)
        {
            $this->set_error( "LAYou-CUAE-1",
                    "Fail to process data, please contact admin",
                    "Missing users_id and aroundyou_users_id, must have one of those ".json_encode($input_data_json)
                    );
        }
        
        if($this->is_error){return 0;}  // User id is a must
        
        // Preload aroundyou user model as extraction might need it also
        $this->CI->load->model('aroundyou_users_model');
        
        // Prepare information
        $company_user_search_condition = array();
        if ($company_user_id !== NULL)
        {
            // Specified is edit not add new by condition
            $company_user_search_condition["id"] = $company_user_id;
                    
            // Retrieved base data before modified
            $retrieved_aroundyou_users_model = new $this->CI->aroundyou_users_model;
            $retrieved_aroundyou_users_model->query_detail_data_setup();
            $company_user_info = $retrieved_aroundyou_users_model->find_one(array("id" => $company_user_id),"","array");

            // Replace value if modified
            if (array_key_exists("aroundyou_users__activated"   , $input_data_array)) { $company_user_info["aroundyou_users__activated"]             = $input_data_array["aroundyou_users__activated"]; }
            if (array_key_exists("aroundyou_users__banned"               , $input_data_array)) { $company_user_info["aroundyou_users__banned"]                = $input_data_array["aroundyou_users__banned"]; }
            if (array_key_exists("aroundyou_users__ban_reason"        , $input_data_array)) { $company_user_info["aroundyou_users__ban_reason"]         = $input_data_array["aroundyou_users__ban_reason"]; }
            if (array_key_exists("aroundyou_users__company_count_limit"  , $input_data_array)) { $company_user_info["aroundyou_users__company_count_limit"]   = $input_data_array["aroundyou_users__company_count_limit"]; }
            if (array_key_exists("users_id"                  , $input_data_array)) { $company_user_info["users_id"]                               = $user_id; }
            
            // Update modified data time
            $company_user_info["aroundyou_users__modified"] = date('Y-m-d H:i:s', time());
        }
        else
        {
            // Prepare preset value
            $company_user_info["aroundyou_users__activated"] = 1;
            $company_user_info["aroundyou_users__company_count_limit"] = 1;
            $company_user_info["users_id"] = $user_id;
            $company_user_info["aroundyou_users__modified"] = date('Y-m-d H:i:s', time());
        }
        
        // Process the insert database part
        $aroundyou_users_model = new $this->CI->aroundyou_users_model;
        $aroundyou_users_model->insert_data(json_encode($company_user_info),$company_user_search_condition);
        $this->validate_return_data($aroundyou_users_model);
        if($this->is_error){return 0;}
        
        
        // Data retrieved and obtain id
        $aroundyou_users_model_return = $aroundyou_users_model->get_return_data_set();
        $return_company_user_id = $aroundyou_users_model_return["data"]["id"];
        
        // Handle output data
        $return_data["aroundyou_users_id"] = $return_company_user_id;
        
        $return_data = $this->library_data_m_v_convert($return_data,$this->library_data_key_v_and_m(),FALSE);
        $this->set_data("Complete company user creation", $return_data);
        
        /*// file dump -- for testing purpose -- Start --
        $current = "\n------------------------------\n";
        $current .= "aroundyou_lib  -- create_company_user -- ori input\n";
        $current .= json_encode($input_data)."\n";
        error_log($current, 3, "D:/webdev/resphere_output_dump.txt");
        // file dump -- for testing purpose -- End --*/
        
    }
    
    /*
     * This is use to retrieve all user data for company base on company user id
     *  All data will be recorded and then retrieved through API get_return_data_set() 
     * 
     * @param String Json input that contain information that require to store/modified
     *  Input field (all string input unless specified):
     *      aroundyou_users_id - int
     * 
     */
    public function aroundyou_lib__get_company_user_data ($input_data_json)
    {
        // Change input data to model support data, overwrite
        //$input_data_raw = json_decode($input_data_json, TRUE);
        //$input_data_array = $this->data_value_convertor($input_data_raw, $this->aroundyou_lib__company_data_convert(), TRUE); 
        $input_data_array = $this->library_data_key_init($input_data_json, TRUE); 
        
        // Extract input information
        $company_user_id = $this->array_value_extract($input_data_array, "aroundyou_users_id");
        if($this->is_error){return 0;}  // User id is a must
        
        // Load aroundyou user model and insert data
        $this->CI->load->model('aroundyou_users_model');
        $aroundyou_users_model = new $this->CI->aroundyou_users_model;
        $aroundyou_users_model->query_detail_data_setup();
        $company_user_return_array = $aroundyou_users_model->find_one(array("id" => $company_user_id),"","array");
        
        $company_user_return_array = $this->library_data_m_v_convert($company_user_return_array,$this->library_data_key_v_and_m(),FALSE);
        $this->set_data("Complete company user info retrieved", $company_user_return_array);
    }
    
    /*
     * To create or modified the company information
     * @access public
     * 
     * @param String Json input that contain information that require to store/modified
     *  Input field (all string input unless specified):
     *      aroundyou_users_id - int
     *      aroundyou_company_id - int
     *      aroundyou_company__product_count_limit - int
     *      aroundyou_company__benefit_count_limit - int
     *      aroundyou_company__activated - 0/1
     *      aroundyou_company__duration - int
     *      aroundyou_company__logo
     *      aroundyou_company__phone
     *      aroundyou_company__fax
     *      aroundyou_company__email
     *      aroundyou_company__about_us_intro
     *      aroundyou_company__detail_head_pic
     *      aroundyou_operation_period__type
     *      aroundyou_operation_period__one_time - 0/1
     *      aroundyou_company__operation_time_start
     *      aroundyou_company__operation_time_end
     *      aroundyou_company__operation_auto - 0/1
     *      aroundyou_company__operation_manual_date_start
     *      aroundyou_company_type__main_category
     *      aroundyou_company_type__sub_category
     *      info__company_product_list - array(array(image,title,info,price,currency_code))
     *      info__company_benefit_list - array(array(image,title,info,start_date,end_date,type))
     *      location__company_country
     *      location__company_state
     *      location__company_area
     *      location__company_post_code
     *      location__company_map
     *      location__company_street
     *      location__company_property_name
     * 
     * @return String Company information id, aroundyou_company_id
     */
    function aroundyou_lib__create_modi_company_info ($input_data_json)
    {
        // Change input data to model support data, overwrite
        //$input_data_raw = json_decode($input_data_json, TRUE);
        //$input_data_array = $this->data_value_convertor($input_data_raw, $this->aroundyou_lib__company_data_convert(), TRUE); 
        $input_data_array = $this->library_data_key_init($input_data_json, TRUE); 
        
        // ---- Initial data ---------------------------------------------------
        // Check to determine is new or modified data
        $aroundyou_company_id = $this->array_value_extract($input_data_array, "aroundyou_company_id", true);
        $search_condition = array(); // Init it so that later won't screw
        if($aroundyou_company_id !== NULL)
        {
            $search_condition["aroundyou_company_id"] =$aroundyou_company_id;
        }
        
        // Provide current malaysia time for activate_time, edit_time and create_time
        $current_time = time();
        if($aroundyou_company_id === NULL)
        {
            // Inject the default creation set of date time data
            $input_data_array["aroundyou_company__activate_date"] = date('Y-m-d H:i:s', $current_time);
            $input_data_array["aroundyou_company__duration"] = DEACTIVATION_DURATION; 
            $input_data_array["aroundyou_company__activated"] = '1'; // Default to activate when insert
            $input_data_array["aroundyou_company__modified"] = date('Y-m-d H:i:s', $current_time);
        }
        else
        {
            $input_data_array["aroundyou_company__modified"] = date('Y-m-d H:i:s', $current_time);
        }
        
        // Workaround for location__company_map as it should be string 
        if(array_key_exists("location__company_map", $input_data_array))
        {
            // Special handle for map location or google ip
            $input_data_array["location__company_map"] = json_encode($input_data_array["location__company_map"]);
        }
        
        // ---- Injection of data ----------------------------------------------
        $this->CI->load->model('aroundyou_company_model'); 
        $aroundyou_company_model = new $this->CI->aroundyou_company_model;
        

        $aroundyou_company_model->insert_data(json_encode($input_data_array),$search_condition);
        
        // validate data and set current error
        $this->validate_return_data($aroundyou_company_model);
        
        /*// file dump -- for testing purpose -- Start --
        $current = "\n------------------------------\n";
        $current .= "aroundyou_lib__create_modi_company_info -- first model incjection -- aroundyou_company_model\n";
        $current .= json_encode($input_data_array)."\n";
        $current .= json_encode($search_condition);
        error_log($current, 3, "D:/webdev/resphere_output_dump.txt");
        // file dump -- for testing purpose -- End --*/
        
        if($this->is_error) {return 0;}
        
        // Data retrieved
        $company_data_return = $aroundyou_company_model->get_return_data_set();

        // Obtain listing ID
        $company_data_id = $company_data_return["data"]["id"];
        
        // ---- Handle company logo ----------------------------------------------
        //@todo - need to includde photo handler - aroundyou_company__logo and aroundyou_company__detail_head_pic
        
        // Exit with corressponding value
        $data_return["company_data_id"]= $company_data_id;
        $this->set_data("Complete insert data", $data_return);
        
        // file dump -- for testing purpose -- Start --
        $current = "\n------------------------------\n";
        $current .= "aroundyou_lib__create_modi_company_info -- ori input\n";
        $current .= json_encode($input_data_array)."\n";
        error_log($current, 3, "D:/webdev/resphere_output_dump.txt");
        // file dump -- for testing purpose -- End --*/
        
    }
    
    // ------------ Private Function -------------------------------------------
    
}