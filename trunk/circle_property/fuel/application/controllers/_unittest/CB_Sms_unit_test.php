<?php
require_once dirname(dirname(__FILE__)).'/CBWS_Service/CB_Currency.php';
require_once 'unit_test_main.php';

class CB_Sms_unit_test extends unit_test_main
{
    function __construct() {
        parent::__construct();
        
        $current_file_name = pathinfo(__FILE__, PATHINFO_FILENAME);
        $this->benchmark_dump_file("\n".$current_file_name);
        
    }
    
    ###########################unit test region####################################
   private function _unit_test_sms_count_change()
   {
        $adequate_sms_count = False;
        $owner_email = "test@yahoo.com";
        if($owner_email)
        {
           $sms_limit_json = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:update_sms_limit",
                json_encode($owner_email));
           $adequate_sms_count = json_decode($sms_limit_json, TRUE)["data"]["result"];
        }
        
        $golden = array();
        $golden["service"] = "CB_Member:update_sms_limit";
        $golden["status"] = "Complete";
        $golden["status_information"] = "Info: Complete CB_Currency:currency_converter_to_any"; 
        $golden["data"] = array('result'=>1000);

        $val_golden = json_encode($golden);
        $note = "Return value -- $adequate_sms_count <br>";
        $note = $note."Golden value -- $val_golden";
        echo $adequate_sms_count;
        $this->unit->run($adequate_sms_count, $val_golden, "Test sms update", $note);
   }
   
   public function test_list()
   {
       $this->_unit_test_sms_count_change();
       echo $this->unit->report();
   }

}
?>
