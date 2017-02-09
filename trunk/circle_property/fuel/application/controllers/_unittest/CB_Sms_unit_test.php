<?php
require_once dirname(dirname(__FILE__)).'/CBWS_AUTH_Service/CBWS_sms/CBWS_Sms.php';
require_once 'unit_test_main.php';
class CB_Sms_unit_test extends unit_test_main {
     function __construct() {
        parent::__construct();
     }
     
     public function _unit_test_send_sms()
     {
        $input_data_json = "{\"destination\":\"60177002929\",\"message\":\"Hello\"}";
        // Create component object
        //$cb_property = new CB_Property();
        
        // Build service array
        $service_send_sms = [
            "service" => "CB_Sms:send_sms",
            "send_data" => $input_data_json,
            "AUTH" => true
        ];
        
        //$val_return = $cb_property->invoke_service($service_send_sms);
        $val_return = $this->SendReceive_Service("CB_Sms:send_sms",  $input_data_json);
        
        $val_return_json = json_encode($val_return);
        $val_golden = "{\"service\":\"CB_Sms:send_sms\",\"status\":\"Complete\",\"status_information\":\"Ressphere send sms \",\"data\":{\"result\":\"true\"}}";
        $note = "return result -- $val_return_json <br>";
        
        $this->unit->run($val_return_json, $val_golden, "Test CB_Sms class send sms API", $note);
     }
     
     public function test_list()
     {
       //$this->test_generic_api();
       
       // Unit_test wrap around fail this, temporary disable
       //$this->_unit_test_feature();
       $this->_unit_test_send_sms();
       echo $this->unit->report();
     }
     
}

?>
