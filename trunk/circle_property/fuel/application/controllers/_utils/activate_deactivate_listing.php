<?php

/**
 * Description this function class is created to allow user to activate and deactivate 
 * existing listing
 *
 * @author Tan Chun Mun
 */
require_once dirname(__DIR__) . '/CBWS_Service/CB_Property.php';
require_once dirname(__DIR__) . '/CBWS_AUTH_Service/CBWS_Member/CBWS_Member.php';
class activate_deactivate_listing {
    private $member_obj = NULL;
    private $property_obj = NULL;
    public function __construct() {
        $this->member_obj = new CBWS_Member();
        $this->property_obj = new CB_Property();
    }
    public function is_listing_available($user_id)
    {
        $filter_struct = array(
            "filter" => 
                array("user_id" => $user_id)
        );
        $listing_limitation = $this->member_obj->get_user_property_listing_limit($user_id);
        $this->property_obj->filter_listing($filter_struct);
        $available_listing = $this->property_obj->get_return_data_set();
        return $available_listing["data"]["count"] < $listing_limitation;
    }
    public function activate_listing($ref_tag, $user_id, $activate)
    {
        if($activate === TRUE)
        {
           if($this->is_listing_available($user_id))
           {
               
           }
        }
        
    }
}

?>
