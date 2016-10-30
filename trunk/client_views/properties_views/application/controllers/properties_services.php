<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'properties_base.php';
class properties_services extends properties_base {
    
   private $action = "services";
   private $content = "Ressphere Properties Home Page";
   private $title = "Ressphere Properties";
   function __construct()
   {
       // Preload necessary
        parent::__construct();
        $this->content = "Ressphere Properties Home Page";
        $this->title = "Ressphere Properties";
   }
   
   public function index()
   {
       // Preload Header and Footer
       parent::index();
       
       // Set web related info
       $this->SEO_Tags($this->content);
       $this->set_title($this->title);
           // Preload js and CSS script that not cover by base
       $this->page_js_css();
       
       $this->load_view();
   }
   ///Load view begin here and this can be override by the child
   protected function load_view()
   {
       // Page content
       $this->extemplate->write('contents', "<div>".$this->action."...</div>", TRUE);
       //$this->extemplate->write_view('contents', '_usercontrols/cb_properties_category_doughnut',array('width'=>500, 'height'=>500) ,TRUE);
       /*$this->extemplate->write_view('features', '_usercontrols/cb_features', array('feature_list'=>$this->_get_features()), TRUE);
        */
       
       // Display page
       $this->extemplate->render();
   }
   protected function page_js_css()
   {
       ///import for developing the doughnut chart
       $this->extemplate->add_js( $this->wsdl . 'js/Chart.min.js', 'import', FALSE, FALSE);
       //Enable for special handling using js for properties home page
	   $this->extemplate->add_js('js/property_detail_value.js');
       $this->extemplate->add_js('js/property_new_listing.js');
       $this->extemplate->add_js('js/property_header.js');
   }
   protected function set_action($action)
   {
       $this->action = $action;
   }
   protected function get_action()
   {
       return $this->action;
   }
   protected function set_content($content)
   {
       $this->content = $content;
   }
   protected function get_content()
   {
       return $this->content;
   }
   protected function get_title()
   {
       return $this->title;
   }
}
?>
