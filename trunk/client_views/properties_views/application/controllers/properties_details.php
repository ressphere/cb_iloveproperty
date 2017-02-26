<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'properties_base.php';
require_once '_utils/GeneralFunc.php';

class properties_details extends properties_base {
   private $property_info_list = NULL;
   
   function __construct()
   {
       // Preload necessary
        parent::__construct();
        $this->load->library("session");
   }
   
   public function index()
   {
       if (!array_key_exists("reference", $_GET))
       {
           show_404();
       }
       else
       {
            
            // Preload Header and Footer
            $this->allow_build_header = TRUE;
            $this->allow_build_footer = TRUE;
            $this->set_property_info_list($_GET["reference"]);
            $this->set_social_media($this->property_info_list);
            parent::index();
            // Preload js and CSS script that not cover by base
            $this->page_js_css();
            $this->load_view(); 
       }
   }
   private function set_social_media($property_info_list)
   {
       //set the website title
       //<Propert Name> <type of transaction> at <currency><price>
       $this->set_action($property_info_list["service_type"]);
       $title = sprintf("%s - %s %s at %s%s.(%s %s %s)",$property_info_list["service_type"], 
               $property_info_list["property_name"], $property_info_list["property_type"],
               $property_info_list["currency"], $property_info_list["price"],
               $property_info_list["country"], 
               $property_info_list["state"], $property_info_list["area"]);
       $keywords = sprintf("%s %s %s", $property_info_list["country"], 
               $property_info_list["state"], $property_info_list["area"]);
       
       $description = sprintf("%s, %s, %s", $property_info_list["country"], 
               $property_info_list["state"], $property_info_list["area"]);
       
       $this->set_title($title);
       $this->set_og_title($title);
       $this->set_og_description($description);
       if(count($property_info_list["property_photo"]) > 0)
            $this->set_og_image($property_info_list["property_photo"][0]["path"]);
       
       $this->set_meta_desc($description);
       $this->set_meta_keywords($title . "<BR/>" . $keywords);
       $this->set_meta_generator($title);
               
       //$this->SEO_Tags($title);
       
   }
   private function validate_user_input($display_name, $phone, $msg, $cap, $challenge, &$fail_reason)
   {
       $result = FALSE;
       if(is_null($display_name) || $display_name === "")
       {
           $fail_reason = "Display name cannot be empty.";
       }
       elseif(is_null($phone) || $phone === "")
       {
           $fail_reason = "Phone number cannot be empty.";
       }
       elseif(is_null($msg) || $msg === "")
       {
           $fail_reason = "Message cannot be empty.";
       }
       elseif(is_null($cap) || is_null($challenge) || 
               $this->_check_recaptcha(
                         $this->config->item('website_name'),
                         $cap, str_replace("\"", "", $challenge)) === FALSE)
       {
         
         $fail_reason = "Captcha image is not match, please retype";
         //$msg =  $this->config->item('website_name');
       }
       else
       {
           $result = TRUE;
       }

       return $result;
   }
   private function begin_send_user_contact($owner_email, $owner_phone, $display_name, 
           $phone, $msg, $ref_id, &$fail_reason)
   {
      $type = "send_prop_request";
      $data['name'] = $display_name;
      $data['serial'] = $ref_id;
      $data['phone'] = $phone;
      $data['content'] = $msg;
      $data['owner_email'] = $owner_email;
      $data['url'] = base_url() . 'index.php/properties_details?reference=' . $ref_id;
      
      $status = $this->_send_email($type, $owner_email, $data);
      if($status === FALSE )
      {
          $fail_reason = "Email Failed To Send<BR>Please contact administrator";
      }
      else 
      {
          if($this->set_user_property_sms_limit() === True )
          {
            $this->_send_sms($type,$owner_phone, $data);
          }
      }
     
   }
   public function send_user_contact()
   {
       $owner_email = $this->session->userdata('owner_email');
       $owner_phone = $this->session->userdata('owner_phone');
       $ref_id = $this->session->userdata('ref_tag');
       $returned_data = array("status"=>0, "reason"=>"");
       $success_msg = "Your enquiry is sent to the owner<BR> Thank you for using the service.";
       if ($owner_email === FALSE || $ref_id === FALSE || $owner_phone === FALSE)
       {
               $fail_reason = "Your selected property is not available";
       }
       else
       {
           $display_name = $this->_get_posted_value('display_name');
           $phone = $this->_get_posted_value('phone');
           $msg = $this->_get_posted_value('msg');
          
           $cap = $this->_get_posted_value('captcha');
           $challenge = $this->_get_posted_value('challenge');
           $fail_reason = "";

           if($this->validate_user_input($display_name, $phone, $msg, $cap, $challenge, $fail_reason))
           {
                $this->begin_send_user_contact($owner_email, $owner_phone, $display_name, $phone, $msg, $ref_id, $fail_reason);
           }
           else
           {
               $returned_data["reason"] = $fail_reason;
               $returned_data["status"] = -2;
           }
         
       }
       if($fail_reason !== "" && $returned_data["status"] == 0)
       {
          $returned_data["reason"] = $fail_reason;
          $returned_data["status"] = -1;
       }
       if($returned_data["status"] == 0) 
       {
           $returned_data["reason"] = $success_msg;
       }
       $this->_print($returned_data);
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
            $this->session->set_userdata('owner_phone', $val_return["data"]["phone"]);
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
   
   public function get_converted_currency_value()
   {
       $currency_value = $this->_get_posted_value('currency_value');
       $from_currency = $this->_get_posted_value('from_currency');
       $to_currency = $this->_get_posted_value('to_currency');
       
       $argument = json_encode(array(
                "currency_value"=>$currency_value,
                "from_currency"=>$from_currency,
                "to_currency" => $to_currency
            ));
       $val_return_json = GeneralFunc::CB_SendReceive_Service_Request("CB_Currency:get_converted_currency_value", $argument);
       
       $val_return = json_decode($val_return_json, TRUE);
       $converted_currency_value = $val_return['data']['result'];
       $this->_print($converted_currency_value);
   }
   
   public function get_converted_measurement_value()
   {
       $unit_value = $this->_get_posted_value('measurement_value');
       $from_measurement_type = $this->_get_posted_value('from_measurement_type');
       $to_measurement_type = $this->_get_posted_value('to_measurement_type');
       if($unit_value && $from_measurement_type && $to_measurement_type)
       {
            $to_measurement_type_enum = $this->get_measurement_type_enum($to_measurement_type);
            $converted_measurement_value = 
                    $this->size_unit_converter_to_any($unit_value, $from_measurement_type, $to_measurement_type_enum);
            $this->_print($converted_measurement_value);
       }
       else
       {
           $this->_print("--");
       }
   }
   
   protected function load_view()
   {
       // Page content
       $this->extemplate->write_view('contents', '_usercontrols/cb_details_page',array() ,TRUE);
       $this->extemplate->render();
   }
   protected function page_js_css()
   {
       #$this->extemplate->add_js( $this->wsdl . 'js/Chart.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/flow.min.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/fusty-flow.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/fusty-flow-factory.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/ng-flow.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/scale.fix.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js($this->wsdl . 'js/app.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/google_map.js', 'import', FALSE, FALSE);
       $this->extemplate->add_js( $this->wsdl . 'js/flip.min.js', 'import', FALSE, FALSE);
       
       
       
       //Enable for special handling using js for properties home page
       $this->extemplate->add_js('js/property_detail_value.js');
       $this->extemplate->add_js('js/property_details_page.js');
       $this->extemplate->add_js('js/property_details_info.js');
       $this->extemplate->add_js('js/property_header.js');
       $this->extemplate->add_css(base_url() . 'css/properties_detail.css', 'link', FALSE, FALSE);
       
       
       
       
   }
   
   
}
?>
