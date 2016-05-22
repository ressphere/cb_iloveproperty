<?php

/**
 * Description this function class is created to allow user to activate and deactivate 
 * existing listing
 *
 * @author Tan Chun Mun
 */

define("PROPERTY_PHOTO_DIR", dirname(dirname(dirname(dirname(__DIR__)))) . "/client_views/properties_views/assets/images/properties");
class garbage_collector extends CI_Controller {
    const expire_duration = 1;
    
    
    public function __construct() {
        parent::__construct();
        $this->load->helper("url"); 
        $this->load->library("extemplate");
        $this->load->library("session");
        $this->load->library("email");
	
    }
    private function get_meaningful_type_name($type)
    {
        switch ($type)
        {
            case "send_prop_request":
                return "[Property Enquiry]";
        }
    }
    private function _send_email($type, $email, &$data)
    {
        $website_name = $this->config->item('website_name');
        $webmaster_email = $this->config->item('webmaster_email');
        
       //$CI =& get_instance();
        //$CI->load->library('email');
        $this->email->from($webmaster_email, $website_name);
        $this->email->reply_to($webmaster_email, $website_name);
        $this->email->to($email);
        $this->email->subject($this->get_meaningful_type_name($type) . " " . $website_name);
        $this->email->message($this->load->view('_email/'.$type.'-html', $data, TRUE));
        $this->email->set_alt_message($this->load->view('_email/'.$type.'-txt', $data, TRUE));
        $status = $this->email->send();
        if($status)
        {
              return TRUE;
        }
        else
        {
              $this->set_error($this->email->print_debugger());
              return FALSE;
        }

    }
    public function remove_unlink_photo()
    {
        $this->load->model('property_photo_model');
        $photo_lists = $this->property_photo_model->find_all();
       
        if(is_dir(PROPERTY_PHOTO_DIR))
        {
            foreach(glob(PROPERTY_PHOTO_DIR.'/*.*') as $file) {
                $filename =  basename($file);
                foreach($photo_lists as $photo)
                {
                    if(strrpos($photo.path, $filename) === FALSE)
                    {
                        unlink($file);
                    } 
                }
            }
        }
        else
        {
            echo PROPERTY_PHOTO_DIR . " does not exists";
        }
//        
    }
    
    public function deactivate_expired_listing()
    {
        $this->load->model('properties_listing_model');
        $this->load->model('users_model');
        
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
                        $user = $this->users_model->find_one(array('id'=>$activated_list->user_id));
                        echo $activated_list->ref_tag . " is deactivated \n";
                        
                        $data['ref_tag'] = $activated_list->ref_tag;
                        $this->_send_email('deactivation', $user['email'], $data);
                        echo "Notification sent to " . $user['email'];
                    }
                }
        }
    }
   
}

?>
