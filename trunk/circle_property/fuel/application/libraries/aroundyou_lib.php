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
    private function aroundyou_lib__company_data_convert()
    {
        $convert_data = array(
        );
        
        return $convert_data;
    }
    
    //--------------------- Generic Function -----------------------------------
    
    /*
     * To create company user information
     */
    function aroundyou_lib__company_user_add_edit ($input_data_json)
    {
        // Change input data to model support data, overwrite
        $input_data_raw = json_decode($input_data_json, TRUE);
        $input_data_array = $this->data_value_convertor($input_data_raw, $this->aroundyou_lib__company_data_convert(), TRUE); 
        
        // Extract input information
        $user_id = $this->array_value_extract($input_data_array, "users_id", TRUE);
        $company_user_id = $this->array_value_extract($input_data_array, "aroundyou_users_id", TRUE);
        
        if($user_id == NULL && $company_user_id == NULL)
        {
            $this->set_error( "LAYou-CUAE-1",
                    "Fail to process data, please contact admin",
                    "Missing common__user_id and common__company_user_id, must have one of those ".json_encode($input_data_json)
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
        
        $this->set_data("Complete company user creation", $return_data);
        
        /*// file dump -- for testing purpose -- Start --
        $current = "\n------------------------------\n";
        $current .= "aroundyou_lib  -- create_company_user -- ori input\n";
        $current .= json_encode($input_data)."\n";
        error_log($current, 3, "D:/webdev/resphere_output_dump.txt");
        // file dump -- for testing purpose -- End --*/
        
    }
    
    /*
     * This is use to retrieve all user data for company
     */
    public function aroundyou_lib__get_company_user_data ($input_data_json)
    {
        // Change input data to model support data, overwrite
        $input_data_raw = json_decode($input_data_json, TRUE);
        $input_data_array = $this->data_value_convertor($input_data_raw, $this->aroundyou_lib__company_data_convert(), TRUE); 
        
        // Extract input information
        $company_user_id = $this->array_value_extract($input_data_array, "aroundyou_users_id");
        if($this->is_error){return 0;}  // User id is a must
        
        // Load aroundyou user model and insert data
        $this->CI->load->model('aroundyou_users_model');
        $aroundyou_users_model = new $this->CI->aroundyou_users_model;
        $aroundyou_users_model->query_detail_data_setup();
        $company_user_return_array = $aroundyou_users_model->find_one(array("id" => $company_user_id),"","array");
        
        $this->set_data("Complete company user info retrieved", $company_user_return_array);
    }
    
    
    // ------------ Private Function -------------------------------------------
    
}