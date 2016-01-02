<?php
require_once 'unit_test_main.php';
require_once dirname(dirname(__FILE__)).'/CBWS_Service/CBWS_Service_Base.php';

class gateway_unit_test extends unit_test_main
{
    function __construct() {
        parent::__construct();
        
        $current_file_name = pathinfo(__FILE__, PATHINFO_FILENAME);
        $this->benchmark_dump_file("\n".$current_file_name);
        
    }
    
    ###########################unit test region####################################
    public function _unit_test_cbsw_gateway() {
       
       $val_return = $this->direct_func_invoke("GeneralFunc", "CB_Test_Gateway", "");
       
       $val_golden = "Test: Success to Authenticate the request by Webservice";
       $note = "Return value -- $val_return <br>";
       $note = $note."Golden value -- $val_golden";
            
       $this->unit->run($val_return, json_encode($val_golden), "Test CBSW gateway", $note);
   }
   
   public function _unit_test_cbsw_service_entries() {
       
       // Send with AUTH
       $val_return = $this->Send_Service("test_auth_service","Test test_auth_service");
       
       $golden["service"] = "test_auth_service";
       $golden["status"] = "Complete";
       $golden["status_information"] = "Info: Complete test_auth_service Service"; 
       
       $val_golden = json_encode($golden);
       $note = "Return value -- $val_return <br>";
       $note = $note."Golden value -- $val_golden";
       
       $this->unit->run($val_return, $val_golden, "Test CBSW AUTH Send gateway", $note);
       
       // Recieve with AUTH
       $val_return = $this->Receive_Service("test_auth_service");
       
       $golden["service"] = "test_auth_service";
       $golden["status"] = "Complete";
       $golden["status_information"] = "Info: Complete test_auth_service Service"; 
       $golden["data"] = null; 
       
       $val_golden = json_encode($golden);
       $note = "Return value -- $val_return <br>";
       $note = $note."Golden value -- $val_golden";
       
       $this->unit->run($val_return, $val_golden, "Test CBSW AUTH Recieved gateway", $note);
       
       // Send Recieve with Non AUTH
       $val_return = $this->SendReceive_Service("test_none_auth_service","Test test_none_auth_service");
       
       $golden["service"] = "test_none_auth_service";
       $golden["status"] = "Complete";
       $golden["status_information"] = "Info: Complete test_none_auth_service Service"; 
       $golden["data"] = "Test test_none_auth_service"; 
       
       $val_golden = json_encode($golden);
       $note = "Return value -- $val_return <br>";
       $note = $note."Golden value -- $val_golden";
       
       $this->unit->run($val_return, $val_golden, "Test CBSW None AUTH Send Recieved gateway", $note);
   }
   
   private function _unit_test_cbws_service_base()
   {
       // AUTH Service hit check
       $request_command_auth = array(
           "service" =>"CBWS_Service_Base:_auth_test",
           "AUTH" => TRUE,
           "send_data" => "test _auth_test"
       );
       
       $val_return_auth =  json_encode($this->direct_func_invoke("CBWS_Service_Base","invoke_service",$request_command_auth));
       $golden_auth = array(
           "status" => "Complete",
           "status_information" => "Info: Complete CBWS_Service_Base:_auth_test Service",
           "data" => "test _auth_test"
           
       );
       
       $val_golden_auth = json_encode($golden_auth);
       $note_auth = "Return value -- $val_return_auth <br>";
       $note_auth = $note_auth."Golden value -- $val_golden_auth";
       
       $this->unit->run($val_return_auth, $val_golden_auth, "Test Base service class auth service", $note_auth);
       
       // AUTH Service with no AUTH Error check
       //    Must after AUTH service check as previous data required
       $request_command_auth["AUTH"] = FALSE;
       
       $val_return_auth_error =  $this->direct_func_invoke("CBWS_Service_Base","invoke_service",$request_command_auth);
       $golden_auth_error = array(
           "status" => "Error SBE-SC-1",
       );
       
       $json_return_auth_error = json_encode($val_return_auth_error, TRUE);
       
       $val_golden_auth_error = json_encode($golden_auth_error);
       $note_auth_error = "Return value -- $json_return_auth_error <br>";
       $note_auth_error = $note_auth_error."Golden value -- $val_golden_auth_error";
       
       $this->unit->run($val_return_auth_error["status"], $golden_auth_error["status"], "Test Base service class auth service without AUTH", $note_auth_error);
       
       
       // NON AUTH Service hit check
       $request_command_non_auth = array(
           "service" =>"CBWS_Service_Base:_non_auth_test",
           "AUTH" => FALSE,
           "send_data" => "test _non_auth_test"
       );
       
       $val_return_non_auth =  json_encode($this->direct_func_invoke("CBWS_Service_Base","invoke_service",$request_command_non_auth));
       $golden_non_auth = array(
           "status" => "Complete",
           "status_information" => "Info: Complete CBWS_Service_Base:_non_auth_test Service",
           "data" => "test _non_auth_test"
           
       );
       
       $val_golden_non_auth = json_encode($golden_non_auth);
       $note_non_auth = "Return value -- $val_return_non_auth <br>";
       $note_non_auth = $note_non_auth."Golden value -- $val_golden_non_auth";
       
       $this->unit->run($val_return_non_auth, $val_golden_non_auth, "Test Base service class non auth service", $note_non_auth);
       
       // Error check for service not found
       $request_command_err = array(
           "service" =>"CBWS_Service_Base:invalid_service",
           "AUTH" => TRUE,
           "send_data" => ""
       );
       
       $val_return_err =  $this->direct_func_invoke("CBWS_Service_Base","invoke_service",$request_command_err);
       $golden_err = array(
           "status" => "Error SBE-SC-2",
       );
       
       $json_return_err = json_encode($val_return_err, TRUE);
       
       $val_golden_err = json_encode($golden_err);
       $note_err = "Return value -- $json_return_err <br>";
       $note_err = $note_err."Golden value -- $val_golden_err";
       
       $this->unit->run($val_return_err["status"], $golden_err["status"], "Test Base service class when invalid service", $note_err);
   }
   
   private function _unit_test_cbws_service_base_entries()
   {
       // AUTH Service hit check
       $val_return_auth = $this->SendReceive_Service("CBWS_Service_Base:_auth_test","test _auth_test");
       
       $golden_auth = array(
           "service" => "CBWS_Service_Base:_auth_test",
           "status" => "Complete",
           "status_information" => "Info: Complete CBWS_Service_Base:_auth_test Service",
           "data" => "test _auth_test"
       );
       
       $val_golden_auth = json_encode($golden_auth);
       $note_auth = "Return value -- $val_return_auth <br>";
       $note_auth = $note_auth."Golden value -- $val_golden_auth";
       
       $this->unit->run($val_return_auth, $val_golden_auth, "CBWS Test gateway Base service class auth service", $note_auth);
       
       
       // NON AUTH Service hit check
       $val_return_non_auth =  $this->SendReceive_Service("CBWS_Service_Base:_non_auth_test","test _non_auth_test");
       $golden_non_auth = array(
           "service" => "CBWS_Service_Base:_non_auth_test",
           "status" => "Complete",
           "status_information" => "Info: Complete CBWS_Service_Base:_non_auth_test Service",
           "data" => "test _non_auth_test"
       );
       
       $val_golden_non_auth = json_encode($golden_non_auth);
       $note_non_auth = "Return value -- $val_return_non_auth <br>";
       $note_non_auth = $note_non_auth."Golden value -- $val_golden_non_auth";
       
       $this->unit->run($val_return_non_auth, $val_golden_non_auth, "CBWS gateway Test Base service class non auth service", $note_non_auth);
       
       
       // Error check for service not found
       $val_return_err =  $this->SendReceive_Service("CBWS_Service_Base:invalid_service","");
       $golden_err = array(
           "status" => "Error SBE-SC-2",
       );
       
       $array_return_err = json_decode($val_return_err, TRUE);
       
       $val_golden_err = json_encode($golden_err);
       $note_err = "Return value -- $val_return_err <br>";
       $note_err = $note_err."Golden value -- $val_golden_err";
       
       $this->unit->run($array_return_err["status"], $golden_err["status"], "CBWS gateway Test Base service class when invalid service", $note_err);

   }
   
   public function test_list()
   {
       // CBWS gateway self test
       $this->_unit_test_cbsw_gateway();
       $this->_unit_test_cbsw_service_entries();
       
       // CBWS service base class test
       $this->_unit_test_cbws_service_base();
       $this->_unit_test_cbws_service_base_entries();
       
       
       echo $this->unit->report();
   }

}
?>
