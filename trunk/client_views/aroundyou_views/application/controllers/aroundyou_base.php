<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This is the base class for all properties page
 *   - Help to add in header and footer
 *   - Provide API that is commonly used
 *
 * @author mykhor
 */

require_once '_utils/GeneralFunc.php'; // Used to call service for CB

class aroundyou_base extends CI_Controller {
    
    // ****** Settings list ***** Start ****
    protected $allow_build_header = true; // Decide header need to print out or not
    protected $allow_build_footer = true; // Devide footer need to print out or not
    
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
        $this->wsdl_url = $this->_get_wsdl_base_url();
        $this->session->set_userdata('wsdl_base_url', $this->wsdl_url);
    }
    
    /*
     * Load necessary item for children class.
     * Intent to cut off unecessary repeat items for all children class
     */
    protected function index()
    {
        $this->preload_js_css();    // Load all necessary js and css
        $this->load_prefix_page();  // Load all prefix (header/footer)
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
        $this->extemplate->add_js( $this->wsdl_url . 'js/jquery.min.js', 'import', FALSE, FALSE); // Basic 
        $this->extemplate->add_js( $this->wsdl_url . 'js/bootstrap.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl_url .  'js/typeahead.min.js', 'import', FALSE, FALSE);
        
        $this->extemplate->add_js($this->wsdl_url . 'js/angular.min.js', 'import', FALSE, FALSE);
        //$this->extemplate->add_js($this->wsdl_url . 'js/angular-elif.js', 'import', FALSE, FALSE);
        
        $this->extemplate->add_js( $this->wsdl_url . 'js/_utils/jquery.makeclass.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js( $this->wsdl_url . 'js/base.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js( $this->wsdl_url . 'js/jquery.cookie.min.js', 'import', FALSE, FALSE);
       
       
        //$this->extemplate->add_js('https://www.google.com/recaptcha/api.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js('http://www.google.com/recaptcha/api/js/recaptcha_ajax.js', 'import', FALSE, FALSE);
        
        $this->extemplate->add_js($this->wsdl_url . 'js/lodash.compat.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl_url . 'js/bluebird.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js('https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl_url . 'js/angular-google-maps.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl_url . 'js/ngAutocomplete.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl_url . 'js/angularjs-google-places.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl_url . 'js/jstorage.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl_url . 'js/_datetimepicker/moment-with-locales.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl_url . 'js/_datetimepicker/bootstrap-datetimepicker.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl_url . 'js/_fuelux/fuelux.min.js', 'import', FALSE, FALSE);  // Extension of all interactive (eg. button) for easy support, must load after bootstrap js (http://getfuelux.com/index.html)
        $this->extemplate->add_js($this->wsdl_url . 'js/accounting.min.js', 'import', FALSE, FALSE);
        
        $this->extemplate->add_js($this->wsdl_url . 'js/_utils/angular-sanitize.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl_url . 'js/_ckeditor/ckeditor.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js( 'js/aroundyou_base.js');
        $this->extemplate->add_js('js/aroundyou_header.js');
        
        // Load necessary JS -- End
        
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
        $username = $this->session->userdata('displayname');
        /*******Contains the list of menu feature*******/
        $myprofileurl = $this->wsdl_url . 'index.php/cb_user_profile_update/my_profile';
        $newlistingurl = base_url() . 'index.php/aroundyou_sell';
        $viewlistingurl = base_url() . 'index.php/aroundyou_buy';
        /***************End Menu Feature***************/
        $header_content = array (
            
            'home_link' => base_url()."index.php",
            'logo'=> base_url()."images/ressphere_aroundyou_logo.png",
            'logo_desc' => "Ressphere Porperty",
  
            'help_icon_pic' => base_url()."images/ressphere_page_help.png",
            'help_icon_desc' => "help",
            'user_image' => base_url() . "images/user_profile.png",
            'username'=>$username,
            'myprofileurl'=>$myprofileurl,
            'newlistingurl'=>$newlistingurl,
            'viewlistingurl'=>$viewlistingurl

        );
        $this->extemplate->write_view('header', '_usercontrols/aroundyou_header', $header_content, TRUE);
    }
    
    /*
     * Invoke extemplate to call specific footer template
     * Thus assert it per seqence specified in config/extemplate.php
     */
    private function build_footer()
    {
        // #Todo - Change this to database storing
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
     * Get Ressphere Web service url
     * 
     * @Return  String  Ressphere WSDL base url
     */
    protected function _get_wsdl_base_url()
    {
        $val_return = GeneralFunc::CB_Receive_Service_Request("CB_Info:base_url");
        $wsdl_base_url = json_decode($val_return, TRUE)["data"]["result"];
        
        return $wsdl_base_url;
    }
    
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
    
    /* Use this to store/get session data for action
     *
     */
    protected function set_action($action)
    {
       $this->action = $action;
       $this->session->set_userdata("action", $this->action);
    }
    protected function get_action()
    {
       return $this->action;
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
    private function setWatermarkPositionToCenter($im, $fontSize, $degree, $y, $color, $strokecolor, $font, $txt)
    {
    
        $bbox = imagettfbbox($fontSize, $degree, $font, $txt);
        $centerX = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
        // Add some shadow to the name
        $this->imagettfstroketext($im, $fontSize, $degree, $centerX, $y, $color, $strokecolor, $font, $txt, 2);
        
        
    }
    private function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {

        for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
            for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
                imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);

        return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
    }
    protected function set_customized_watermark($img_path)
    {
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('displayname');
        $current_time = date('H:i:s', time());
        $tempDir = dirname(dirname(dirname(dirname(__DIR__)))) .
                        DIRECTORY_SEPARATOR . 'temp' . 
                        DIRECTORY_SEPARATOR . 'images' . 
                    DIRECTORY_SEPARATOR . $user_id;
        $fontStyle = dirname(dirname(dirname(dirname(__DIR__)))) . DIRECTORY_SEPARATOR . 
                "fonts" . DIRECTORY_SEPARATOR . "GOTHIC.TTF";
        
        $ext = "png";
        $user["user_id"] = $user_id;
        $phone_return_val = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:get_user_phone_number",
                        json_encode($user));
        $phone = json_decode($phone_return_val, TRUE)["data"]["result"];
        $watermark_file_name = sha1($name . $phone . $current_time);
        
        $watermark_path = $tempDir. DIRECTORY_SEPARATOR . $watermark_file_name . "." . $ext;
        
        // Set the content-type
        

        // Create the image
        $im = imagecreatetruecolor(800, 200);
        
        $trans_colour = imagecolorallocatealpha($im, 0, 0, 0, 127);
        imagefill($im, 0, 0, $trans_colour);
        imagesavealpha($im, TRUE);
        
        $grey = imagecolorallocatealpha($im, 128, 128, 128, 50);//imagecolorallocate($im, 128, 128, 128);
        //$black = imagecolorallocatealpha($im, 0, 0, 0, 60);//imagecolorallocate($im, 0, 0, 0);
        $white = imagecolorallocatealpha($im, 255, 255, 255, 60);
        
        // Replace path by your own font path
        $font = $fontStyle;
        //$this->setWatermarkPositionToCenter($im, 20, 0, 21, $grey, $black, $font, $name);
        //$this->setWatermarkPositionToCenter($im, 22, 0, 20, $black, $font, $name);
        $this->setWatermarkPositionToCenter($im, 20, 0, 20, $white, $grey, $font, $name);
        
        
        //$this->setWatermarkPositionToCenter($im, 18, 0, 51, $grey, $black, $font, $phone);
        //$this->setWatermarkPositionToCenter($im, 19, 0, 50, $black, $font, $phone);
        $this->setWatermarkPositionToCenter($im, 18, 0, 50, $white, $grey, $font, $phone);
        
        
        // Using imagepng() results in clearer text compared with imagejpeg()
        imagepng($im, $watermark_path);
        imagedestroy($im);
        $this->set_watermark($img_path, $watermark_path);
        unlink($watermark_path);
    }
    
    protected function set_default_watermark($img_path)
    {
        // Load the stamp and the photo to apply the watermark to
        $watermark_path = dirname(dirname(dirname(__FILE__))) . 
                DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR .
                'ressphere_aroundyou_logo.png';
        set_watermark($img_path, $watermark_path);
    }
    
    protected function set_watermark($img_path, $watermark_path)
    {
        $stamp = NULL;
        $im = NULL;
       
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
            list($width, $height, $type, $attr) = getimagesize($img_path);
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
                imagealphablending($stamp, true);
                imagesavealpha($stamp, true);
                
                imagealphablending($im, true);
                imagesavealpha($im, true);
                if(!imagecopy($im, $stamp, $left, $top, 0, 0, imagesx($stamp), imagesy($stamp)))
                {
                    $this->set_error("[FAIL] Watermark image");
                    return FALSE;
                }
            }
            catch (Exception $e) {  
                  $this->set_error($e->getMessage());
            }
            
            imagealphablending($im, false);
            imagesavealpha($im, true);
            // Output and free memory
            imagepng($im, $img_path, 9);
            imagedestroy($im);
            imagedestroy($stamp);
            
            return TRUE;
        }
    }
    
    
    private function get_state_by_country(&$states , $country)
    {
        /*
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
        
         */
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
    /*
    public function get_property_reference()
    {
        $ref = $this->session->userdata('Reference');
        $this->_print(json_encode($ref));
    }
     
     */
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
         $argument = json_encode(array(
                "currency"=>$current_currency
            ));
        $val_return = $this->SendReceive_Service("CB_Currency:get_currency_type_enum",
                $argument);
        return json_decode($val_return, TRUE)['data']['result'];
    }
    protected function get_currency_type_string($currency_enum)
    {
        $argument = json_encode(array(
                "currency"=>$currency_enum
            ));
        $val_return = $this->SendReceive_Service("CB_Currency:get_currency_type_string",
                $argument);
        return json_decode($val_return, TRUE)['data']['result'];
    }
    protected function currency_converter_to_any($value ,$from, $to)
    {
         $argument = json_encode(array(
                "value"=>$value,
                "from"=>$from,
                "to"=>$to
            ));
        $val_return = $this->SendReceive_Service("CB_Currency:currency_converter_to_any",
                $argument);
        return json_decode($val_return, TRUE)['data']['result'];
    }
    protected function get_page404($error)
    {
            $title = "404 Page Not Found";
            
            $this->extemplate->set_extemplate('page404_home');
            #$this->SEO_Tags($content);
            //$this->extemplate->write('title', $title);
            $this->extemplate->add_js($this->wsdl_url . 'js/jquery.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl_url . 'js/bootstrap.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl_url . 'js/jquery.easing.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_css($this->wsdl_url . 'css/bootstrap.min.css', 'link', FALSE, FALSE);
            $this->extemplate->add_css($this->wsdl_url . 'css/404.css', 'link', FALSE, FALSE);
            
            //cb_change_profile
            $this->extemplate->write_view('content', '_usercontrols/cb_404_page',array(
                'reason'=>$error,
                'img404'=>$this->wsdl_url.'images/404img.svg',
                'homepage'=>base_url(),
                'contactus'=>$this->wsdl_url.'#contact',
                'title'=>$title,
            ) ,TRUE);
            $output = $this->extemplate->render(NULL, TRUE);
            return $output;
    }
    
    protected function get_page403($error, $nav)
    {
            $title = "403 Forbidden";
            
            $this->extemplate->set_extemplate('page403_home');
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
            $this->extemplate->write_view('content', '_usercontrols/cb_403_page',array(
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
    
    protected function is_dir_empty($dir) {
        if (!is_readable($dir))
        {
            return NULL;
        }
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) 
        {
            if ($entry != "." && $entry != "..") 
            {
                return FALSE;
            }
        }
        return TRUE;
    }
    //******* Common API ******** End ****
}

?>
