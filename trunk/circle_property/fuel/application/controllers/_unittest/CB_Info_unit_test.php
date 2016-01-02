<?php
require_once 'unit_test_main.php';

class CB_Info_unit_test extends unit_test_main
{
    function __construct() {
        parent::__construct();
        
        $current_file_name = pathinfo(__FILE__, PATHINFO_FILENAME);
        $this->benchmark_dump_file("\n".$current_file_name);
        
    }
    
   public function _unit_test_get_info()
   {
        $val_return = $this->Receive_Service("CB_Info:base_url");
        $data = json_decode($val_return, TRUE);
        $golden = "http://localhost/cb_iloveproperty/trunk/circle_property/";
        $note = "Return value -- ".$val_return . "<br>";
        $note = $note."Golden value -- ".$golden . "<br>";
        
        $this->unit->run($data["data"]["result"], $golden, "Test CB_Member is get user id", $note);
   }
   public function test_list()
   {
       $this->_unit_test_get_info();
       //$this->_unit_test_create_user();
       //$this->_unit_test_send_activate_email();
       //$this->_unit_test_get_captcha();
       // $this->_unit_test_check_captcha();
       /*$this->_unit_test_create_user();
       $this->_unit_test_get_country_code();
       $this->_unit_test_validate_email();
       $this->_unit_test_validate_invalid_email();
       $this->_unit_test_send_activate_email();
       $this->_unit_test_send_welcome_email();
       $this->_unit_test_get_country_list();
       //$this->_unit_test_get_captcha();
       $this->_unit_test_check_captcha();*/
       //$this->_unit_test_login();
       
       //$this->_unit_test_is_login();
       //$this->_unit_test_get_user_id();
       //$this->_unit_test_logout();
       //$this->_unit_test_is_max_login_attempts_exceeded();
       //$this->_unit_test_activate_user();

       //$this->_unit_test_get_error();
       //$this->_unit_test_cbsw_service();
       echo $this->unit->report();
   }
}
?>
