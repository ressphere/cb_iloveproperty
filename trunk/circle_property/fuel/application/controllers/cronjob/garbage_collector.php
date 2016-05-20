<?php

/**
 * Description this function class is created to allow user to activate and deactivate 
 * existing listing
 *
 * @author Tan Chun Mun
 */
class garbage_collector extends CI_Controller {
    const expire_duration = 1;
    public function __construct() {
        parent::__construct();
        $this->load->helper("url"); 
        $this->load->library("extemplate");
        $this->load->library("session");
	
    }
    private function get_active_listing()
    {
        
        
        
        
    }
    
    public function deactivate_expired_listing()
    {
        $this->load->model('properties_listing_model');
        
        $activated_lists = $this->properties_listing_model->find_all(array('activate'=>1));
        if ( ! empty($activated_lists))
        {
                foreach ($activated_lists as $activated_list)
                {
                    
                    # last query here	
                    $current_date = new DateTime();
                    $activate_date = new DateTime($activated_list->activate_time);
                    
                    $diff = date_diff($activate_date, $current_date, TRUE);
                    $total_diff = ($diff->format('%y') * 12) + $diff->format('%m');
                    if((int)$total_diff >= self::expire_duration)
                    {
                        
                        
                        $activated_list->activate = 0;
                        $activated_list->save();
                        echo $activated_list->ref_tag . " is deactivated \n";
                    }
                }
        }
    }
   
}

?>
