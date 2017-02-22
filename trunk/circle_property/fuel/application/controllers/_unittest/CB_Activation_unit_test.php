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
class Stub_CBWS_Member extends CBWS_Member
{
    private $property_listing_limit = 0;
    private $property_sms_limit = 0;
    public function set_property_listing_limit($limit)
    {
        $this->property_listing_limit = $limit;
    }
    public function get_user_property_listing_limit($user_id)
    {
        return $this->property_listing_limit;
    }
    
    public function get_user_property_sms_limit($user_id)
    {
        return $this->$property_sms_limit;
    }
    
    public function set_user_property_sms_limit($limit)
    {
        $this->$property_sms_limit = $limit;
    }
    
}

class Stub_CB_Property extends CB_Property
{
    private $property_listing_count = array(
            "data" => 
                array("count" => 0)
        );
    public function set_data_set($count)
    {
        $this->property_listing_count["data"]["count"] = $count;
    }
    public function get_return_data_set()
    {
        return $this->property_listing_count;
    }
}
class CB_Activation_unit_test extends unit_test_main
{
   function __construct() {
        parent::__construct();
        
        $current_file_name = pathinfo(__FILE__, PATHINFO_FILENAME);
        $this->benchmark_dump_file("\n".$current_file_name);
        
    }
    
    public function unit_test_is_listing_available() {
       $user_id = 1;
       $limit = rand(5, 15);
       $used_limit = rand(0, 4);
       $activate_deactivate_listing = new activate_deactivate_listing();
       $member_obj = new Stub_CBWS_Member();
       $member_obj->set_property_listing_limit($limit);
       
       $property_obj = new Stub_CB_Property();
       $property_obj->set_data_set($used_limit);
       
       $this->set_attribute($activate_deactivate_listing, "member_obj", $member_obj);
       $this->set_attribute($activate_deactivate_listing, "property_obj", $property_obj);
       $val_return = $this->method($activate_deactivate_listing, "is_listing_available", $user_id);
       $val_golden = TRUE;
       $note = "listing quota: " . $limit ." > listing used: " . $used_limit;
       
       $this->unit->run($val_return, $val_golden, "Test is listing available", $note);
    }
    
    public function unit_test_is_listing_not_available() {
       $user_id = 1;
       $limit = rand(0, 4);
       $used_limit = rand(4, 10);
       $activate_deactivate_listing = new activate_deactivate_listing();
       $member_obj = new Stub_CBWS_Member();
       $member_obj->set_property_listing_limit($limit);
       
       $property_obj = new Stub_CB_Property();
       $property_obj->set_data_set($used_limit);
       
       $this->set_attribute($activate_deactivate_listing, "member_obj", $member_obj);
       $this->set_attribute($activate_deactivate_listing, "property_obj", $property_obj);
       $val_return = $this->method($activate_deactivate_listing, "is_listing_available", $user_id);
       $val_golden = FALSE;
       $note = "listing quota: " . $limit ." < listing used: " . $used_limit;
       
       $this->unit->run($val_return, $val_golden, "Test is listing available", $note);
    }
    
    public function unit_test_is_listing_not_available_limit_eq_used() {
       $user_id = 1;
       $limit = 4;
       $used_limit = 4;
       $activate_deactivate_listing = new activate_deactivate_listing();
       $member_obj = new Stub_CBWS_Member();
       $member_obj->set_property_listing_limit($limit);
       
       $property_obj = new Stub_CB_Property();
       $property_obj->set_data_set($used_limit);
       
       $this->set_attribute($activate_deactivate_listing, "member_obj", $member_obj);
       $this->set_attribute($activate_deactivate_listing, "property_obj", $property_obj);
       $val_return = $this->method($activate_deactivate_listing, "is_listing_available", $user_id);
       $val_golden = FALSE;
       $note = "listing quota: " . $limit ." == listing used: " . $used_limit;
       
       $this->unit->run($val_return, $val_golden, "Test is listing available", $note);
    }
    
    
    public function test_list()
   {
       $this->unit_test_is_listing_available();
       $this->unit_test_is_listing_not_available();
       $this->unit_test_is_listing_not_available_limit_eq_used();
       echo $this->unit->report();
   }
    //put your code here
}

?>
