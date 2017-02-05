<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'aroundyou_base.php'; // Include base class

/*
 * Main class for home page
 */
class aroundyou_home extends aroundyou_base {
   function __construct()
   {
       // Preload necessary
        parent::__construct();
   }
   
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
       
       $this->extemplate->write_view('contents', '_usercontrols/cb_aroundyou_main',array('width'=>500, 'height'=>500) ,TRUE);
       /*$this->extemplate->write_view('features', '_usercontrols/cb_features', array('feature_list'=>$this->_get_features()), TRUE);
        */
       
       // Display page
       $this->extemplate->render();
   }
   
   /*
    * Preload js and CSS script that not cover by base
    */
   private function page_js_css()
   {   
       ///import for developing the doughnut chart
       $this->extemplate->add_js( $this->wsdl_url . 'js/Chart.js', 'import', FALSE, FALSE);
       //Enable for special handling using js for aroundyou home page
       $this->extemplate->add_js('js/aroundyou_main_page.js');
       
   }
   public function check_userdata()
   {
         $all_data = $this->session->all_userdata();
         var_dump($all_data);
   }
}
?>
