<?php

/**
 * Description this function class is created to allow user to activate and deactivate 
 * existing listing
 *
 * @author Tan Chun Mun
 */
require_once dirname(__DIR__) . '/CBWS_Service/CB_Property.php';
require_once dirname(__DIR__) . '/CBWS_AUTH_Service/CBWS_Member/CBWS_Member.php';
require_once "GeneralFunc.php";
class activate_deactivate_listing {
    private $member_obj = NULL;
    private $property_obj = NULL;
    public function __construct() {
        $this->member_obj = new CBWS_Member();
        $this->property_obj = new CB_Property();
    }
    private function is_listing_available($user_id)
    {
        $filter_struct = array(
            "filter" => 
                array("user_id" => $user_id, "activate" => 1)
        );
        $listing_limitation = $this->member_obj->get_user_property_listing_limit($user_id);
        $this->property_obj->filter_listing($filter_struct);
        $available_listing = $this->property_obj->get_return_data_set();
        
        
        return $available_listing["data"]["count"] < $listing_limitation;
    }
    public function activate_listing($ref_tag, $user_id, $activate, &$val_return_array)
    {
       $activate_data = array();
       $activate_data["ref_tag"] = $ref_tag;
       $activate_data["user_id"] = $user_id;
       $activate_data["activate"] = $activate;
        if($activate === "true")
        {
           if(!$this->is_listing_available($user_id))
           {
               return FALSE;
           }
           
        }
        $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Property:change_listing_activate",json_encode($activate_data));
        $val_return_array = json_decode($val_return, true);

        if($val_return_array["status_information"] === "Info: Complete change activation status")
        {
           return TRUE; 
        }
        return FALSE;
        
    }
}

?>
