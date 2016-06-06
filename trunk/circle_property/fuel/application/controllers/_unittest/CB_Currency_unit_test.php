<?php
require_once dirname(dirname(__FILE__)).'/CBWS_Service/CB_Currency.php';
require_once 'unit_test_main.php';

class CB_Currency_unit_test extends unit_test_main
{
    function __construct() {
        parent::__construct();
        
        $current_file_name = pathinfo(__FILE__, PATHINFO_FILENAME);
        $this->benchmark_dump_file("\n".$current_file_name);
        
    }
    
    ###########################unit test region####################################
   private function _unit_test_currency_converter_to_any()
   {
               $argument = json_encode(array(
                "value"=>1000,
                "from"=>"MYR",
                "to"=>0
            ));
        $val_return = $this->SendReceive_Service("CB_Currency:currency_converter_to_any",
                $argument);
        
        $golden = array();
        $golden["service"] = "CB_Currency:currency_converter_to_any";
        $golden["status"] = "Complete";
        $golden["status_information"] = "Info: Complete CB_Currency:currency_converter_to_any"; 
        $golden["data"] = array('result'=>1000);

        $val_golden = json_encode($golden);
        $note = "Return value -- $val_return <br>";
        $note = $note."Golden value -- $val_golden";

        $this->unit->run($val_return, $val_golden, "Test CB_Currency AUTH Send Recieved convert enum to string", $note);
   }
   private function _unit_test_get_list_of_currency()
   {
        $val_return = $this->Receive_Service("CB_Currency:get_currency_list");
        
        $golden = array();
        $golden["service"] = "CB_Currency:get_currency_list";
        $golden["status"] = "Complete";
        $golden["status_information"] = "Info: Complete CB_Currency:get_currency_list"; 
        $golden["data"] = array('result'=>array("MYR"=>"Malaysia Ringgit",
            "SGD"=>"Singapore Dollar",
            "USD"=>"US Dollar"));

        $val_golden = json_encode($golden);
        $note = "Return value -- $val_return <br>";
        $note = $note."Golden value -- $val_golden";

        $this->unit->run($val_return, $val_golden, "Test CB_Currency AUTH Recieved currency list", $note);    
   }
      
   private function _unit_test_get_currency_type_string()
   {
        $argument = json_encode(array(
                "currency"=>0
            ));
        $val_return = $this->SendReceive_Service("CB_Currency:get_currency_type_string",
                $argument);
        
        $golden = array();
        $golden["service"] = "CB_Currency:get_currency_type_string";
        $golden["status"] = "Complete";
        $golden["status_information"] = "Info: Complete CB_Currency:get_currency_type_string"; 
        $golden["data"] = array('result'=>'MYR');

        $val_golden = json_encode($golden);
        $note = "Return value -- $val_return <br>";
        $note = $note."Golden value -- $val_golden";

        $this->unit->run($val_return, $val_golden, "Test CB_Currency AUTH Send Recieved convert enum to string", $note);    
   }
   
      private function _unit_test_get_currency_type_enum()
   {
        $argument = json_encode(array(
                "currency"=>'MYR'
            ));
        $val_return = $this->SendReceive_Service("CB_Currency:get_currency_type_enum",
                $argument);
        
        $golden = array();
        $golden["service"] = "CB_Currency:get_currency_type_enum";
        $golden["status"] = "Complete";
        $golden["status_information"] = "Info: Complete CB_Currency:get_currency_type_enum"; 
        $golden["data"] = array('result'=>0);

        $val_golden = json_encode($golden);
        $note = "Return value -- $val_return <br>";
        $note = $note."Golden value -- $val_golden";

        $this->unit->run($val_return, $val_golden, "Test CB_Currency AUTH Send Recieved convert string to enum", $note);    
   }
   
   
   private function _unit_test_get_converted_currency_value()
   {
        $argument = json_encode(array(
                "currency_value"=>1200,
                "from_currency"=>"MYR",
                "to_currency" => "MYR"
            ));
        $val_return = $this->SendReceive_Service("CB_Currency:get_converted_currency_value", $argument);
        
        $golden = array();
        $golden["service"] = "CB_Currency:get_converted_currency_value";
        $golden["status"] = "Complete";
        $golden["status_information"] = "Info: Complete CB_Currency:get_converted_currency_value"; 
        $golden["data"] = array('result'=>1200);

        $val_golden = json_encode($golden);
        $note = "Return value -- $val_return <br>";
        $note = $note."Golden value -- $val_golden";

        $this->unit->run($val_return, $val_golden, "Test CB_Currency AUTH Send Recieved convert string to enum", $note);   
   }
   
   public function test_list()
   {
      //$this->test_generic_api();
       
       // Unit_test wrap around fail this, temporary disable
       //$this->_unit_test_feature();
       $this->_unit_test_get_currency_type_string();
       $this->_unit_test_get_currency_type_enum();
       $this->_unit_test_get_list_of_currency();
       $this->_unit_test_get_converted_currency_value();
       $this->_unit_test_currency_converter_to_any();
       echo $this->unit->report();
   }

}
?>
