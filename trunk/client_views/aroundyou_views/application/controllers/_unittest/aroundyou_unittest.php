<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(dirname(__FILE__)) . '/_utils/aroundyou_utils__DataServer.php';

// To trigger unit test
//      http://localhost/cb_iloveproperty/trunk/client_views/aroundyou_views/index.php/_unittest/aroundyou_unittest/test_list

class aroundyou_unittest extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->library('unit_test');
        
        
    }
    
    // General variable
    private $test_id = 1;
    private $test_is_pass = 1;
    
    ###########################unit test region####################################
   
   /*
    * To test basic gateway
    */
   private function _unittest__service()
   {
        // AUTH Service hit check
        $aroundyou_service_obj = new aroundyou_utils__DataServer__Service();
        $return_info = $aroundyou_service_obj->Test_Gateway();
        //var_dump($return_info);
        $golden_val = json_encode(array(
                         "service" => "CB_AroundYou:test_service",
                         "status" => "Complete",
                         "status_information" => "Info: Complete CB_AroundYou:test_service Service",
                         "data" => "Test AroundYou gateway !!"
                         )
                     );
                     
        $note = "Return:<br>".$return_info."<br>";
        $note = $note."Golden:<br>".$golden_val;
        $this->unit->run($golden_val, $return_info, "Test CB_AroundYou basic gateway", $note); 
        $this->test_is_pass = ($golden_val === $return_info) ? 1 : 0;
   }
   
   /*
    * To test on complete flow 
    *   submit -> query -> edit -> query -> deleted
    */
   private function _unittest__complete_flow()
   {
        //************************************************
        // **** To test on company user creation ****
        $company_user_service_obj = new aroundyou_utils__DataServer__Service();
        
        $user_id_data = array(
            "common__user_id" => $this->test_id
        );
        
        $company_user_id_return = $company_user_service_obj->SendReceive_Service_Request(
                    "CB_AroundYou:create_modi_company_user", 
                    $user_id_data
                );
        $company_user_id_array = json_decode($company_user_id_return, TRUE);
        $company_user_id_result = 
                ($company_user_id_array["status"] == "Complete" && array_key_exists("common__company_user_id",$company_user_id_array["data"]))? "Pass" : "Fail";
        $note = "Return:<br>".$company_user_id_return."<br>";
        $this->unit->run("Pass", $company_user_id_result, "Test CB_AroundYou Company User Creation", $note);  
        $this->test_is_pass = ($company_user_id_result === "Pass") ? 1 : 0;
        
        //************************************************
        // Exit unit test if fail to create company
        if ($company_user_id_result == "Fail"){ return 0; }
        
        //************************************************
        // data extraction for later use
        $company_user_id = $company_user_id_array["data"]["common__company_user_id"];
        
        
        //************************************************
        // **** Test user or admin retrieve company user information ****
        $company_user_info_return = $company_user_service_obj->SendReceive_Service_Request(
                    "CB_AroundYou:get_full_company_user_data", 
                    array("common__company_user_id" => $company_user_id)
                );
        $company_user_info_return_array = json_decode($company_user_info_return, TRUE);
        $company_user_info_result = 
                ($company_user_info_return_array["status"] == "Complete" && array_key_exists("common__users_modification", $company_user_info_return_array["data"]))? "Pass" : "Fail";
        $note = "Return:<br>".$company_user_info_return."<br>";
        $this->unit->run("Pass", $company_user_info_result, "Test CB_AroundYou Company User information retrieved", $note);  
        $this->test_is_pass = ($company_user_info_result === "Pass") ? 1 : 0;
        
        
        //************************************************
        // **** Test user change activation, company count limit, banned and reason****
        //    ** Those test changes is seperated in 3 service calling 
        
        // Change activation information 
        $company_user_activation_info_return = $company_user_service_obj->Send_Service_Request(
                    "CB_AroundYou:create_modi_company_user", 
                    array(
                        "common__company_user_id" => $company_user_id,
                        "common__company_user_activated" => 0
                    )
                );
        // Change company count limit
        $company_user_count_info_return = $company_user_service_obj->Send_Service_Request(
                    "CB_AroundYou:create_modi_company_user", 
                    array(
                        "common__company_user_id" => $company_user_id,
                        "admin_user__company_count_limit" => 20
                    )
                );
        // Change banned info
        $company_user_banned_info_return = $company_user_service_obj->Send_Service_Request(
                    "CB_AroundYou:create_modi_company_user", 
                    array(
                        "common__company_user_id" => $company_user_id,
                        "admin_user__ban_reason" => "test out the banned changes",
                        "admin_user__banned" => 1
                    )
                );
        
        // Return the detail for checking purpose
        $company_user_changed_info_return = $company_user_service_obj->SendReceive_Service_Request(
                    "CB_AroundYou:get_full_company_user_data", 
                    array(
                        "common__company_user_id" => $company_user_id
                    )
                );
        
        $company_user_activation_return_array = json_decode($company_user_activation_info_return, TRUE);
        $company_user_count_info_return_array = json_decode($company_user_count_info_return, TRUE);
        $company_user_banned_info_return_array = json_decode($company_user_banned_info_return, TRUE);
        $company_user_changed_info_return_array = json_decode($company_user_changed_info_return, TRUE);
        $company_user_change_result = 
                ($company_user_activation_return_array["status"] === "Complete" && 
                 $company_user_count_info_return_array["status"] === "Complete" && 
                 $company_user_banned_info_return_array["status"] === "Complete" && 
                    array_key_exists("common__company_user_activated", $company_user_changed_info_return_array["data"]) && $company_user_changed_info_return_array["data"]["common__company_user_activated"] == 0 &&
                    array_key_exists("admin_user__company_count_limit", $company_user_changed_info_return_array["data"]) && $company_user_changed_info_return_array["data"]["admin_user__company_count_limit"] == 20 &&
                    array_key_exists("admin_user__ban_reason", $company_user_changed_info_return_array["data"]) && $company_user_changed_info_return_array["data"]["admin_user__ban_reason"] === "test out the banned changes" &&
                    array_key_exists("admin_user__banned", $company_user_changed_info_return_array["data"]) && $company_user_changed_info_return_array["data"]["admin_user__banned"] == 1
                )? "Pass" : "Fail";
        $note = "Return Change Activation:<br>   ".$company_user_activation_info_return."<br>";
        $note = $note."Return Change company count:<br>   ".$company_user_count_info_return."<br>";
        $note = $note."Return Change bannded info:<br>   ".$company_user_banned_info_return."<br>";
        $note = $note."Return Retrieved Activation:<br>   ".$company_user_changed_info_return."<br>";
        $this->unit->run("Pass", $company_user_change_result, "Test CB_AroundYou Change user activation for company", $note);  
        $this->test_is_pass = ($company_user_change_result === "Pass") ? 1 : 0;
        
        
        //************************************************
        // **** Test user create company ****
        //    ** Handle photo
        
        // Build base company information
        $company_base_info = array(
            "common__company_user_id" => $company_user_id,
            "info__company_logo" => "http://tmp_logo_pic_addr",
            "info__company_phone" => "+604-12345696",
            "info__company_phone" => "+604987654332",
            "info__company_about_us" => "this is dummy about us",
            "info__company_head_pic" => "http://tmp_head_pic_addr",
            "operation__period_type" => "1_2_3_4_5_6",
            "operation__auto" => TRUE,
        );
        
        /*
            

            // Company type
            "company_type__main"  => "aroundyou_company_type__main_category",
            "company_type__sub"  => "aroundyou_company_type__sub_category",
            
            // Company product and benefit
            //"aroundyou_company_product__list" => TRUE,
            //"aroundyou_company_benefit__list" => TRUE,
            
            // Location
            //"location__company_country"  => "country",
            //"location__company_state"  => "state",
            //"location__company_area"  => "area",
            //"location__company_post_code"  => "post_code",
            //"location__company_map"  => "map_location",
            //"location__company_street"  => "street",
            //"location__company_property_name"  => "property_name"
         */
        
        
        //************************************************
        // **** Test user edit company info ****
        
        //************************************************
        // **** Test user edit company operation info ****
       
        /*
         *             // Operation period
            "operation__period_type" => "aroundyou_operation_period__type",
            "operation__period_one_time" => "aroundyou_operation_period__one_time",
            "operation__time_start" => "aroundyou_company__operation_time_start",
            "operation__time_end"  => "aroundyou_company__operation_time_end",
            "operation__auto" => "aroundyou_company__operation_auto",
            "operation__manual_date_start" => "aroundyou_company__operation_manual_date_start",
            
         */
        
        //************************************************
        // **** Test user add/edit/remove benefit ****
        
        //************************************************
        // **** Test user edit/remove benefit ****
        
        //************************************************
        // **** Test user edit company activated  ****

        //************************************************
        // **** Test admin change company product count limit ****
        
        //************************************************
        // **** Test admin change company benefit count limit ****
        
        //************************************************
        // **** Test admin change company activate date and duration ****
        
        
        
        
        //************************************************
        // **** Test company removal ****

        //************************************************
        // **** Test company user removal ****
        
   }
   
   private function _unittest__cleanup()
   {
       /*
       // Invoke fast clean up
       $fast_clean_service_obj = new aroundyou_utils__DataServer__Service();
        
        $user_id_data = array(
            "common__user_id" => $this->test_id
        );
        
        $company_user_id_return = $fast_clean_service_obj->SendReceive_Service_Request(
                    "CB_AroundYou:fast_clean_data", 
                    $user_id_data
                );
        $company_user_id_array = json_decode($company_user_id_return, TRUE);
        $company_user_id_result = 
                ($company_user_id_array["status"] == "Complete" && array_key_exists("common__company_user_id",$company_user_id_array["data"]))? "Pass" : "Fail";
        $note = "Return:<br>".$company_user_id_return."<br>";
        $this->unit->run("Pass", $company_user_id_result, "Test CB_AroundYou Company User Creation", $note);  
        */
       
   }
   
   public function test_list()
   {
       // Basic test on gateway
       $this->_unittest__service();
       
       // Flow test
       $this->_unittest__complete_flow();
       
       // Clean up incase test unsuccess
       //$this->_unittest__cleanup();
       
       // To have summary reported
       $this->unit->run(1, $this->test_is_pass, "CB_AroundYou test summary report", "");  
        
       
       // report out
       echo $this->unit->report();
   }

}
?>
