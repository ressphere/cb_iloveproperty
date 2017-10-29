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
   }
   
   /*
    * To test on complete flow 
    *   submit -> query -> edit -> query -> deleted
    */
   private function _unittest__complete_flow()
   {
        // **** To test on company user creation ****
        $company_user_service_obj = new aroundyou_utils__DataServer__Service();
        
        $user_id_data = array(
            "common__user_id" => $this->test_id
        );
        
        $company_user_id_return = $company_user_service_obj->SendReceive_Service_Request(
                    "CB_AroundYou:create_company_user", 
                    $user_id_data
                );
        $company_user_id_array = json_decode($company_user_id_return, TRUE);
        $company_user_id_result = 
                ($company_user_id_array["status"] == "Complete" && array_key_exists("common__company_user_id",$company_user_id_array["data"]))? "Pass" : "Fail";
        $note = "Return:<br>".$company_user_id_return."<br>";
        $this->unit->run("Pass", $company_user_id_result, "Test CB_AroundYou Company User Creation", $note);  
        
        // Exit unit test if fail to create company
        if ($company_user_id_result == "Fail"){ return 0; }
        
        // data extraction for later use
        $company_user_id = $company_user_id_array["data"]["common__company_user_id"];
        
        
        // **** Test user or admin retrieve company user information ****
        $company_user_info_return = $company_user_service_obj->SendReceive_Service_Request(
                    "CB_AroundYou:get_full_company_user_data", 
                    array("common__company_user_id" => $company_user_id)
                );
        $company_user_info_return_array = json_decode($company_user_info_return, TRUE);
        $company_user_info_result = 
                ($company_user_info_return_array["status"] == "Complete" && array_key_exists("aroundyou_users__modified", $company_user_info_return_array["data"]))? "Pass" : "Fail";
        $note = "Return:<br>".$company_user_info_return."<br>";
        $this->unit->run("Pass", $company_user_info_result, "Test CB_AroundYou Company User information retrieved", $note);  
        
        
        // **** Test user change activation ****
        
        
        
        // **** Test admin change user company count limit ****
        
        
        
        // **** Test admin change user banned and reason ****
        
        
        
        
        // **** Test user create company ****

        // **** Test user edit company info ****
        // **** Test user edit company operation info ****
        // **** Test user add/edit/remove benefit ****
        // **** Test user edit/remove benefit ****
        // **** Test user edit company activated  ****


        // **** Test admin change company product count limit ****
        // **** Test admin change company benefit count limit ****
        // **** Test admin change company activate date and duration ****

        // **** Test company removal ****

        
        // **** Test comany user removal ****
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
       
       // report out
       echo $this->unit->report();
   }

}
?>
