<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This is the base class for all properties page
 *   - Help to add in header and footer
 *   - Provide API that is commonly used
 *
 * @author mykhor
 */

require_once '_utils/GeneralFunc.php';
require_once '_utils/measurement_type_manager.php';
require_once '_utils/currency_convertor.php';

class properties_base extends CI_Controller {
    
    /*
     * Constructor which contain
     *    - Load necessary Library
     *    - Load necessary Helper
     */
    //added wsdl as protected attribute for child class to access ressphere.com
    protected  $wsdl = NULL;
    private $action = "";
    private $content = "Ressphere Properties Home Page";
    private $title = "Ressphere Properties";
    protected $allow_build_header = true;
    protected $allow_build_footer = true;

    
    function __construct()
    {
	parent::__construct();
        $this->load->helper("url"); 
        $this->load->library("extemplate");
        $this->load->library("session");
		$this->load->library("email");
		$this->load->config('tank_auth', TRUE);
        // Load config at application/config/extemplate.php settings
        // Must be preload frist before everything related to extemplate start
        $this->extemplate->set_extemplate('default');
		$this->session->set_userdata('client_base_url', base_url());
    }
    
    
    
    //******* Page Display ******** Start ****
    /*
     * Index that require to pre-load for children class
     * if prefix header and footter required
     */
    protected function index()
    {
        
        $this->preload_js_css();
        $this->load_prefix_page();
    }
    
    
    /*
     * Preload all necessary js and CSS script
     */
    private function preload_js_css()
    {
        // Load necessary CSS
        
        $this->wsdl = $this->_get_wsdl_base_url();
        $this->session->set_userdata('wsdl_base_url', $this->wsdl);
        $this->extemplate->add_css($this->wsdl . 'css/animate.min.css', 'link', FALSE, FALSE);
        $this->extemplate->add_css($this->wsdl . 'css/bootstrap.min.css', 'link', FALSE, FALSE);
        //properties_sel_buy
        
        $this->extemplate->add_css($this->wsdl . 'css/base.css', 'link', FALSE, FALSE);
        $this->extemplate->add_css($this->wsdl . 'css/bootstrap.icon-large.min.css', 'link', FALSE, FALSE);
        $this->extemplate->add_css($this->wsdl . 'css/whhg.css', 'link', FALSE, FALSE);
        $this->extemplate->add_css('css/properties_base.css');
        $this->extemplate->add_css($this->wsdl . 'css/fuelux.css', 'link', FALSE, FALSE);
        
        
        $this->extemplate->add_js( $this->wsdl . 'js/jquery.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js( $this->wsdl . 'js/bootstrap.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl .  'js/typeahead.min.js', 'import', FALSE, FALSE);
        
        $this->extemplate->add_js('https://ajax.googleapis.com/ajax/libs/angularjs/1.2.4/angular.min.js', 'import', FALSE, FALSE);
        //$this->extemplate->add_js($this->wsdl . 'js/angular-elif.js', 'import', FALSE, FALSE);
        
        $this->extemplate->add_js( $this->wsdl . 'js/_utils/jquery.makeclass.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js( $this->wsdl . 'js/base.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js( $this->wsdl . 'js/jquery.cookie.min.js', 'import', FALSE, FALSE);
        
       
        //$this->extemplate->add_js('https://www.google.com/recaptcha/api.js', 'import', FALSE, FALSE);
	$this->extemplate->add_js('http://www.google.com/recaptcha/api/js/recaptcha_ajax.js', 'import', FALSE, FALSE);
        
        $this->extemplate->add_js($this->wsdl . 'js/lodash.compat.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/bluebird.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js('https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/angular-google-maps.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/ngAutocomplete.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/angularjs-google-places.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/jstorage.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/_datetimepicker/moment-with-locales.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/_datetimepicker/bootstrap-datetimepicker.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/_fuelux/fuelux.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/accounting.min.js', 'import', FALSE, FALSE);
        
        $this->extemplate->add_js($this->wsdl . 'js/_utils/angular-sanitize.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/_ckeditor/ckeditor.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js( 'js/property_base.js');
        $this->extemplate->add_js('js/property_header.js');
        
        
    }
    
    /*
     * Load page with extemplate
     */
    private function load_prefix_page()
    {
        // Specified author, which allow for google search
        $this->extemplate->write('author', "Ressphere developer", TRUE);
        if($this->allow_build_header)
        {
            $this->build_header();
        }
        if($this->allow_build_footer)
        {
            $this->build_footer();
        }
    }
    
    /*
     * Invoke extemplate to call specific header template
     * Thus assert it per seqence specified in config/extemplate.php
     */
    private function build_header()
    {
        $email = $this->session->userdata('username');
        $username = $this->session->userdata('displayname');
        /*******Contains the list of menu feature*******/
        $myprofileurl = $this->_get_wsdl_base_url() . 'index.php/cb_user_profile_update/my_profile';
        $newlistingurl = base_url() . 'index.php/properties_sell';
        $viewlistingurl = base_url() . 'index.php/properties_buy';
        /***************End Menu Feature***************/
        $header_content = array (
            
            'home_link' => base_url()."index.php",
            'logo'=> base_url()."images/ressphere_property_logo.png",
            'logo_desc' => "Ressphere Porperty",
  
            'help_icon_pic' => base_url()."images/ressphere_page_help.png",
            'help_icon_desc' => "help",
            'user_image' => base_url() . "images/user_profile.png",
            'username'=>$username,
            'myprofileurl'=>$myprofileurl,
            'newlistingurl'=>$newlistingurl,
            'viewlistingurl'=>$viewlistingurl

        );
        $this->extemplate->write_view('header', '_usercontrols/properties_header', $header_content, TRUE);
    }
    
    /*
     * Invoke extemplate to call specific footer template
     * Thus assert it per seqence specified in config/extemplate.php
     */
    private function build_footer()
    {
        // #Todo - Change this to database storing
        $footers["Sitemap"] = base_url();
        $footers["About Us"] = $this->_get_wsdl_base_url() . '#about';
        $footers["Contact Us"] = $this->_get_wsdl_base_url() . '#contact';
        
        // Build array data for template
         $footer_content = array (
          'copyright' => "Copyright &copy; " . date("Y") ." Ressphere. All right reserved",
          'footer_link' => $footers,
        );
        $this->extemplate->write_view('footer', '_usercontrols/properties_footer', $footer_content, TRUE);
    }
    
    
    /*
     * Set SEO data for google search
     * 
     * @Param   String  String for SEO
     */
    protected function SEO_Tags($content)
    {
        $this->set_meta_desc($content);
        $this->set_meta_keywords($content);
        $this->set_meta_generator($content);
        $this->set_og_description($content);
        $this->set_og_image(sprintf('%simages/ressphere_property_logo.png', base_url()));
        $this->set_og_title($content);
    }
    
    protected function set_meta_desc($content)
    {
        $this->extemplate->write('metadesc', $content);
    }
    
    protected function set_meta_keywords($content)
    {
        $this->extemplate->write('metakey', $content);
    }
    
    protected function set_meta_generator($content)
    {
        $this->extemplate->write('generator', $content);
    }
    
    protected function set_og_image($image_url)
    {
        $this->extemplate->write('og_image', $image_url);
    }
    
    protected function set_og_title($title)
    {
        $this->extemplate->write('og_title', $title);
    }
    
    protected function set_og_description($description)
    {
        $this->extemplate->write('og_desc', $description);
    }
    //******* Page Display ******** End ****
    
    //******* URL Related ******** Start ****
    /*
     * Get base URL
     * 
     * @Return  String  Base URL
     */
    private function _base_url()
    {
        $protocol = "http";
        return $protocol . "://" . $_SERVER['HTTP_HOST'];
    }
    
    /*
     * Get Ressphere Web service url
     * 
     * @Return  String  Ressphere WSDL base url
     */
    protected function _get_wsdl_base_url()
    {
        $val_return = GeneralFunc::CB_Receive_Service_Request("CB_Info:base_url");
        $wsdl_base_url = json_decode($val_return, TRUE);
        $wsdl_base_url  = $wsdl_base_url["data"]["result"];
        return $wsdl_base_url;
    }
    //******* URL Related ******** End ****
    
    //******* Common API ******** Start ****
    /*
     * Obtain specific value from _POST
     * 
     * @Param   String  Key that hope to retrieve from _POST
     * @Return  Value   NULL if not found, else reutrn value
     */
    protected function _get_posted_value($key)
    {
        if(isset($_POST[$key]))
        {
            return $_POST[$key];
        }
        else
        {
            return NULL;
        }
    }
    
    /*
     * Return Value if key exist in Array, else NULL
     * 
     * @Param   Array   Array that will be search
     * @Param   String  Keys value that wish to perform check
     * @Return  Value   NULL or value if key hit  
     */
    protected function _get_array_value($array, $key)
    {
        if(array_key_exists($key, $array))
        {
            return $array[$key];
        }
        return NULL;
    }
    
    /*
      * API for cross browser to perform "echo" function
      * 
      * @Param Sting
      * @Return None
      */
    protected function _print ($msg) 
    {
        $headers = headers_list();
        if(array_search('Access-Control-Allow-Origin: *', $headers) === FALSE)
        {
            header('Access-Control-Allow-Origin: *');
        }
        if(array_search('Access-Control-Allow-Methods: GET, POST', $headers)  === FALSE)
        {
            header('Access-Control-Allow-Methods: GET, POST');
        }
        if(is_string ( $msg ) == FALSE)
        {
            echo json_encode($msg);
        }
        else 
        {
            echo $msg;
        }
    }
    protected function _is_login( $activated = TRUE)
     {
        return  $this->session->userdata('status') === ($activated ? TRUE : FALSE);
     }
     protected function _get_user_id()
     {
        return $this->session->userdata('user_id');
     }
     protected function _get_username()
     {
        return $this->session->userdata('username');
     }
     protected function set_action($action)
    {
       $this->action = $action;
       $this->session->set_userdata("action", $this->action);
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
       
    public function get_current_action()
    {
         $user_action =  $this->session->userdata('action');
         $this->_print($user_action);
    } 
    /*
     * Set web page title
     * 
     * @Param   String  Page title
     */
    protected function set_title($title)
    {
        $this->title = $title;
        $this->extemplate->write('title', $title);
    }
    
    protected function get_title()
    {
       return $this->title;
    }
    private function get_image_resource_by_type($type, $filename)
    {
        switch($type)
        {
            case IMAGETYPE_GIF:
                return imagecreatefromgif($filename);
            case IMAGETYPE_JPEG:
            case IMAGETYPE_JPEG2000:
                return imagecreatefromjpeg($filename);
            case IMAGETYPE_PNG:
                return imagecreatefrompng($filename);
            case IMAGETYPE_BMP:
                return imagecreatefromwbmp($filename);
            default:
                return NULL;
        }
    }
    protected function set_watermark($img_path)
    {
        // Load the stamp and the photo to apply the watermark to
        $watermark_path = dirname(dirname(dirname(__FILE__))) . 
                DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR .
                'ressphere_property_logo.png';
        $stamp = NULL;
        $im = NULL;
        
        list($width, $height, $type, $attr) = getimagesize($img_path);
        list($stamp_width, $stamp_height, $stamp_type, $stamp_attr) = getimagesize($watermark_path);
        if(file_exists($watermark_path))
        {
            $stamp = $this->get_image_resource_by_type($stamp_type, $watermark_path);
        }
        else
        {
            $this->set_error("[NOT FOUND]Watermark image: " .  $watermark_path);
            return FALSE;
        }
        
        if(file_exists($img_path))
        {
            $im = $this->get_image_resource_by_type($type, $img_path);
        }
        else
        {
            $this->set_error("[NOT FOUND]Targeted image: " .  $img_path);
            return FALSE;
        }
        

        // Set the margins for the stamp and get the height/width of the stamp image
        if($im === NULL || $stamp === NULL)
        {
            return FALSE;
        }
        else
        {        
            $left = ($width - $stamp_width)/2;
            $top =  ($height - $stamp_height)/2;
            // Copy the stamp image onto our photo using the margin offsets and the photo 
            // width to calculate positioning of the stamp. 
            try{
                if(!imagecopy($im, $stamp, $left, $top, 0, 0, imagesx($stamp), imagesy($stamp)))
                {
                    $this->set_error("[FAIL] Watermark image");
                    return FALSE;
                }
            }
            catch (Exception $e) {  
                  $this->set_error($e->getMessage());
            }

            // Output and free memory
            imagepng($im, $img_path, 9);
            imagedestroy($im);
            imagedestroy($stamp);
            return TRUE;
        }
    }
    private function get_state_by_country(&$states , $country)
    {
         $filter_struct = array();
         $filter_struct["filter"]["country"] = $country; 
        //$val_return = GeneralFunc::CB_Receive_Service_Request("CB_Info:base_url");
        $val_return_detail = 
                GeneralFunc::CB_SendReceive_Service_Request("CB_Property:get_country_state",
                        json_encode($filter_struct));
        $val_return_detail_array = json_decode($val_return_detail, true);

        foreach($val_return_detail_array["data"]["state_country"] as $state_country)
        {
            array_push($states, $state_country["state"]);
        }
    }
    public function get_states()
    {
        $listing = $this->_get_posted_value("country_name");
        $states = array();
        if($listing)
        {
            $country = json_decode($listing, TRUE);
            $this->get_state_by_country($states, $country);
        }
        $this->_print($states);
        
    }
    public function get_property_reference()
    {
        $ref = $this->session->userdata('Reference');
        $this->_print(json_encode($ref));
    }
    protected function set_error($error_string)
    {
        ob_start();
        var_dump($error_string);
        $output = ob_get_clean();
        $error_string = date("H:i:s") . " : " . $output;
        $log_location =  $log_location = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "logs".
                DIRECTORY_SEPARATOR . date("Ymd"). ".log";
        error_log($error_string ."\n", 3, $log_location);
    }
    
    protected function _check_recaptcha($website_name,$response_field, $challenge_field)
    {
        
        $captcha_code["remote_addr"] = $website_name; 
        $captcha_code["challenge_field"] = $challenge_field;
        $captcha_code["response_field"] = $response_field;


        $val_return_json = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:check_recaptcha", json_encode($captcha_code));
        $val_return = json_decode($val_return_json, TRUE);
        
        return   $val_return["data"]["result"];
    }
    private function get_meaningful_type_name($type)
    {
        switch ($type)
        {
            case "send_prop_request":
                return "[Property Enquiry]";
        }
    }
    protected function _send_email($type, $email, &$data)
        {
                //$config['website_name'] = 'ressphere.com';
                //$config['webmaster_email'] = 'admin@ressphere.com';
            
                $this->load->library('email');
                $website_name = $this->config->item('website_name');
                $webmaster_email = $this->config->item('webmaster_email');
               //$CI =& get_instance();
                //$CI->load->library('email');
                $this->email->from($webmaster_email, $website_name);
                $this->email->reply_to($webmaster_email, $website_name);
                $this->email->to($email);
                $this->email->subject($this->get_meaningful_type_name($type) . " " . $website_name);
                $this->email->message($this->load->view('_email/'.$type.'-html', $data, TRUE));
                $this->email->set_alt_message($this->load->view('_email/'.$type.'-txt', $data, TRUE));
                $status = $this->email->send();
                if($status)
                {
                      return TRUE;
                }
                else
                {
                      $this->set_error($this->email->print_debugger());
                      return FALSE;
                }

        }
    protected function get_measurement_type_enum($measurement_type)
    {
        return MeasurementFactory::get_measurement_type_enum($measurement_type);
    }
    protected function size_unit_converter_to_any($unit_value ,$from_unit_type, $to_any_type)
    {
        $MeasurementFactoryObj = MeasurementFactory::build($from_unit_type);
        try
        {
            return $MeasurementFactoryObj->get_result($to_any_type, $unit_value);
        }
        catch (Exception $e) {
            $this->set_error("Invalid unit type: " . $from_unit_type);
            $this->set_error($e);
            return FALSE;
        }
    }
    
    protected function get_currency_type_enum($current_currency)
    {
        return CurrencyFactory::get_currency_type_enum($current_currency);
    }
    protected function get_currency_type_string($currency_enum)
    {
        return CurrencyFactory::get_currency_type_string($currency_enum);
    }
    protected function currency_converter_to_any($value ,$from, $to)
    {
        $CurrencyFactoryObj = CurrencyFactory::build($from);
        try
        {
            return $CurrencyFactoryObj->get_result($to, $value);
        }
        catch (Exception $e) {
            $this->set_error("Invalid unit type: " . $from);
            $this->set_error($e);
            return FALSE;
        }
    }
    protected function get_page404($error)
    {
            $title = "404 Page Not Found";
            
            $wsdl = $this->_get_wsdl_base_url();
            
            $this->extemplate->set_extemplate('page404_home');
            #$this->SEO_Tags($content);
            //$this->extemplate->write('title', $title);
            $this->extemplate->add_js($wsdl . 'js/jquery.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($wsdl . 'js/bootstrap.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($wsdl . 'js/jquery.easing.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_css($wsdl . 'css/bootstrap.min.css', 'link', FALSE, FALSE);
            $this->extemplate->add_css($wsdl . 'css/404.css', 'link', FALSE, FALSE);
            
            //cb_change_profile
            $this->extemplate->write_view('content', '_usercontrols/cb_404_page',array(
                'reason'=>$error,
                'img404'=>$wsdl.'images/404img.svg',
                'homepage'=>base_url(),
                'contactus'=>$wsdl.'#contact_us',
                'title'=>$title,
            ) ,TRUE);
            $output = $this->extemplate->render(NULL, TRUE);
            return $output;
    }
    
    protected function get_page403($error, $nav)
    {
            $title = "403 Forbidden";
            
            $wsdl = $this->_get_wsdl_base_url();
            
            $this->extemplate->set_extemplate('page403_home');
            #$this->SEO_Tags($content);
            //$this->extemplate->write('title', $title);
            $this->extemplate->add_js($wsdl . 'js/jquery.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($wsdl . 'js/bootstrap.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($wsdl . 'js/jquery.easing.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($wsdl . "js/jstorage.min.js", "import", FALSE, FALSE);
             $this->extemplate->add_js($wsdl . 'js/page-403.js', 'import', FALSE, FALSE);
            $this->extemplate->add_css($wsdl . 'css/bootstrap.min.css', 'link', FALSE, FALSE);
            $this->extemplate->add_css($wsdl . 'css/404.css', 'link', FALSE, FALSE);
            
            //cb_change_profile
            $this->extemplate->write_view('content', '_usercontrols/cb_403_page',array(
                'reason'=>$error,
                'img403'=>$wsdl.'images/404img.svg',
                'homepage'=>base_url(),
                'contactus'=>$wsdl.'#contact_us',
                'title'=>$title,
                'nav'=>$nav
            ) ,TRUE);
            $output = $this->extemplate->render(NULL, TRUE);
            return $output;
    }
    protected function get_listing_not_found($error)
    {
            $title = "Selected Property Not Found";
            
            $wsdl = $this->_get_wsdl_base_url();
            $img = base_url() . 'images/listing-delete.png';
            $this->extemplate->set_extemplate('page404_home');
            #$this->SEO_Tags($content);
            //$this->extemplate->write('title', $title);
            $this->extemplate->add_js($wsdl . 'js/jquery.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($wsdl . 'js/bootstrap.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($wsdl . 'js/jquery.easing.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js('js/property_lost.js');
            $this->extemplate->add_css($wsdl . 'css/bootstrap.min.css', 'link', FALSE, FALSE);
            $this->extemplate->add_css($wsdl . 'css/404.css', 'link', FALSE, FALSE);
            
            //cb_change_profile
            $this->extemplate->write_view('content', '_usercontrols/cb_listing_not_found',array(
                'reason'=>$error,
                'img404'=>$img,
                'title'=>$title
            ) ,TRUE);
            $output = $this->extemplate->render(NULL, TRUE);
            return $output;
    }
    
    protected function get_upload_limit_reached($error)
    {
            $title = "Unable to upload listing";
            
            $wsdl = $this->_get_wsdl_base_url();
            $img = base_url() . 'images/posting-limit.png';
            $this->extemplate->set_extemplate('page404_home');
            #$this->SEO_Tags($content);
            //$this->extemplate->write('title', $title);
            $this->extemplate->add_js($wsdl . 'js/jquery.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($wsdl . 'js/bootstrap.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($wsdl . 'js/jquery.easing.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js('js/property_upload_reached_limit.js');
            $this->extemplate->add_css($wsdl . 'css/bootstrap.min.css', 'link', FALSE, FALSE);
            $this->extemplate->add_css($wsdl . 'css/404.css', 'link', FALSE, FALSE);
            
            //cb_change_profile
            $this->extemplate->write_view('content', '_usercontrols/cb_upload_reached_limit',array(
                'reason'=>$error,
                'img404'=>$img,
                'title'=>$title
            ) ,TRUE);
            $output = $this->extemplate->render(NULL, TRUE);
            return $output;
    }
    //******* Common API ******** End ****
}

?>