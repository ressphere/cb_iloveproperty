<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'properties_base.php';
class properties_home extends properties_base {
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
       $content = "Ressphere Properties Home Page";
       $title = "Ressphere Properties";
       $this->SEO_Tags($content);
       $this->set_title($title);
       
       // Preload js and CSS script that not cover by base
       $this->page_js_css();
       
       // Page content
       
       $this->extemplate->write_view('contents', '_usercontrols/cb_properties_category_doughnut',array('width'=>500, 'height'=>500) ,TRUE);
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
       $this->extemplate->add_js( $this->wsdl . 'js/Chart.js', 'import', FALSE, FALSE);
       //Enable for special handling using js for properties home page
       $this->extemplate->add_js('js/property_main_page.js');
       
   }
   public function check_userdata()
   {
         $all_data = $this->session->all_userdata();
         var_dump($all_data);
   }
}
?>
