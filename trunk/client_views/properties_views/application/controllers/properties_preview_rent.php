<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'properties_base.php';
class properties_preview_rent extends properties_base {
   
   function __construct()
   {
       // Preload necessary
        parent::__construct();
        $this->set_action("rent");
	$this->SEO_Tags("Ressphere Real Estate (Property) Preview Listing");
        $this->set_title("Ressphere Properties Listing Preview");
   }
   
   public function index()
   {
       // Preload Header and Footer
       $user_id =  $this->session->userdata('user_id');
       if ($user_id !== FALSE)
       {
           $this->allow_build_header = FALSE;
           $this->allow_build_footer = FALSE;
           parent::index();
           // Preload js and CSS script that not cover by base
           $this->page_js_css();
           $this->load_view();
      }
      else
      {
           show_404();
      }
   }
   protected function load_view()
   {
       // Page content
       $this->extemplate->write_view('contents', '_usercontrols/cb_preview_listing_info_rent',array() ,TRUE);
       $this->extemplate->render();
   }
   protected function page_js_css()
   {
       ///import for developing the doughnut chart
       $this->extemplate->add_js( "//html5shiv.googlecode.com/svn/trunk/html5.js", 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/Chart.js', 'import', FALSE, FALSE);
       
       $this->extemplate->add_js( $this->wsdl . 'js/flow.min.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/fusty-flow.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/fusty-flow-factory.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/ng-flow.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/scale.fix.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js($this->wsdl . 'js/app.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/google_map.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/turn.min.js', 'import', FALSE, FALSE);
       //Enable for special handling using js for properties home page
       $this->extemplate->add_js('js/property_facilities.js');
       $this->extemplate->add_js('js/property_details_page.js');
       $this->extemplate->add_js('js/property_preview.js');
       $this->extemplate->add_js('js/property_header.js');
       $this->extemplate->add_css(base_url() . 'css/properties_preview.css', 'link', FALSE, FALSE);
   }
   
   
}
?>

