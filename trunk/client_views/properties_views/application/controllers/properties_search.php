<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'properties_base.php';
class properties_search extends properties_base {
    function __construct()
   {
       // Preload necessary
        parent::__construct();
   }
   
   protected function index()
   {
       // Preload Header and Footer
       parent::index();
       
       // Include necessary JS and CSS
	   $this->extemplate->add_css($this->wsdl . 'css/_sidebar/simple-sidebar.css', 'link', FALSE, FALSE);
       $this->extemplate->add_css('css/properties_search.css');
       $this->extemplate->add_js('js/property_search.js');
       
       // Page content
       $this->extemplate->write_view('contents', '_usercontrols/cb_properties_search_structure',"" ,TRUE);
       
      
       //$this->extemplate->write('contents', "<div>".$type.$page."...</div>", TRUE);

       //$this->extemplate->write_view('contents', '_usercontrols/cb_properties_category_doughnut',array('width'=>500, 'height'=>500) ,TRUE);
       /*$this->extemplate->write_view('features', '_usercontrols/cb_features', array('feature_list'=>$this->_get_features()), TRUE);
        */
       
       // Display page
       $this->extemplate->render();
   }
   
}
?>
