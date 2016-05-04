<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CB_Activation_unit_test
 *
 * @author user
 */
require_once 'unit_test_main.php';
require_once dirname(dirname(__FILE__)) .'/_utils/activate_deactivate_listing.php';
require_once 'PHPUnit/Autoload.php';

class CB_Activation_unit_test extends PHPUnit_Framework_TestCase
{
   function __construct() {
        parent::__construct();
        
        $current_file_name = pathinfo(__FILE__, PATHINFO_FILENAME);
        $this->benchmark_dump_file("\n".$current_file_name);
        
    }
    
    public function unit_test_is_listing_available() {
        $user_id = 1;
        $activate_deactivate_listing = new activate_deactivate_listing();
       $val_return = $activate_deactivate_listing->is_listing_available($user_id);
       $val_golden = TRUE;
       $note = "nothing";
       $this->unit->run($val_return, $val_golden, "Test is listing available", $note);
    }
    
    public function test_list()
   {
       $this->unit_test_is_listing_available();
       echo $this->unit->report();
   }
    //put your code here
}

?>
