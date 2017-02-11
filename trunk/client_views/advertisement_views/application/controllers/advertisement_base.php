<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This is the base class for all properties page
 *   - Help to add in header and footer
 *   - Provide API that is commonly used
 *
 * @author mykhor
 */

require_once '_utils/GeneralFunc.php';
class advertisement_base extends CI_Controller {
    
    /*
     * Constructor which contain
     *    - Load necessary Library
     *    - Load necessary Helper
     */
    //added wsdl as protected attribute for child class to access ressphere.com
    protected  $wsdl = NULL;
    private $action = "";
    private $content = "Ressphere Advertisement Home Page";
    private $title = "Ressphere Advertisement";
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
    
    protected function _getCorrectFormatPhone($phone_number, $country)
    {
        $country_short_name = "MY";
        $country_code = "";

        foreach ($this->countries as $key => $value)
        {
            if(strtolower($value) === strtolower($country))
            {
                $country_short_name = $key;
                break;
            }
        }

        $country_codes = $this->get_country_phone_code()['countries']['country'];

        foreach($country_codes as $country_dict)
        {
            if (strtolower($country_dict["-code"]) === strtolower($country_short_name))
            {
                $country_code = $country_dict["-phoneCode"];
            }
        }
        $real_phone_number_1 = str_replace("(", "", $phone_number);
        $real_phone_number = str_replace(")", "", $real_phone_number_1);
        $phone_number_with_cc = sprintf("%s%s",$country_code, $real_phone_number);
        return str_replace("+", "", $phone_number_with_cc);
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
        
        $this->extemplate->add_css($this->wsdl . 'css/base.css', 'link', FALSE, FALSE);
        $this->extemplate->add_css($this->wsdl . 'css/bootstrap.icon-large.min.css', 'link', FALSE, FALSE);
        $this->extemplate->add_css($this->wsdl . 'css/whhg.css', 'link', FALSE, FALSE);
        $this->extemplate->add_css('css/advertisement_base.css');
        $this->extemplate->add_css($this->wsdl . 'css/fuelux.css', 'link', FALSE, FALSE);
        
        
        $this->extemplate->add_js( $this->wsdl . 'js/jquery.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js( $this->wsdl . 'js/bootstrap.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl .  'js/typeahead.min.js', 'import', FALSE, FALSE);
        
        $this->extemplate->add_js($this->wsdl . 'js/angular.min.js', 'import', FALSE, FALSE);
        //$this->extemplate->add_js($this->wsdl . 'js/angular-elif.js', 'import', FALSE, FALSE);
        
        $this->extemplate->add_js( $this->wsdl . 'js/_utils/jquery.makeclass.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js( $this->wsdl . 'js/base.js', 'import', FALSE, FALSE);
       
        $this->extemplate->add_js('https://www.google.com/recaptcha/api.js', 'import', FALSE, FALSE);
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
        
        $this->extemplate->add_js('js/advertisement_header.js');
        
        
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
        $newlistingurl = base_url() . 'index.php/advertisement_sell';
        $viewlistingurl = base_url() . 'index.php/advertisement_buy';
        /***************End Menu Feature***************/
        $header_content = array (
            
            'home_link' => base_url()."index.php",
            'logo'=> base_url()."images/ressphere_advertisement_logo.png",
            'logo_desc' => "Ressphere Porperty",
  
            'help_icon_pic' => base_url()."images/ressphere_page_help.png",
            'help_icon_desc' => "help",
            'user_image' => base_url() . "images/user_profile.png",
            'username'=>$username,
            'myprofileurl'=>$myprofileurl,
            'newlistingurl'=>$newlistingurl,
            'viewlistingurl'=>$viewlistingurl

        );
        $this->extemplate->write_view('header', '_usercontrols/advertisement_header', $header_content, TRUE);
    }
    
    /*
     * Invoke extemplate to call specific footer template
     * Thus assert it per seqence specified in config/extemplate.php
     */
    private function build_footer()
    {
        // #Todo - Change this to database storing
        $footers["Contact Us"] = base_url();
        $footers["Sitemap"] = base_url();
        
        // Build array data for template
         $footer_content = array (
          'copyright' => "Copyright &copy; " . date("Y") ." Ressphere. All right reserved",
          'footer_link' => $footers,
        );
        $this->extemplate->write_view('footer', '_usercontrols/advertisement_footer', $footer_content, TRUE);
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
        $this->set_og_image(sprintf('%simages/ressphere-white.png', base_url()));
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
    
    protected function set_og_title($image_url)
    {
        $this->extemplate->write('og_title', $image_url);
    }
    
    protected function set_og_description($image_url)
    {
        $this->extemplate->write('og_desc', $image_url);
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
        echo $msg;
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
    
    public function set_error($error_string)
    {
        $error_string = date("H:i:s") . " : " . $error_string;
        $log_location =  $log_location = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "logs".
                DIRECTORY_SEPARATOR . date("Ymd"). ".log";
        error_log($error_string ."\n", 3, $log_location);
    }
    //******* Common API ******** End ****
}

?>
