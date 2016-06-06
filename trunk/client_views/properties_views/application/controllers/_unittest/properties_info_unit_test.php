<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(dirname(__FILE__)) . '/_utils/properties_info.php';


class properties_info_unit_test extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->library('unit_test');
        
        
    }
    
    ###########################unit test region####################################
   
   
   private function _unit_test_get_supported_currency()
   {
       // AUTH Service hit check
       $properties_info_obj = new properties_info();
       $currency_list = $properties_info_obj->get_currency_list();
       var_dump($currency_list);
       $this->unit->run(1,1, "CBWS Test gateway Base service class auth service", "nothing");
       
       
       
   }
     private function _unit_test_convert_currency_from_enum_to_string()
   {
       // AUTH Service hit check
       $properties_info_obj = new properties_info();
       $currency_in_string = $properties_info_obj->convert_currency_from_enum_to_string(0);
       var_dump($currency_in_string);
       $this->unit->run(1,1, "CBWS Test gateway Base service class auth service", "nothing");
       
       
       
   }
   
   
   public function test_list()
   {
       
       $this->_unit_test_get_supported_currency();
       $this->_unit_test_convert_currency_from_enum_to_string();
       echo $this->unit->report();
   }

}
?>
