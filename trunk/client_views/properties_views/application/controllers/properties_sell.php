<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'properties_base.php';
require_once '_utils/properties_upload.php';
class properties_sell extends properties_upload {
   
   function __construct()
   {
       // Preload necessary
        parent::__construct();
        $this->set_action("sale");
        // Set web related info fro Search Engine
        $this->SEO_Tags("Ressphere Real Estate (Property) Home Page To Sell");
        $this->set_title("Ressphere Properties For Sale");
        
   }
   
   public function index()
   {
       // Preload Header and Footer
       $user_id =  $this->session->userdata('user_id');
       
       if ($user_id !== FALSE)
       {
           // check point to disallow user from exceeding its listing limit
           if($this->is_user_allowed_to_create_new_listing())
           {
                parent::index();$this->session->set_userdata('secure','1');
                // Preload js and CSS script that not cover by base
                $this->page_js_css();
                //fake the value here will link with db in the future to get the uique
                $reference = md5(uniqid($user_id, true));
                $this->session->set_userdata('Reference', $reference);
                //initial current action
                $this->session->set_userdata("action", $this->get_action());
                $this->load_view();
           }
           else
           {
             show_error($this->get_upload_limit_reached("Listing limits(max:3) exceeded !!!. Please remove existing listings from your profile if you would like to create a new listing."),403,"");
           }
      }
      else
      {
            //TODO Temporary use 404 page
            show_error($this->get_page403("This page is for registered or login member. Please register or re-login.", $this->session->userdata('client_base_url')),403, "");
      }
   }
   protected function load_view()
   {
       // Page content
       $this->extemplate->write_view('contents', '_usercontrols/cb_upload_listing_info',array() ,TRUE);
       $this->extemplate->render();
   }
   protected function page_js_css()
   {
       ///import for developing the doughnut chart
       $this->extemplate->add_js( $this->wsdl . 'js/flow.min.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/fusty-flow.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/fusty-flow-factory.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/ng-flow.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/scale.fix.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js($this->wsdl . 'js/app.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/google_map.js', 'import', FALSE, FALSE);
       
       //Enable for special handling using js for properties home page
       $this->extemplate->add_js('js/property_facilities.js');
       $this->extemplate->add_js('js/property_new_listing.js');
       $this->extemplate->add_js('js/property_header.js');
       $this->extemplate->add_js('js/property_details_info.js');
       $this->extemplate->add_css(base_url() . 'css/properties_sell_buy.css', 'link', FALSE, FALSE);
   }
   
   
}
?>
