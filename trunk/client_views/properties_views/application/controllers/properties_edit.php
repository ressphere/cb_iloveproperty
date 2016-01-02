<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'properties_base.php';
class properties_edit extends properties_base {
private $property_info_list = NULL;
    function __construct()
   {
       // Preload necessary
        parent::__construct();
        $this->set_action("edit");
        // Set web related info fro Search Engine
        $this->SEO_Tags("Ressphere Real Estate (Property) Home Page To Edit");
        $this->set_title("Ressphere Properties To Edit");
   }
   
   public function index()
   {
       if (!array_key_exists("reference", $_GET))
       {
           show_404();
       }
       else
       {
            $user_id =  $this->session->userdata('user_id');
            if ($user_id !== FALSE)
            {
                // Preload Header and Footer
                $this->allow_build_header = TRUE;
                $this->allow_build_footer = TRUE;
                $this->set_property_info_list($_GET["reference"]);
                parent::index();
                // Preload js and CSS script that not cover by base
                $this->page_js_css();
                //fake the value here will link with db in the future to get the uique
                $reference = md5(uniqid($user_id, true));
                $this->session->set_userdata('Reference', $reference);
                $this->load_view();
            }
            else
            {
                 show_404();
            }
       }
   }
   
   protected function load_view()
   {
       // Page content
       $this->extemplate->write_view('contents', '_usercontrols/cb_edit_listing_info',array() ,TRUE);
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
       $this->extemplate->add_js('js/property_details_page.js');
       $this->extemplate->add_js('js/property_details_info.js');
       $this->extemplate->add_js('js/property_facilities.js');
       $this->extemplate->add_js('js/property_edit_listing.js');
       $this->extemplate->add_js('js/property_header.js');
       $this->extemplate->add_css(base_url() . 'css/properties_sell_buy.css', 'link', FALSE, FALSE);
   }
   
   private function set_property_info_list($ref_tag)
   { 
        $ref_param = array("ref_tag"=>$ref_tag);
        $val_return_json = GeneralFunc::CB_SendReceive_Service_Request("CB_Property:listing_detail",json_encode($ref_param));
        $val_return = json_decode($val_return_json, TRUE);
        if($val_return["status_information"] ===
                sprintf("Info: Successfully retrieve data for %s", $ref_tag) &&
           $val_return["data"]["activate"] === "1")
        {
            $this->session->set_userdata('owner_email', $val_return["data"]["email"]);
            $this->session->set_userdata('ref_tag', $ref_tag);
            $this->property_info_list = $val_return["data"];
        }
        else
        {
            $error = "Your selected property does not exist";
            show_error($this->get_listing_not_found($error), 300, "");
        }
   }
   
   public function get_property_info_list()
   {
        
        $msg = "success";
        if($this->property_info_list == NULL)
        {
            if (!array_key_exists("reference", $_GET))
            {
                $msg = "Error: no property reference is given"; 
            }
            $ref_tag = $_GET["reference"];
            $this->set_property_info_list($ref_tag);
            
        }
        $data = array("msg" => $msg, "data"=>$this->property_info_list);
        $this->_print(json_encode($data));
   }
}
?>
