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
                    "CB_AroundYou:aroundyou_lib__company_user_add_edit", 
                    $user_id_data
                );
        $company_user_id_array = json_decode($company_user_id_return, TRUE);
        $company_user_id_result = 
                ($company_user_id_array["status"] == "Complete" && array_key_exists("common__company_user_id",$company_user_id_array["data"]))? "Pass" : "Fail";
        $note = "Return:<br>".$company_user_id_return."<br>";
        $this->unit->run("Pass", $company_user_id_result, "Test CB_AroundYou Company User Creation", $note);  
        $this->test_is_pass = ($company_user_id_result === "Pass") ? 1 : 0;
        
        //************************************************
        // Exit unit test if fail to create company user informaton
        if ($company_user_id_result == "Fail"){ return 0; }
        
        //************************************************
        // data extraction for later use
        $company_user_id = $company_user_id_array["data"]["common__company_user_id"];
        
        
        //************************************************
        // **** Test user or admin retrieve company user information ****
        $company_user_info_return = $company_user_service_obj->SendReceive_Service_Request(
                    "CB_AroundYou:aroundyou_lib__get_company_user_data", 
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
                    "CB_AroundYou:aroundyou_lib__company_user_add_edit", 
                    array(
                        "common__company_user_id" => $company_user_id,
                        "common__company_user_activated" => 0
                    )
                );
        // Change company count limit
        $company_user_count_info_return = $company_user_service_obj->Send_Service_Request(
                    "CB_AroundYou:aroundyou_lib__company_user_add_edit", 
                    array(
                        "common__company_user_id" => $company_user_id,
                        "admin_user__company_count_limit" => 20
                    )
                );
        // Change banned info
        $company_user_banned_info_return = $company_user_service_obj->Send_Service_Request(
                    "CB_AroundYou:aroundyou_lib__company_user_add_edit", 
                    array(
                        "common__company_user_id" => $company_user_id,
                        "admin_user__ban_reason" => "test out the banned changes",
                        "admin_user__banned" => 1
                    )
                );
        
        // Return the detail for checking purpose
        $company_user_changed_info_return = $company_user_service_obj->SendReceive_Service_Request(
                    "CB_AroundYou:aroundyou_lib__get_company_user_data", 
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
        //    ** Require - User id ($company_user_id)
        //    ** Hadle initial company initial data
        //    ** Handle photo
        
        // Build base company information
        $company_base_info = array(
            "common__company_user_id" => $company_user_id,
            "info__company_ref_prefix" => "test-tag",
            "info__company_logo" => "http://tmp_logo_pic_addr",
            "info__company_phone" => "+604-12345696",
            "info__company_phone" => "+604987654332",
            "info__company_about_us" => "this is dummy about us",
            "info__company_head_pic" => "http://tmp_head_pic_addr",
            "operation__period_type" => "1_2_3_4_5_6",
            "operation__auto" => 0,
            "company_type__main" => "Restaurant",
            "company_type__sub" => "Chinese Restaurant",
            "info__company_product_list" => array(
                array(
                    "image" => "http://tmp_product_link_1",
                    "title" => "Product 1",
                    "info" => "This is info for product 1",
                    "price" => 1000,
                    "currency_code" => "MYR"
                ),
                array(
                    "image" => "http://tmp_product_link_2",
                    "title" => "Product 2",
                    "info" => "This is info for product 2",
                    "price" => 2000,
                    "currency_code" => "MYR"
                ),
            ),
            "info__company_benefit_list" => array(
                array(
                    "image" => "http://tmp_benefit_link_1",
                    "title" => "Benefit 1",
                    "info" => "This is info for benefit 1",
                    "start_date" => "2017-11-27",
                    "end_date" => "2017-12-03",
                    "type" => "Discount"
                )
            ),
            "location__company_country" => "Malaysia",
            "location__company_state" => "Pulau Pinang",
            "location__company_area" => "Gelugor",
            "location__company_post_code" => "11700",
            "location__company_map" => array(
                "k" => 3.1403075200382 ,
                "B" => 101.68664550781
            ),
            "location__company_street" => "Jalan Batu Uban",
            "location__company_property_name" => "N-park Condominium Jalan Batu Uban Gelugor Penang Malaysia"
        );
        
        
        // Pump in initial data
        $company_company_info_return = $company_user_service_obj->SendReceive_Service_Request(
                    "CB_AroundYou:aroundyou_lib__create_modi_company_info", 
                    $company_base_info
                );
        
        $company_company_info_return_array = json_decode($company_company_info_return, TRUE);
        $company_info_result = 
                ($company_company_info_return_array["status"] == "Complete" && array_key_exists("id", $company_company_info_return_array["data"]))? "Pass" : "Fail";
        $note = "Return:<br>".$company_company_info_return."<br>";
        $this->unit->run("Pass", $company_info_result, "Test CB_AroundYou Company information initial set", $note);  
        $this->test_is_pass = ($company_info_result === "Pass") ? 1 : 0;
        
        //************************************************
        // Exit unit test if fail to create company information
        if ($company_info_result == "Fail"){ return 0; }
        
        //************************************************
        // **** Extract company id for later use ****
        $company_ref_tag = $company_company_info_return_array["data"]["info__company_ref_tag"];
        
 
        //************************************************
        // **** Test user/admin edit company info ****
        // Build base company information
        $company_edit_info = array(
            "common__company_user_id" => $company_user_id,
            "info__company_ref_prefix" => "test-tag",
            "info__company_logo" => "http://tmp_logo_pic_addr",
            "info__company_phone" => "+604-12345696",
            "info__company_phone" => "+604987654332",
            "info__company_about_us" => "this is dummy about us",
            "info__company_head_pic" => "http://tmp_head_pic_addr",
            "operation__period_type" => "1_2_3_4_5_6",
            "operation__auto" => 0,
            "company_type__main" => "Restaurant",
            "company_type__sub" => "Chinese Restaurant",
            "info__company_product_list" => array(
                array(
                    "image" => "http://tmp_product_link_1",
                    "title" => "Product 1",
                    "info" => "This is info for product 1",
                    "price" => 1000,
                    "currency_code" => "MYR"
                ),
                array(
                    "image" => "http://tmp_product_link_2",
                    "title" => "Product 2",
                    "info" => "This is info for product 2",
                    "price" => 2000,
                    "currency_code" => "MYR"
                ),
            ),
        );
        
        
        

        
        //************************************************
        // **** Test user add/edit/remove product ****
        
        //************************************************
        // **** Test user edit/remove product ****
        
        
        //************************************************
        // **** Test user add/edit/remove benefit ****
        
        //************************************************
        // **** Test user edit/remove benefit ****
        
        
        //************************************************
        // **** Test on area search result and summary return
        //    Need to activate back the user and company for result hit
        
        
        //************************************************
        // **** Test picture handle and process****
        
        
        
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
