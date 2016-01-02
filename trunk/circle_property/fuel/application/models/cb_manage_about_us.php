<?php
class cb_manage_about_us extends CI_Model
{
     private $about_us_data = NULL;
     function __construct()
    {
        // Call the Model constructor
        $this->about_us_data = new cb_manage_about_us_prop();
        parent::__construct();
    }
    
    function get_home_about_us($about_us = NULL)
    {
        $this->load->module_model('cb_home_about_us', 'home_about_us_model');
        
        $home_category_details = $this->home_about_us_model->query($about_us);
        
        return $home_category_details->result();
    }
}
class cb_manage_about_us_prop
{
    public $content;
}
?>
