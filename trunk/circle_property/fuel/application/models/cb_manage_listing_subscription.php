<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of listing_subscription
 *
 * @author user
 */
class cb_manage_listing_subscription extends CI_Model {
    public function __construct()
    {
        parent::__construct();
       
    }
    
    public function check_listing_activation()
    {
         $this->db->query("CALL Trigger_On_Expired_Subscribed_Listing()");
    }
    
     
}

?>
