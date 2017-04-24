<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This is the home page for the AroundYou UI
 *
 * @author mykhor
 */

// Request necessary PHP ---- Start ----
require_once 'aroundyou_base.php'; // Include base class
// Request necessary PHP ---- End ----

/*
 * Main class for home page
 */
class aroundyou_home extends aroundyou_base 
{
    
    /* 
     * Constructer
     */
    function __construct()
    {
        // Preload necessary item from parent class
         parent::__construct();
    }

    /* 
     * First entries for the home page
     */
    public function index()
    {
        // Preload Header and Footer
        parent::index();

        // Set web related info
        $content = "Ressphere Around You Home Page";
        $title = "Ressphere Around You";
        $this->SEO_Tags($content);
        $this->set_title($title);

        // Preload js and CSS script that not cover by base
        $this->page_js_css();

        // Page content
        $this->extemplate->write_view('contents', '_usercontrols/aroundyou_home',array('width'=>500, 'height'=>500) ,TRUE);
        /*$this->extemplate->write_view('features', '_usercontrols/cb_aroundyou_mainb_features', array('feature_list'=>$this->_get_features()), TRUE);
         */

        // Display page
        $this->extemplate->render();
    }

    /*
     * Preload js and CSS script that not cover by base
     */
    private function page_js_css()
    {   
        // Load necessary CSS from local site  -- Start
        $this->extemplate->add_css('css/aroundyou_home.css'); // Base CSS in local
        
        // Load necessary CSS from local site  -- End

        //Enable for special handling using js for aroundyou home page
        $this->extemplate->add_js('js/aroundyou_home_page.js');
    }
    public function check_userdata()
    {
          $all_data = $this->session->all_userdata();
          var_dump($all_data);
    }
}
?>
