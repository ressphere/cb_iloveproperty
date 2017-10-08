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
       
   }
   
   public function test_list()
   {
       
       $this->_unittest__service();
       $this->_unittest__complete_flow();
       echo $this->unit->report();
   }

}
?>
