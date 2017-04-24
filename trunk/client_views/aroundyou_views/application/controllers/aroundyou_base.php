<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This is the base class for all Around You Service page
 *   - Help to add in header and footer
 *   - Provide API that is commonly used
 *
 * @author mykhor
 */

// Request necessary PHP ---- Start ----
require_once '_utils/aroundyou_utils__GeneralFunc.php'; // Contain all the necassary API
require_once '_utils/aroundyou_utils__DataServer.php'; // Contain all API related to server
// Request necessary PHP ---- End ----

/*
 * Base class for Around You Service
 */
class aroundyou_base extends CI_Controller {
    
    // ****** Settings list ***** Start ****
    protected $allow_build_header = true; // Decide header need to print out or not
    protected $allow_build_footer = true; // Devide footer need to print out or not
    protected $allow_build_popup = true; // Devide popup need to print out or not
    
    protected $wsdl_url = NULL; //added wsdl url as protected attribute for child class to access ressphere.com
    
    private $action = ""; // To cotain session data for action
    private $title = "Ressphere Around You"; // Default value for page (on top of tap) if not included
    
    // ****** Settings list ***** End ****
    
    //******* Page Display ******** Start ****
     /*
     * Constructor which contain
     *    - Load necessary Library
     *    - Load necessary Helper
     *    - Preset necessary data
     */
    function __construct()
    {
	parent::__construct(); // Always trigger parent constructor
        
        // Load necessary libraries -- Start 
        $this->load->helper("url");         // For url retrieve and maniplation
        $this->load->library("extemplate"); // Template loading libraries
        $this->load->library("session");    // Access/retrieve information from cache
        $this->load->library("email");      // Interaction with email sending
        $this->load->config('tank_auth', TRUE); // Web athentication and user login purpose
        // Load necessary libraries -- End 
        
        // Load config at application/config/extemplate.php settings
        // Must be preload frist before everything related to extemplate start
        $this->extemplate->set_extemplate('default');
        
        // Pre-record current url into session
        $this->session->set_userdata('client_base_url', base_url());
        
        // Pre-record wsdl base url
        $this->wsdl_url = aroundyou_utils__DataServer__General::get_wsdl_base_url();
        $this->session->set_userdata('wsdl_base_url', $this->wsdl_url);
    }
    
    /*
     * Load necessary item for children class.
     * Intent to reduce unecessary repeat items/API calling for all children class
     */
    protected function index()
    {
        $this->preload_js_css();    // Load all necessary js and css
        $this->load_prefix_page();  // Load all prefix (header/footer/popup)
    }
    
    /*
     * Preload all necessary js and CSS script
     */
    protected function preload_js_css()
    {
        // Load necessary CSS from CB site-- Start
        $this->extemplate->add_css($this->wsdl_url . 'css/bootstrap.min.css', 'link', FALSE, FALSE); // Handle basic UI layout and featues
        $this->extemplate->add_css($this->wsdl_url . 'css/bootstrap.icon-large.min.css', 'link', FALSE, FALSE); // Additional Glyphicons for Bootstrap
        //$this->extemplate->add_css($this->wsdl_url . 'css/animate.min.css', 'link', FALSE, FALSE); // Handle all animation movement (https://daneden.github.io/animate.css/)
        $this->extemplate->add_css($this->wsdl_url . 'css/base.css', 'link', FALSE, FALSE); // Basic CSS for Ressphere
        $this->extemplate->add_css($this->wsdl_url . 'css/whhg.css', 'link', FALSE, FALSE); // Additional Glyphicons from WebHostingHub (http://www.webhostinghub.com/glyphs/)
        $this->extemplate->add_css($this->wsdl_url . 'css/fuelux.css', 'link', FALSE, FALSE); // Extension of all interactive (eg. button) for easy support. Must load after bootstrap css (http://getfuelux.com/index.html)
        
        // Load necessary CSS from CB site  -- End
        
        // Load necessary CSS from local site  -- Start
        $this->extemplate->add_css('css/aroundyou_base.css'); // Base CSS in local
        
        // Load necessary CSS from local site  -- End
        
        // Load necessary JS -- Start
        $this->extemplate->add_js( $this->wsdl_url . 'js/jquery.min.js', 'import', FALSE, FALSE); // Basic Jquery
        $this->extemplate->add_js( $this->wsdl_url . 'js/_utils/jquery.makeclass.min.js', 'import', FALSE, FALSE); // Basic Jquery
        $this->extemplate->add_js( $this->wsdl_url . 'js/jquery.cookie.min.js', 'import', FALSE, FALSE); // Jquery cookies support
        $this->extemplate->add_js( $this->wsdl_url . 'js/bootstrap.min.js', 'import', FALSE, FALSE); // Handle basic UI layout and featues
        $this->extemplate->add_js( $this->wsdl_url . 'js/typeahead.min.js', 'import', FALSE, FALSE); // Provide string auto completed features (https://twitter.github.io/typeahead.js/examples/)
        $this->extemplate->add_js( $this->wsdl_url . 'js/angular.min.js', 'import', FALSE, FALSE); // Provide angular capability for fast UI support (https://angularjs.org/)
        //$this->extemplate->add_js( $this->wsdl_url . 'js/angular-elif.js', 'import', FALSE, FALSE);
        
        //$this->extemplate->add_js('https://www.google.com/recaptcha/api.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js('http://www.google.com/recaptcha/api/js/recaptcha_ajax.js', 'import', FALSE, FALSE); // Support captcha to avoid script/spam/hack
        $this->extemplate->add_js($this->wsdl_url . 'js/lodash.compat.min.js', 'import', FALSE, FALSE); // Eaise the handler of array, object and etc (https://lodash.com/)
        $this->extemplate->add_js($this->wsdl_url . 'js/bluebird.min.js', 'import', FALSE, FALSE); // Error error handler/log, plus event (http://bluebirdjs.com/docs/features.html) 
        $this->extemplate->add_js($this->wsdl_url . 'js/jstorage.min.js', 'import', FALSE, FALSE); // To store data locally (http://www.jstorage.info/)
        $this->extemplate->add_js($this->wsdl_url . 'js/_datetimepicker/moment-with-locales.min.js', 'import', FALSE, FALSE); // Data and time handler, pre-requisit for bootstrap-datetimepicker (https://momentjs.com/)
        $this->extemplate->add_js($this->wsdl_url . 'js/_datetimepicker/bootstrap-datetimepicker.min.js', 'import', FALSE, FALSE); // Boostrap drop down for date/time selection (https://eonasdan.github.io/bootstrap-datetimepicker/)
        $this->extemplate->add_js($this->wsdl_url . 'js/_fuelux/fuelux.min.js', 'import', FALSE, FALSE);  // Extension of all interactive (eg. button) for easy support, must load after bootstrap js (http://getfuelux.com/index.html)
        $this->extemplate->add_js($this->wsdl_url . 'js/accounting.min.js', 'import', FALSE, FALSE); // Number and currency handler (http://openexchangerates.github.io/accounting.js/)
        
        $this->extemplate->add_js($this->wsdl_url . 'js/_utils/angular-sanitize.min.js', 'import', FALSE, FALSE); // Angular hack prevent JS (https://docs.angularjs.org/api/ngSanitize)
        $this->extemplate->add_js($this->wsdl_url . 'js/_ckeditor/ckeditor.min.js', 'import', FALSE, FALSE); // Editor for comment/formatting string (http://ckeditor.com/)
        $this->extemplate->add_js( $this->wsdl_url . 'js/base.js', 'import', TRUE, FALSE); // Ressphere base JS
        
        // For google map and auto complete
        $this->extemplate->add_js('https://maps.googleapis.com/maps/api/js?key=AIzaSyAW8rCEHK9y0-D16J2IsErCQ9rjUyuj1Cc', 'import', FALSE, FALSE); // Google map API. API key is under gmail account "Ressphere"
        $this->extemplate->add_js($this->wsdl_url . 'js/angular-google-maps.min.js', 'import', FALSE, FALSE); // Angular wrap around google map  (https://angular-ui.github.io/angular-google-maps)
        $this->extemplate->add_js($this->wsdl_url . 'js/ngAutocomplete.js', 'import', FALSE, FALSE); // Angular string auto complete
        $this->extemplate->add_js($this->wsdl_url . 'js/angularjs-google-places.js', 'import', FALSE, FALSE); // Angular auto complete on google map place
        $this->extemplate->add_js($this->wsdl_url . 'js/google_map.js', 'import', FALSE, FALSE);
        
        $this->extemplate->add_js('js/aroundyou_base.js'); // Around You Service special base JS
        $this->extemplate->add_js('js/aroundyou_header.js'); // Around You Service header JS
        
        // Load necessary JS -- End  
    }
    
    /*
     * Load the prefix layout for all page, which include
     *    - Header
     *    - Footer
     *    - Pop up
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
        if($this->allow_build_popup)
        {
            $this->build_popup();
        }
    }
    
    /*
     * Construct the header
     */
    private function build_header()
    {
        // Retrieve user through prestore data in session
        $username = $this->session->userdata('displayname');
        
        /*******Contains the list of menu feature*******/
        $myprofileurl = $this->wsdl_url . 'index.php/cb_user_profile_update/my_profile';
        //$newlistingurl = base_url() . 'index.php/aroundyou_sell';
        //$viewlistingurl = base_url() . 'index.php/aroundyou_buy';
        /***************End Menu Feature***************/
        
        // Prepare header template information
        $header_content = array (
            
            'home_link' => base_url()."index.php",
            'logo'=> base_url()."images/ressphere_aroundyou_logo.png",
            'logo_desc' => "Ressphere Around You",
  
            'help_icon_pic' => base_url()."images/ressphere_page_help.png",
            'help_icon_desc' => "help",
            'user_image' => base_url() . "images/user_profile.png",
            'username'=>$username,
            'myprofileurl'=>$myprofileurl,
            //'newlistingurl'=>$newlistingurl,
            //'viewlistingurl'=>$viewlistingurl

        );
        $this->extemplate->write_view('header', '_usercontrols/aroundyou_header', $header_content, TRUE);
    }
    
    /*
     * Construct the footer
     */
    private function build_footer()
    {
        // @Todo - Change this to database storing
        $footers["About Us"] = $this->wsdl_url . '#about';
        $footers["Contact Us"] = $this->wsdl_url . '#contact';
        $footers["Sitemap"] = base_url() . "sitemap.xml";
        
        // Build array data for template
         $footer_content = array (
          'copyright' => "Copyright &copy; " . date("Y") ." Ressphere. All right reserved",
          'footer_link' => $footers,
        );
        $this->extemplate->write_view('footer', '_usercontrols/aroundyou_footer', $footer_content, TRUE);
    }
    
    /*
     * Construct the pop up
     */
    private function build_popup()
    {
        $popup_content = array ();
        $this->extemplate->write_view('pop_up_content', '_usercontrols/aroundyou_pop_up_content', $popup_content, TRUE);
    }
    
    /*
     * Set SEO / Meta data for google search
     * 
     * @Param   String  String for SEO
     */
      protected function SEO_Tags($content)
    {
        $this->set_meta_desc($content);
        $this->set_meta_keywords($content);
        $this->set_meta_generator($content);
        $this->set_og_description($content);
        $this->set_og_image(sprintf('%simages/ressphere_aroundyou_logo.png', base_url()));
        $this->set_og_title($content);
    }
    /*social media require reset these tag, recommented to stick it together*/
    protected function set_meta_desc($content)
    {
        $this->extemplate->write('metadesc', $content);
    }
    
    /*social media require reset these tag, recommented to stick it together*/
    protected function set_meta_keywords($content)
    {
        $this->extemplate->write('metakey', $content);
    }
    
    /*social media require reset these tag, recommented to stick it together*/
    protected function set_meta_generator($content)
    {
        $this->extemplate->write('generator', $content);
    }
    
    /*social media require reset these tag, recommented to stick it together*/
    protected function set_og_image($image_url)
    {
        $this->extemplate->write('og_image', $image_url);
    }
    
    /*social media require reset these tag, recommented to stick it together*/
    protected function set_og_title($title)
    {
        $this->extemplate->write('og_title', $title);
    }
    
    /*social media require reset these tag, recommented to stick it together*/
    protected function set_og_description($description)
    {
        $this->extemplate->write('og_desc', $description);
    }
    //******* Page Display ******** End ****
    
    
    //******* Common API ******** Start ****
    /*
     * Check the login status
     * 
     * @Param Bool Determine the checking is again login or not login
     *               - TRUE, Check if login. Return TRUE if login.
     *               - FALSE, Check if not login. Return TRUE if not login.
     * 
     * @Return Bool The return is base on the param
     */
    protected function _is_login( $activated = TRUE)
    {
       return  $this->session->userdata('status') === ($activated ? TRUE : FALSE);
    }
    
    /*
     * Retrieve the user id
     * 
     * @Return Integer User ID
     */
    protected function _get_user_id()
    {
       return $this->session->userdata('user_id');
    }
    
    /*
     * Retrieve user name
     * 
     * @Return String User name
     */
    protected function _get_username()
    {
       return $this->session->userdata('username');
    }
    
    /* 
     * Store action from session data
     * 
     * @Param String Action that perfrom for current page
     */
    protected function set_action($action)
    {
       $this->action = $action;
       $this->session->set_userdata("action", $this->action);
    }
    
    /*
     * Retrieve action from current page variable
     * 
     * @Return String Action that perfrom for current page
     */
    protected function get_action()
    {
       return $this->action;
    }
    
    /*
     * Retrieve action from session data, JS gateway
     * 
     * @Return String Action that perfrom for current page
     */
    public function get_current_action()
    {
         $user_action =  $this->session->userdata('action');
         aroundyou_utils__GeneralFunc__Basic::echo_js_html($user_action);
    } 
    
    /*
     * Set web page title for template
     * 
     * @Param   String  Page title
     */
    protected function set_title($title)
    {
        $this->title = $title;
        $this->extemplate->write('title', $title);
    }
    
    /*
     *  Retrieve title name from current page variable
     * 
     *  @Return String Page title
     */
    protected function get_title()
    {
       return $this->title;
    }
    
    /*
     * Send Email to specific user
     * 
     * @Param String Predefine title header string type
     * @Param String Email 'to' address
     * @Param String Email content
     * 
     */
    protected function _send_email($type, $email, &$data)
    {
        // Load prefix data from config
        $website_name = $this->config->item('website_name');
        $webmaster_email = $this->config->item('webmaster_email');
        
        // Decide title header
        switch ($type)
        {
            case "send_au_request":
                $type = "[AroundYou Enquiry]";
            default:
                return $type;
        }
        
        // Load email library
        $this->load->library('email');
        
        // Set email detail
        $this->email->from($webmaster_email, $website_name);
        $this->email->reply_to($webmaster_email, $website_name);
        $this->email->to($email);
        $this->email->subject($this->get_meaningful_type_name($type) . " " . $website_name);
        $this->email->message($this->load->view('_email/'.$type.'-html', $data, TRUE));
        $this->email->set_alt_message($this->load->view('_email/'.$type.'-txt', $data, TRUE));
        
        // Execute send email and return accordingly
        $status = $this->email->send();
        if($status)
        {
              return TRUE;
        }
        else
        {
              aroundyou_utils__GeneralFunc__Basic::dump_error_log($this->email->print_debugger());
              return FALSE;
        }
    }
    
    /*
     * Allow divert to 404 page with specific error message
     * 
     * @Param String Error message
     * 
     */
    protected function get_page404($error)
    {
            $title = "404 Page Not Found";
            
            $this->extemplate->set_extemplate('aroundyou_404_page');
            #$this->SEO_Tags($content);
            //$this->extemplate->write('title', $title);
            $this->extemplate->add_js($this->wsdl_url . 'js/jquery.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl_url . 'js/bootstrap.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl_url . 'js/jquery.easing.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_css($this->wsdl_url . 'css/bootstrap.min.css', 'link', FALSE, FALSE);
            $this->extemplate->add_css($this->wsdl_url . 'css/404.css', 'link', FALSE, FALSE);
            
            //cb_change_profile
            $this->extemplate->write_view('content', '_usercontrols/aroundyou_404_page',array(
                'reason'=>$error,
                'img404'=>$this->wsdl_url.'images/404img.svg',
                'homepage'=>base_url(),
                'contactus'=>$this->wsdl_url.'#contact',
                'title'=>$title,
            ) ,TRUE);
            $output = $this->extemplate->render(NULL, TRUE);
            return $output;
    }
    
    /*
     * Allow divert to 403 page with specific error and navigation link
     * 
     * @Param String Error message
     * @Param String diverted link
     */
    protected function get_page403($error, $nav)
    {
            $title = "403 Forbidden";
            
            $this->extemplate->set_extemplate('aroundyou_403_page');
            #$this->SEO_Tags($content);
            $this->extemplate->write('title', $title);
            $this->extemplate->add_js($this->wsdl_url . 'js/jquery.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl_url . 'js/bootstrap.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl_url . 'js/jquery.easing.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl_url . "js/jstorage.min.js", "import", FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl_url . 'js/page-403.js', 'import', FALSE, FALSE);
            $this->extemplate->add_css($this->wsdl_url . 'css/bootstrap.min.css', 'link', FALSE, FALSE);
            $this->extemplate->add_css($this->wsdl_url . 'css/404.css', 'link', FALSE, FALSE);
            
            //cb_change_profile
            $this->extemplate->write_view('content', '_usercontrols/aroundyou_403_page',array(
                'reason'=>$error,
                'img403'=>$this->wsdl_url.'images/403img.svg',
                'homepage'=>base_url(),
                'contactus'=>$this->wsdl_url.'#contact',
                'title'=>$title,
                'nav'=>$nav
            ) ,TRUE);
            $output = $this->extemplate->render(NULL, TRUE);
            return $output;
    }
    
    
    //******* Common API ******** End ****
}

?>
