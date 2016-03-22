<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of base
 *
 * @author Tan Chun Mun
 */
require_once '_utils/GeneralFunc.php';
class base extends CI_Controller {
    protected $logo = NULL;
    protected $tabs = array();
    protected $footers = array();
    protected $logo_description = NULL;
    protected $countries = NULL;
    protected $country_location = NULL;
    // <editor-fold defaultstate="collapsed" desc="constructor">
    function __construct($reload_client_url = FALSE, $CI = NULL)
    {
	parent::__construct();
        $this->load->helper("url"); 
        $this->load->library("extemplate");
        //$this->load->library("session");
        $this->load->library("session");
	$this->load->library("email");
	$this->load->config('tank_auth', TRUE);
        if($reload_client_url === TRUE)
            $this->session->set_userdata('client_base_url', base_url());
        
        $this->default_tabs_init();
        $this->default_footer_tabs_init();
        $this->logo = base_url() . "images/ressphere-white.png";
                
        $this->load_country_short_name();
        $this->load_country_location();
        
        
    }
    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="main entry in protected">
    //This index is inherited by the less of the code
    protected function index()
    {
        $loginview = $this->_loginView();
        $registerview = $this->_registerView();
        $logoutview = $this->_logoutView();
        $forgotpassview = $this->_forgotpassView();
        $changepassview = $this->_changepassView();
        $this->extemplate->set_extemplate('default');
        //Load default js/css here
        
        $this->extemplate->add_css('css/bootstrap.min.css');
        $this->extemplate->add_css('css/animate.min.css');
        $this->extemplate->add_css('css/base.css');
        $this->extemplate->add_js('js/jquery.min.js');
        $this->extemplate->add_js('js/bootstrap-mit.min.js');
        $this->extemplate->add_js('js/typeahead.min.js');
        
        $this->extemplate->add_js('js/angular.min.js');
        //$this->extemplate->add_js('js/ui-bootstrap-tpls-0.11.0.min.js');
        $this->extemplate->add_js('js/_utils/jquery.makeclass.min.js');
        $this->extemplate->add_js("js/jstorage.min.js");
        $this->extemplate->add_js('js/base.js');
        //
        
      
        $this->extemplate->write('author', "ressphere", TRUE);
        $this->extemplate->add_js('js/header.js');
        $this->extemplate->add_js('http://www.google.com/recaptcha/api/js/recaptcha_ajax.js', 'import', FALSE, FALSE);
        //$this->extemplate->add_js('js/cb_contact_us.js');
        $this->header();
        $this->footer();
        
         $this->extemplate->write('login_view', $loginview, TRUE);
       $this->extemplate->write('register_view', $registerview, TRUE);
        $this->extemplate->write('logout_view', $logoutview, TRUE);
        $this->extemplate->write('forgotpass_view', $forgotpassview, TRUE);
        $this->extemplate->write('changepass_view', $changepassview, TRUE);
        $this->session->set_userdata('secure','0');
    }
    //</editor-fold>
    
    //<editor-fold defaultstate="collapsed" desc="private section">
    private function default_tabs_init()
    {
        //$this->tabs["Home"] = $this->session->userdata('client_base_url');
        $this->tabs["Services"] = "#services";
        $this->tabs["About Us"] = "#about";
        $this->tabs["Contact Us"] = "#contact";
    }
    private function default_footer_tabs_init()
    {
        //$this->tabs["Home"] = $this->session->userdata('client_base_url');
        $this->footers["About Us"] = base_url() . '#about';
        $this->footers["Contact Us"] = base_url() . '#contact';
        $this->footers["Sitemap"] = base_url() . "sitemap.xml";
    }
    
     private function load_country_location()
   {
       $this->country_location = array(
         'MY' => [3.140307520038235, 101.6866455078125],
         'SG' => [1.352083, 103.81983600000001],
         'TH' => [15.870032, 100.99254100000007]
       );
   }
   private function load_country_short_name()
   {
        $this->countries = array
        (
                'AF' => 'Afghanistan',
                'AX' => 'Aland Islands',
                'AL' => 'Albania',
                'DZ' => 'Algeria',
                'AS' => 'American Samoa',
                'AD' => 'Andorra',
                'AO' => 'Angola',
                'AI' => 'Anguilla',
                'AQ' => 'Antarctica',
                'AG' => 'Antigua And Barbuda',
                'AR' => 'Argentina',
                'AM' => 'Armenia',
                'AW' => 'Aruba',
                'AU' => 'Australia',
                'AT' => 'Austria',
                'AZ' => 'Azerbaijan',
                'BS' => 'Bahamas',
                'BH' => 'Bahrain',
                'BD' => 'Bangladesh',
                'BB' => 'Barbados',
                'BY' => 'Belarus',
                'BE' => 'Belgium',
                'BZ' => 'Belize',
                'BJ' => 'Benin',
                'BM' => 'Bermuda',
                'BT' => 'Bhutan',
                'BO' => 'Bolivia',
                'BA' => 'Bosnia And Herzegovina',
                'BW' => 'Botswana',
                'BV' => 'Bouvet Island',
                'BR' => 'Brazil',
                'IO' => 'British Indian Ocean Territory',
                'BN' => 'Brunei Darussalam',
                'BG' => 'Bulgaria',
                'BF' => 'Burkina Faso',
                'BI' => 'Burundi',
                'KH' => 'Cambodia',
                'CM' => 'Cameroon',
                'CA' => 'Canada',
                'CV' => 'Cape Verde',
                'KY' => 'Cayman Islands',
                'CF' => 'Central African Republic',
                'TD' => 'Chad',
                'CL' => 'Chile',
                'CN' => 'China',
                'CX' => 'Christmas Island',
                'CC' => 'Cocos (Keeling) Islands',
                'CO' => 'Colombia',
                'KM' => 'Comoros',
                'CG' => 'Congo',
                'CD' => 'Congo, Democratic Republic',
                'CK' => 'Cook Islands',
                'CR' => 'Costa Rica',
                'CI' => 'Cote D\'Ivoire',
                'HR' => 'Croatia',
                'CU' => 'Cuba',
                'CY' => 'Cyprus',
                'CZ' => 'Czech Republic',
                'DK' => 'Denmark',
                'DJ' => 'Djibouti',
                'DM' => 'Dominica',
                'DO' => 'Dominican Republic',
                'EC' => 'Ecuador',
                'EG' => 'Egypt',
                'SV' => 'El Salvador',
                'GQ' => 'Equatorial Guinea',
                'ER' => 'Eritrea',
                'EE' => 'Estonia',
                'ET' => 'Ethiopia',
                'FK' => 'Falkland Islands (Malvinas)',
                'FO' => 'Faroe Islands',
                'FJ' => 'Fiji',
                'FI' => 'Finland',
                'FR' => 'France',
                'GF' => 'French Guiana',
                'PF' => 'French Polynesia',
                'TF' => 'French Southern Territories',
                'GA' => 'Gabon',
                'GM' => 'Gambia',
                'GE' => 'Georgia',
                'DE' => 'Germany',
                'GH' => 'Ghana',
                'GI' => 'Gibraltar',
                'GR' => 'Greece',
                'GL' => 'Greenland',
                'GD' => 'Grenada',
                'GP' => 'Guadeloupe',
                'GU' => 'Guam',
                'GT' => 'Guatemala',
                'GG' => 'Guernsey',
                'GN' => 'Guinea',
                'GW' => 'Guinea-Bissau',
                'GY' => 'Guyana',
                'HT' => 'Haiti',
                'HM' => 'Heard Island & Mcdonald Islands',
                'VA' => 'Holy See (Vatican City State)',
                'HN' => 'Honduras',
                'HK' => 'Hong Kong',
                'HU' => 'Hungary',
                'IS' => 'Iceland',
                'IN' => 'India',
                'ID' => 'Indonesia',
                'IR' => 'Iran, Islamic Republic Of',
                'IQ' => 'Iraq',
                'IE' => 'Ireland',
                'IM' => 'Isle Of Man',
                'IL' => 'Israel',
                'IT' => 'Italy',
                'JM' => 'Jamaica',
                'JP' => 'Japan',
                'JE' => 'Jersey',
                'JO' => 'Jordan',
                'KZ' => 'Kazakhstan',
                'KE' => 'Kenya',
                'KI' => 'Kiribati',
                'KR' => 'Korea',
                'KW' => 'Kuwait',
                'KG' => 'Kyrgyzstan',
                'LA' => 'Lao People\'s Democratic Republic',
                'LV' => 'Latvia',
                'LB' => 'Lebanon',
                'LS' => 'Lesotho',
                'LR' => 'Liberia',
                'LY' => 'Libyan Arab Jamahiriya',
                'LI' => 'Liechtenstein',
                'LT' => 'Lithuania',
                'LU' => 'Luxembourg',
                'MO' => 'Macao',
                'MK' => 'Macedonia',
                'MG' => 'Madagascar',
                'MW' => 'Malawi',
                'MY' => 'Malaysia',
                'MV' => 'Maldives',
                'ML' => 'Mali',
                'MT' => 'Malta',
                'MH' => 'Marshall Islands',
                'MQ' => 'Martinique',
                'MR' => 'Mauritania',
                'MU' => 'Mauritius',
                'YT' => 'Mayotte',
                'MX' => 'Mexico',
                'FM' => 'Micronesia, Federated States Of',
                'MD' => 'Moldova',
                'MC' => 'Monaco',
                'MN' => 'Mongolia',
                'ME' => 'Montenegro',
                'MS' => 'Montserrat',
                'MA' => 'Morocco',
                'MZ' => 'Mozambique',
                'MM' => 'Myanmar',
                'NA' => 'Namibia',
                'NR' => 'Nauru',
                'NP' => 'Nepal',
                'NL' => 'Netherlands',
                'AN' => 'Netherlands Antilles',
                'NC' => 'New Caledonia',
                'NZ' => 'New Zealand',
                'NI' => 'Nicaragua',
                'NE' => 'Niger',
                'NG' => 'Nigeria',
                'NU' => 'Niue',
                'NF' => 'Norfolk Island',
                'MP' => 'Northern Mariana Islands',
                'NO' => 'Norway',
                'OM' => 'Oman',
                'PK' => 'Pakistan',
                'PW' => 'Palau',
                'PS' => 'Palestinian Territory, Occupied',
                'PA' => 'Panama',
                'PG' => 'Papua New Guinea',
                'PY' => 'Paraguay',
                'PE' => 'Peru',
                'PH' => 'Philippines',
                'PN' => 'Pitcairn',
                'PL' => 'Poland',
                'PT' => 'Portugal',
                'PR' => 'Puerto Rico',
                'QA' => 'Qatar',
                'RE' => 'Reunion',
                'RO' => 'Romania',
                'RU' => 'Russian Federation',
                'RW' => 'Rwanda',
                'BL' => 'Saint Barthelemy',
                'SH' => 'Saint Helena',
                'KN' => 'Saint Kitts And Nevis',
                'LC' => 'Saint Lucia',
                'MF' => 'Saint Martin',
                'PM' => 'Saint Pierre And Miquelon',
                'VC' => 'Saint Vincent And Grenadines',
                'WS' => 'Samoa',
                'SM' => 'San Marino',
                'ST' => 'Sao Tome And Principe',
                'SA' => 'Saudi Arabia',
                'SN' => 'Senegal',
                'RS' => 'Serbia',
                'SC' => 'Seychelles',
                'SL' => 'Sierra Leone',
                'SG' => 'Singapore',
                'SK' => 'Slovakia',
                'SI' => 'Slovenia',
                'SB' => 'Solomon Islands',
                'SO' => 'Somalia',
                'ZA' => 'South Africa',
                'GS' => 'South Georgia And Sandwich Isl.',
                'ES' => 'Spain',
                'LK' => 'Sri Lanka',
                'SD' => 'Sudan',
                'SR' => 'Suriname',
                'SJ' => 'Svalbard And Jan Mayen',
                'SZ' => 'Swaziland',
                'SE' => 'Sweden',
                'CH' => 'Switzerland',
                'SY' => 'Syrian Arab Republic',
                'TW' => 'Taiwan',
                'TJ' => 'Tajikistan',
                'TZ' => 'Tanzania',
                'TH' => 'Thailand',
                'TL' => 'Timor-Leste',
                'TG' => 'Togo',
                'TK' => 'Tokelau',
                'TO' => 'Tonga',
                'TT' => 'Trinidad And Tobago',
                'TN' => 'Tunisia',
                'TR' => 'Turkey',
                'TM' => 'Turkmenistan',
                'TC' => 'Turks And Caicos Islands',
                'TV' => 'Tuvalu',
                'UG' => 'Uganda',
                'UA' => 'Ukraine',
                'AE' => 'United Arab Emirates',
                'GB' => 'United Kingdom',
                'US' => 'United States',
                'UM' => 'United States Outlying Islands',
                'UY' => 'Uruguay',
                'UZ' => 'Uzbekistan',
                'VU' => 'Vanuatu',
                'VE' => 'Venezuela',
                'VN' => 'Viet Nam',
                'VG' => 'Virgin Islands, British',
                'VI' => 'Virgin Islands, U.S.',
                'WF' => 'Wallis And Futuna',
                'EH' => 'Western Sahara',
                'YE' => 'Yemen',
                'ZM' => 'Zambia',
                'ZW' => 'Zimbabwe',
        );
   }
    private function _base_url()
    {
        $protocol = "http";
        return $protocol . "://" . $_SERVER['HTTP_HOST'];
    }
    //</editor-fold>
    
    //<editor-fold defaultstate="collapsed" desc="protected section">
    //<editor-fold defaultstate="collapsed" desc="header display">
    protected function header()
    {
        $email = $this->session->userdata('username');
        /*******Contains the list of menu feature*******/
        $myprofileurl = base_url() . 'index.php/cb_user_profile_update/my_profile';
        /*********************End************************/
        $this->session->set_userdata('current_page', 'ressphere_main');
        //$username = explode('@', $email)[0];
        $username = $this->session->userdata('displayname');
        $services = array(array("Home", "", $this->_get_wsdl_base_url()));
        foreach($this->_get_features() as $feature)
        {
            if($feature[0] !== "coming soon")
            {
                array_push($services, $feature);
            }
        }
        $header_content = array (
          'logo'=>$this->logo,
          'logo_desc' => $this->logo_description,
          'menus' => $this->get_tabs(),
          'default_text' => "Search for places, building, etc .....",
          'user_image' => base_url() . "images/user_profile.png",
          'username' => $username,
          'myprofileurl' => $myprofileurl,
          'services'=> $services
          
          
        );
        $this->extemplate->write_view('header', '_usercontrols/header', $header_content, TRUE);
        
        
    }
    //</editor-fold>
    
    //<editor-fold defaultstate="collapsed" desc="set the menu items in the header">
    protected function set_tabs($tabs)
    {
       $this->tabs = $tabs;
    }
    protected function get_tabs()
    {
       return $this->tabs;
    }
    //</editor-fold>
    
   //<editor-fold defaultstate="collapsed" desc="set the menu items in the footer">
    protected function aet_footer_tabs($tabs)
    {
       $this->footers = $tabs;
    }
    protected function get_footer_tabs()
    {
       return $this->footers;
    }
    ##Properties set/get
    protected function footer()
    {
         $footer_content = array (
          'menus' => $this->get_footer_tabs(),
          'copyright' => "Copyright &copy; " . date("Y") ." Ressphere. All right reserved"
          
        );
        $this->extemplate->write_view('footer', '_usercontrols/footer', $footer_content, TRUE);
    }
    //</editor-fold>
    
   protected function _get_unused_count($feature_count)
   {
       $remainder = $feature_count;
       do
       {
           $remainder = $remainder - 3;
       }while($remainder > 0);
       $remainder = $remainder * -1;
       return $remainder;
   }
   
   protected function _get_features()
   {
       $val_return = GeneralFunc::CB_Receive_Service_Request("CB_Ressphere_Home:get_features_list");
       $features_list = json_decode($val_return, TRUE);
       $features = array();
       foreach ($features_list["data"]["result"] as $feature_info)
       {
           array_push($features, array($feature_info['category'],
            base_url() . 'assets/images/' . "i_property/" . $feature_info['category_icon'],
           $feature_info['category_path']));
       }
       if(count($features_list["data"]["result"]) == 0)
       {
           //images/soon.png
           for ($i = 0; $i <= 3; $i++)
           {
                array_push($features, array("coming soon",
                "images/soon.png",
                ""));
           }
       }
       else {
           $remainder = $this->_get_unused_count(count($features_list["data"]["result"]));
           for($i=0;$i<$remainder;$i++)
           {
                array_push($features, array("coming soon",
                "images/soon.png",
                ""));
           }
           
       }
       
       return $features;
   }

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
    
    protected function set_title($title)
    {
        $this->extemplate->write('title', $title);
    }
    
    protected function facebook_content($fb_type, $data_link, $allow_send, $width, $show_face)
    {
        //<div class="fb-like" data-href="http://www.winterlove.com.my" data-send="true" data-width="150" data-show-faces="true"></div>
        
        $content = "<div class='fb-like' data-href='" . $data_link."' data-width='".$width."' ";
        if($allow_send)
        {
            $content = $content . "data-send='true' ";
        }
        else
        {
            $content = $content . "data-send='false' ";
        }
        if($show_face)
        {
            $content = $content . "data-show-faces='true' ";
        }
        else
        {
            $content = $content . "data-show-faces='false' ";
        }
        if($fb_type == fb_type::fb_recommend)
        {
            $content = $content . "data-action='recommend' ";
        }
        $content = $content . "></div>";
         $this->extemplate->write('facebook_content', $content);
    }
    
    protected function facebook($title, $type, $url, $image, $sitename, $admin)
    {
        $content = "<meta property='og:title' content='".$title."'/>";
        $content = $content . "<meta property='og:url' content='".$url."'/>";
        $content = $content . "<meta property='og:image' content='".$image."'/>";
        $content = $content . "<meta property='og:site_name' content='".$sitename."'/>";
        $content = $content . "<meta property='fb:admins' content='".$admin."'/>";
        $content = $content . '<div id="fb-root"></div>';
        $this->extemplate->write('facebook', $content);
        
        
    }
    protected function _get_posted_value($key)
    {
        if(array_key_exists($key, $_POST))
        {
            return $_POST[$key];
        }
        return NULL;
    }
    protected function _get_array_value($array, $key)
    {
        if(array_key_exists($key, $array))
        {
            return $array[$key];
        }
        return NULL;
    }
    protected function _get_country_code ($country)
     {
         $Country_Info["country"] = $country;
         $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:get_country_code", 
               json_encode($Country_Info));
         $val_return = json_decode($val_return, TRUE);
         return $val_return["data"]["result"];
     }
	 protected function _get_state_codes ($country)
     {
         $Country_Info["country"] = $country;
         $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:get_state_codes", 
               json_encode($Country_Info));
         $val_return = json_decode($val_return, TRUE);
         return $val_return["data"]["result"];
     }
    protected function _get_country_list () {
            $val_return = GeneralFunc::CB_Receive_Service_Request("CB_Member:get_country_list");
            $val_return = json_decode($val_return, TRUE);
            return $val_return["data"]["result"];
     }
     protected function _print ($msg) {
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
      public function get_version()
	 {
		echo phpinfo();
	 }
     /**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */
    protected function _create_captcha($type)
	{
            //$this->session->keep_flashdata('captcha_word');
            //$this->session->keep_flashdata('captcha_time');
            $captcha_word = $this->session->userdata('captcha_word');
          
            if(!$captcha_word)
            {
                $captcha_word = array();
            }
            $captcha_time = $this->session->userdata('captcha_time');
            if(!$captcha_time)
            {
                $captcha_time = array();
            }
            $val_return = GeneralFunc::CB_Receive_Service_Request("CB_Member:get_create_captcha");
            $val_return = json_decode($val_return, TRUE);
            $captcha_data = $val_return["data"]["result"];
            $captcha_html = str_replace("&gt;", ">", $captcha_data[0]);
            $captcha_html = str_replace("&lt;", "<", $captcha_html);
            $captcha_word[$type] = $captcha_data[1];
            $captcha_time[$type] = $captcha_data[2];
            // Save captcha params in session
            $this->session->set_userdata(array(
				'captcha_word' => $captcha_word,
				'captcha_time' => $captcha_time,
            ));
            return $captcha_html;
	}
     	/**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
    protected function _check_captcha($code, $type)
	{
                $captcha_code["code"] = $code;
                $captcha_word = $this->session->userdata('captcha_word');
                $captcha_time = $this->session->userdata('captcha_time');
                $captcha_code["time"] = $captcha_time[$type];
		$captcha_code["word"] = $captcha_word[$type];
                
                
		$val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:check_captcha", json_encode($captcha_code));
                $val_return = json_decode($val_return, TRUE);
                
                unset($captcha_word[$type]);
                unset($captcha_time[$type]);
                
                $this->session->set_userdata(array(
				'captcha_word' => $captcha_word,
				'captcha_time' => $captcha_time,
                ));
                return   $val_return["data"]["result"];
	}
    protected function _create_recaptcha()
    {
        
        $val_return = GeneralFunc::CB_Receive_Service_Request("CB_Member:get_create_recaptcha");
        //$val_return = str_replace('/', place, $subject)
        $val_return = json_decode($val_return, TRUE);
        $captcha_data = html_entity_decode(html_entity_decode($val_return["data"]["result"]));
        return $captcha_data;
    }
    protected function _check_recaptcha($website_name,$response_field, $challenge_field)
    {
        
        $captcha_code["remote_addr"] = $website_name; 
        $captcha_code["challenge_field"] = $challenge_field;
        $captcha_code["response_field"] = $response_field;


        $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:check_recaptcha", json_encode($captcha_code));
        $val_return = json_decode($val_return, TRUE);
        return   $val_return["data"]["result"];
    }
    
//    public function print_recaptcha()
//    {
//        //get_create_recaptcha
//        $val_return = GeneralFunc::CB_Receive_Service_Request("CB_Member:get_create_recaptcha");
//       //$val_return = str_replace('/', place, $subject)
//        $val_return = json_decode($val_return, TRUE);
//        $captcha_data = html_entity_decode(html_entity_decode($val_return["data"]["result"]));
//        echo $captcha_data;
//    }

	
     protected function _validate_email($email)
     {
       $mail["address"] = $email;
       $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:validate_email", 
               json_encode($mail));
       $val_return = json_decode($val_return, TRUE);
       return  $val_return["data"]["result"];
     }
     	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
        public static function _begin_send_email($type, $email, &$data, $ci = NULL)
        {
            //$config['website_name'] = 'ressphere.com';
            //$config['webmaster_email'] = 'admin@ressphere.com';
            $website_name = $ci->config->item('website_name', 'tank_auth');
            $webmaster_email = $ci->config->item('webmaster_email', 'tank_auth');
           //$CI =& get_instance();
            //$CI->load->library('email');
            $ci->email->from($webmaster_email, $website_name);
            $ci->email->reply_to($webmaster_email, $website_name);
            $ci->email->to($email);
            $ci->email->subject($type . " " . $website_name);
            $ci->email->message($ci->load->view('_email/'.$type.'-html', $data, TRUE));
            $ci->email->set_alt_message($ci->load->view('_email/'.$type.'-txt', $data, TRUE));
            $result = $ci->email->send();
            return $result;
        }
	public function _send_email($type, $email, &$data)
	{
                return base::_begin_send_email($type, $email, $data, $this);
        
	}
     protected function _begin_logout()
     {
         $val_return = GeneralFunc::CB_Receive_Service_Request("CB_Member:begin_logout");
         $val_return = json_decode($val_return, TRUE);
         $this->session->unset_userdata(array('user_id' => '', 'username' => '', 'status' => ''));
         $this->session->sess_destroy();
         $all_data = $this->session->all_userdata();
         
     }
     protected function _is_login( $activated = TRUE)
     {
        return  $this->session->userdata('status') === ($activated ? TRUE : FALSE);
     }
     protected function _is_secure_page()
     {
        return $this->session->userdata('secure') === "1";
            
     }
     protected function _get_user_id()
     {
        return $this->session->userdata('user_id');
     }
     protected function _get_username()
     {
        return $this->session->userdata('username');
     }
     protected function _get_wsdl_base_url()
     {
         $val_return = GeneralFunc::CB_Receive_Service_Request("CB_Info:base_url");
         $wsdl_base_url = json_decode($val_return, TRUE);
         $wsdl_base_url  = $wsdl_base_url["data"]["result"];
         return $wsdl_base_url;
     }
      protected function _loginView()
        {
            $this->extemplate->set_extemplate('login');
            $login_content = array ();
            if(!is_null($this->logo))
            {
                $login_content["Logo"] = $this->logo;
            }
            $login_content["Username"] = "Email";
            $login_content["Password"] = "Password";
            $login_content["Captcha"] = "";//$this->_create_recaptcha();
            
            $js_url = base_url() . "js/_usercontrols/login.js";
            //$content["script"] base_url() . "js/_usercontrols/logout.js";
            $public_key = $this->config->item('recaptcha_public_key', 'tank_auth');
            $login_content["script"] = str_replace('captcha_public_key', $public_key, file_get_contents($js_url));
            //$login_content["script"] = "";
            $this->extemplate->write_view('login_dialog', '_usercontrols/login', $login_content, TRUE);
            $login = $this->extemplate->render('',TRUE);
            return $login;
        }
          protected function _registerView()
        {
            //echo ltrim(assets_server_path('captcha/', 'images'), '/');
            $this->extemplate->set_extemplate('login');
            $register_content = array ();
            if(!is_null($this->logo))
            {
                $register_content["Logo"] = $this->logo;
            }
            $register_content["Displayname"] = "Display Name";
            $register_content["Username"] = "Email";
            $register_content["Password"] = "Password";
            $register_content["RePassword"] = "Retype Password";
            $register_content["Countries"] = $this->_get_country_list();
            $register_content["Selected"] = "Malaysia";
            $register_content["Area_Code"] = $this->_get_state_codes($register_content["Selected"]);
            $register_content["Captcha"] = "";//$this->_create_recaptcha();
          
            $js_url = base_url() . "js/_usercontrols/register.js";
            //$content["script"] base_url() . "js/_usercontrols/logout.js";
            //$register_content["script"] = file_get_contents($js_url);
            $public_key = $this->config->item('recaptcha_public_key', 'tank_auth');
            $register_content["script"] = str_replace('captcha_public_key', $public_key, file_get_contents($js_url));
         
            $register_content["terms_conditions"] = base_url() . "index.php/policy";
            $this->extemplate->write_view('login_dialog', '_usercontrols/register', $register_content, TRUE);
            $register = $this->extemplate->render('',TRUE);
            
            return $register;
        }
                protected function _forgotpassView()
        {
            $this->extemplate->set_extemplate('login');
            $login_content = array ();
            if(!is_null($this->logo))
            {
                $login_content["Logo"] = $this->logo;
            }
            $login_content["Username"] = "Please enter your email";
            $js_url = base_url() . "js/_usercontrols/forgot_password.js";
            //$content["script"] base_url() . "js/_usercontrols/logout.js";
            $login_content["script"] = file_get_contents($js_url);
            $this->extemplate->write_view('login_dialog', '_usercontrols/forgot_password', $login_content, TRUE);
            $forgot_password = $this->extemplate->render('',TRUE);
            return $forgot_password;
        }
        protected function _changepassView()
        {
            $this->extemplate->set_extemplate('login');
            $login_content = array ();
            if(!is_null($this->logo))
            {
                $login_content["Logo"] = $this->logo;
            }
            $login_content["old_pass"] = "Please enter your existing password";
            $login_content["new_pass"] = "Please enter your new password";
            $login_content["confirm_pass"] = "Please re-enter your new password";
            $js_url = base_url() . "js/_usercontrols/change_password.js";
            $login_content["script"] = file_get_contents($js_url);
            $this->extemplate->write_view('login_dialog', '_usercontrols/change_password', $login_content, TRUE);
            $change_password = $this->extemplate->render('',TRUE);
            return $change_password;
        }
         protected function _logoutView()
        {
            $this->extemplate->set_extemplate('login');
            $content = array ();
            if(!is_null($this->logo))
            {
                $content["Logo"] = $this->logo;
            }
            $content["msg"] = "";
            $js_url = base_url() . "js/_usercontrols/logout.js";
            //$content["script"] base_url() . "js/_usercontrols/logout.js";
            $content["script"] = file_get_contents($js_url);
            $this->extemplate->write_view('login_dialog', '_usercontrols/logout', $content, TRUE);
            $logout = $this->extemplate->render('',TRUE);
            return $logout;
        }
         public function require_login_captcha($login, $msg)
        {
             $login_parameters["login"] = $login;
             $get_login_exceeded = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:is_max_login_attempts_exceeded",
             json_encode($login_parameters));
             $is_login_exceeded_data = json_decode($get_login_exceeded, TRUE);
	     $is_login_exceeded = $is_login_exceeded_data["data"]["result"];

                    if ($is_login_exceeded) {
                        return 'exceeded_login;'.$msg;
                    }
                    else {
                        return $msg;
                    }
        }
     public function check_userdata()
     {
         $all_data = $this->session->all_userdata();
         var_dump($all_data);
     }
     private function get_country_phone_code()
     {
         return json_decode(
          '{
            "countries": {
                "country": [
              {
                "-code": "af",
                "-phoneCode": "93",
                "-name": "Afghanistan"
              },
              {
                "-code": "al",
                "-phoneCode": "355",
                "-name": "Albania"
              },
              {
                "-code": "dz",
                "-phoneCode": "213",
                "-name": "Algeria"
              },
              {
                "-code": "ad",
                "-phoneCode": "376",
                "-name": "Andorra"
              },
              {
                "-code": "ao",
                "-phoneCode": "244",
                "-name": "Angola"
              },
              {
                "-code": "aq",
                "-phoneCode": "672",
                "-name": "Antarctica"
              },
              {
                "-code": "ar",
                "-phoneCode": "54",
                "-name": "Argentina"
              },
              {
                "-code": "am",
                "-phoneCode": "374",
                "-name": "Armenia"
              },
              {
                "-code": "aw",
                "-phoneCode": "297",
                "-name": "Aruba"
              },
              {
                "-code": "au",
                "-phoneCode": "61",
                "-name": "Australia"
              },
              {
                "-code": "at",
                "-phoneCode": "43",
                "-name": "Austria"
              },
              {
                "-code": "az",
                "-phoneCode": "994",
                "-name": "Azerbaijan"
              },
              {
                "-code": "bh",
                "-phoneCode": "973",
                "-name": "Bahrain"
              },
              {
                "-code": "bd",
                "-phoneCode": "880",
                "-name": "Bangladesh"
              },
              {
                "-code": "by",
                "-phoneCode": "375",
                "-name": "Belarus"
              },
              {
                "-code": "be",
                "-phoneCode": "32",
                "-name": "Belgium"
              },
              {
                "-code": "bz",
                "-phoneCode": "501",
                "-name": "Belize"
              },
              {
                "-code": "bj",
                "-phoneCode": "229",
                "-name": "Benin"
              },
              {
                "-code": "bt",
                "-phoneCode": "975",
                "-name": "Bhutan"
              },
              {
                "-code": "bo",
                "-phoneCode": "591",
                "-name": "Bolivia, Plurinational State Of"
              },
              {
                "-code": "ba",
                "-phoneCode": "387",
                "-name": "Bosnia And Herzegovina"
              },
              {
                "-code": "bw",
                "-phoneCode": "267",
                "-name": "Botswana"
              },
              {
                "-code": "br",
                "-phoneCode": "55",
                "-name": "Brazil"
              },
              {
                "-code": "bn",
                "-phoneCode": "673",
                "-name": "Brunei Darussalam"
              },
              {
                "-code": "bg",
                "-phoneCode": "359",
                "-name": "Bulgaria"
              },
              {
                "-code": "bf",
                "-phoneCode": "226",
                "-name": "Burkina Faso"
              },
              {
                "-code": "mm",
                "-phoneCode": "95",
                "-name": "Myanmar"
              },
              {
                "-code": "bi",
                "-phoneCode": "257",
                "-name": "Burundi"
              },
              {
                "-code": "kh",
                "-phoneCode": "855",
                "-name": "Cambodia"
              },
              {
                "-code": "cm",
                "-phoneCode": "237",
                "-name": "Cameroon"
              },
              {
                "-code": "ca",
                "-phoneCode": "1",
                "-name": "Canada"
              },
              {
                "-code": "cv",
                "-phoneCode": "238",
                "-name": "Cape Verde"
              },
              {
                "-code": "cf",
                "-phoneCode": "236",
                "-name": "Central African Republic"
              },
              {
                "-code": "td",
                "-phoneCode": "235",
                "-name": "Chad"
              },
              {
                "-code": "cl",
                "-phoneCode": "56",
                "-name": "Chile"
              },
              {
                "-code": "cn",
                "-phoneCode": "86",
                "-name": "China"
              },
              {
                "-code": "cx",
                "-phoneCode": "61",
                "-name": "Christmas Island"
              },
              {
                "-code": "cc",
                "-phoneCode": "61",
                "-name": "Cocos (keeling) Islands"
              },
              {
                "-code": "co",
                "-phoneCode": "57",
                "-name": "Colombia"
              },
              {
                "-code": "km",
                "-phoneCode": "269",
                "-name": "Comoros"
              },
              {
                "-code": "cg",
                "-phoneCode": "242",
                "-name": "Congo"
              },
              {
                "-code": "cd",
                "-phoneCode": "243",
                "-name": "Congo, The Democratic Republic Of The"
              },
              {
                "-code": "ck",
                "-phoneCode": "682",
                "-name": "Cook Islands"
              },
              {
                "-code": "cr",
                "-phoneCode": "506",
                "-name": "Costa Rica"
              },
              {
                "-code": "hr",
                "-phoneCode": "385",
                "-name": "Croatia"
              },
              {
                "-code": "cu",
                "-phoneCode": "53",
                "-name": "Cuba"
              },
              {
                "-code": "cy",
                "-phoneCode": "357",
                "-name": "Cyprus"
              },
              {
                "-code": "cz",
                "-phoneCode": "420",
                "-name": "Czech Republic"
              },
              {
                "-code": "dk",
                "-phoneCode": "45",
                "-name": "Denmark"
              },
              {
                "-code": "dj",
                "-phoneCode": "253",
                "-name": "Djibouti"
              },
              {
                "-code": "tl",
                "-phoneCode": "670",
                "-name": "Timor-leste"
              },
              {
                "-code": "ec",
                "-phoneCode": "593",
                "-name": "Ecuador"
              },
              {
                "-code": "eg",
                "-phoneCode": "20",
                "-name": "Egypt"
              },
              {
                "-code": "sv",
                "-phoneCode": "503",
                "-name": "El Salvador"
              },
              {
                "-code": "gq",
                "-phoneCode": "240",
                "-name": "Equatorial Guinea"
              },
              {
                "-code": "er",
                "-phoneCode": "291",
                "-name": "Eritrea"
              },
              {
                "-code": "ee",
                "-phoneCode": "372",
                "-name": "Estonia"
              },
              {
                "-code": "et",
                "-phoneCode": "251",
                "-name": "Ethiopia"
              },
              {
                "-code": "fk",
                "-phoneCode": "500",
                "-name": "Falkland Islands (malvinas)"
              },
              {
                "-code": "fo",
                "-phoneCode": "298",
                "-name": "Faroe Islands"
              },
              {
                "-code": "fj",
                "-phoneCode": "679",
                "-name": "Fiji"
              },
              {
                "-code": "fi",
                "-phoneCode": "358",
                "-name": "Finland"
              },
              {
                "-code": "fr",
                "-phoneCode": "33",
                "-name": "France"
              },
              {
                "-code": "pf",
                "-phoneCode": "689",
                "-name": "French Polynesia"
              },
              {
                "-code": "ga",
                "-phoneCode": "241",
                "-name": "Gabon"
              },
              {
                "-code": "gm",
                "-phoneCode": "220",
                "-name": "Gambia"
              },
              {
                "-code": "ge",
                "-phoneCode": "995",
                "-name": "Georgia"
              },
              {
                "-code": "de",
                "-phoneCode": "49",
                "-name": "Germany"
              },
              {
                "-code": "gh",
                "-phoneCode": "233",
                "-name": "Ghana"
              },
              {
                "-code": "gi",
                "-phoneCode": "350",
                "-name": "Gibraltar"
              },
              {
                "-code": "gr",
                "-phoneCode": "30",
                "-name": "Greece"
              },
              {
                "-code": "gl",
                "-phoneCode": "299",
                "-name": "Greenland"
              },
              {
                "-code": "gt",
                "-phoneCode": "502",
                "-name": "Guatemala"
              },
              {
                "-code": "gn",
                "-phoneCode": "224",
                "-name": "Guinea"
              },
              {
                "-code": "gw",
                "-phoneCode": "245",
                "-name": "Guinea-bissau"
              },
              {
                "-code": "gy",
                "-phoneCode": "592",
                "-name": "Guyana"
              },
              {
                "-code": "ht",
                "-phoneCode": "509",
                "-name": "Haiti"
              },
              {
                "-code": "hn",
                "-phoneCode": "504",
                "-name": "Honduras"
              },
              {
                "-code": "hk",
                "-phoneCode": "852",
                "-name": "Hong Kong"
              },
              {
                "-code": "hu",
                "-phoneCode": "36",
                "-name": "Hungary"
              },
              {
                "-code": "in",
                "-phoneCode": "91",
                "-name": "India"
              },
              {
                "-code": "id",
                "-phoneCode": "62",
                "-name": "Indonesia"
              },
              {
                "-code": "ir",
                "-phoneCode": "98",
                "-name": "Iran, Islamic Republic Of"
              },
              {
                "-code": "iq",
                "-phoneCode": "964",
                "-name": "Iraq"
              },
              {
                "-code": "ie",
                "-phoneCode": "353",
                "-name": "Ireland"
              },
              {
                "-code": "im",
                "-phoneCode": "44",
                "-name": "Isle Of Man"
              },
              {
                "-code": "il",
                "-phoneCode": "972",
                "-name": "Israel"
              },
              {
                "-code": "it",
                "-phoneCode": "39",
                "-name": "Italy"
              },
              {
                "-code": "ci",
                "-phoneCode": "225",
                "-name": "Côte D\'ivoire"
              },
              {
                "-code": "jp",
                "-phoneCode": "81",
                "-name": "Japan"
              },
              {
                "-code": "jo",
                "-phoneCode": "962",
                "-name": "Jordan"
              },
              {
                "-code": "kz",
                "-phoneCode": "7",
                "-name": "Kazakhstan"
              },
              {
                "-code": "ke",
                "-phoneCode": "254",
                "-name": "Kenya"
              },
              {
                "-code": "ki",
                "-phoneCode": "686",
                "-name": "Kiribati"
              },
              {
                "-code": "kw",
                "-phoneCode": "965",
                "-name": "Kuwait"
              },
              {
                "-code": "kg",
                "-phoneCode": "996",
                "-name": "Kyrgyzstan"
              },
              {
                "-code": "la",
                "-phoneCode": "856",
                "-name": "Lao People\'s Democratic Republic"
              },
              {
                "-code": "lv",
                "-phoneCode": "371",
                "-name": "Latvia"
              },
              {
                "-code": "lb",
                "-phoneCode": "961",
                "-name": "Lebanon"
              },
              {
                "-code": "ls",
                "-phoneCode": "266",
                "-name": "Lesotho"
              },
              {
                "-code": "lr",
                "-phoneCode": "231",
                "-name": "Liberia"
              },
              {
                "-code": "ly",
                "-phoneCode": "218",
                "-name": "Libya"
              },
              {
                "-code": "li",
                "-phoneCode": "423",
                "-name": "Liechtenstein"
              },
              {
                "-code": "lt",
                "-phoneCode": "370",
                "-name": "Lithuania"
              },
              {
                "-code": "lu",
                "-phoneCode": "352",
                "-name": "Luxembourg"
              },
              {
                "-code": "mo",
                "-phoneCode": "853",
                "-name": "Macao"
              },
              {
                "-code": "mk",
                "-phoneCode": "389",
                "-name": "Macedonia, The Former Yugoslav Republic Of"
              },
              {
                "-code": "mg",
                "-phoneCode": "261",
                "-name": "Madagascar"
              },
              {
                "-code": "mw",
                "-phoneCode": "265",
                "-name": "Malawi"
              },
              {
                "-code": "my",
                "-phoneCode": "+6",
                "-name": "Malaysia"
              },
              {
                "-code": "mv",
                "-phoneCode": "960",
                "-name": "Maldives"
              },
              {
                "-code": "ml",
                "-phoneCode": "223",
                "-name": "Mali"
              },
              {
                "-code": "mt",
                "-phoneCode": "356",
                "-name": "Malta"
              },
              {
                "-code": "mh",
                "-phoneCode": "692",
                "-name": "Marshall Islands"
              },
              {
                "-code": "mr",
                "-phoneCode": "222",
                "-name": "Mauritania"
              },
              {
                "-code": "mu",
                "-phoneCode": "230",
                "-name": "Mauritius"
              },
              {
                "-code": "yt",
                "-phoneCode": "262",
                "-name": "Mayotte"
              },
              {
                "-code": "mx",
                "-phoneCode": "52",
                "-name": "Mexico"
              },
              {
                "-code": "fm",
                "-phoneCode": "691",
                "-name": "Micronesia, Federated States Of"
              },
              {
                "-code": "md",
                "-phoneCode": "373",
                "-name": "Moldova, Republic Of"
              },
              {
                "-code": "mc",
                "-phoneCode": "377",
                "-name": "Monaco"
              },
              {
                "-code": "mn",
                "-phoneCode": "976",
                "-name": "Mongolia"
              },
              {
                "-code": "me",
                "-phoneCode": "382",
                "-name": "Montenegro"
              },
              {
                "-code": "ma",
                "-phoneCode": "212",
                "-name": "Morocco"
              },
              {
                "-code": "mz",
                "-phoneCode": "258",
                "-name": "Mozambique"
              },
              {
                "-code": "na",
                "-phoneCode": "264",
                "-name": "Namibia"
              },
              {
                "-code": "nr",
                "-phoneCode": "674",
                "-name": "Nauru"
              },
              {
                "-code": "np",
                "-phoneCode": "977",
                "-name": "Nepal"
              },
              {
                "-code": "nl",
                "-phoneCode": "31",
                "-name": "Netherlands"
              },
              {
                "-code": "nc",
                "-phoneCode": "687",
                "-name": "New Caledonia"
              },
              {
                "-code": "nz",
                "-phoneCode": "64",
                "-name": "New Zealand"
              },
              {
                "-code": "ni",
                "-phoneCode": "505",
                "-name": "Nicaragua"
              },
              {
                "-code": "ne",
                "-phoneCode": "227",
                "-name": "Niger"
              },
              {
                "-code": "ng",
                "-phoneCode": "234",
                "-name": "Nigeria"
              },
              {
                "-code": "nu",
                "-phoneCode": "683",
                "-name": "Niue"
              },
              {
                "-code": "kp",
                "-phoneCode": "850",
                "-name": "Korea, Democratic People\'s Republic Of"
              },
              {
                "-code": "no",
                "-phoneCode": "47",
                "-name": "Norway"
              },
              {
                "-code": "om",
                "-phoneCode": "968",
                "-name": "Oman"
              },
              {
                "-code": "pk",
                "-phoneCode": "92",
                "-name": "Pakistan"
              },
              {
                "-code": "pw",
                "-phoneCode": "680",
                "-name": "Palau"
              },
              {
                "-code": "pa",
                "-phoneCode": "507",
                "-name": "Panama"
              },
              {
                "-code": "pg",
                "-phoneCode": "675",
                "-name": "Papua New Guinea"
              },
              {
                "-code": "py",
                "-phoneCode": "595",
                "-name": "Paraguay"
              },
              {
                "-code": "pe",
                "-phoneCode": "51",
                "-name": "Peru"
              },
              {
                "-code": "ph",
                "-phoneCode": "63",
                "-name": "Philippines"
              },
              {
                "-code": "pn",
                "-phoneCode": "870",
                "-name": "Pitcairn"
              },
              {
                "-code": "pl",
                "-phoneCode": "48",
                "-name": "Poland"
              },
              {
                "-code": "pt",
                "-phoneCode": "351",
                "-name": "Portugal"
              },
              {
                "-code": "pr",
                "-phoneCode": "1",
                "-name": "Puerto Rico"
              },
              {
                "-code": "qa",
                "-phoneCode": "974",
                "-name": "Qatar"
              },
              {
                "-code": "ro",
                "-phoneCode": "40",
                "-name": "Romania"
              },
              {
                "-code": "ru",
                "-phoneCode": "7",
                "-name": "Russian Federation"
              },
              {
                "-code": "rw",
                "-phoneCode": "250",
                "-name": "Rwanda"
              },
              {
                "-code": "bl",
                "-phoneCode": "590",
                "-name": "Saint Barthélemy"
              },
              {
                "-code": "ws",
                "-phoneCode": "685",
                "-name": "Samoa"
              },
              {
                "-code": "sm",
                "-phoneCode": "378",
                "-name": "San Marino"
              },
              {
                "-code": "st",
                "-phoneCode": "239",
                "-name": "Sao Tome And Principe"
              },
              {
                "-code": "sa",
                "-phoneCode": "966",
                "-name": "Saudi Arabia"
              },
              {
                "-code": "sn",
                "-phoneCode": "221",
                "-name": "Senegal"
              },
              {
                "-code": "rs",
                "-phoneCode": "381",
                "-name": "Serbia"
              },
              {
                "-code": "sc",
                "-phoneCode": "248",
                "-name": "Seychelles"
              },
              {
                "-code": "sl",
                "-phoneCode": "232",
                "-name": "Sierra Leone"
              },
              {
                "-code": "sg",
                "-phoneCode": "+65",
                "-name": "Singapore"
              },
              {
                "-code": "sk",
                "-phoneCode": "421",
                "-name": "Slovakia"
              },
              {
                "-code": "si",
                "-phoneCode": "386",
                "-name": "Slovenia"
              },
              {
                "-code": "sb",
                "-phoneCode": "677",
                "-name": "Solomon Islands"
              },
              {
                "-code": "so",
                "-phoneCode": "252",
                "-name": "Somalia"
              },
              {
                "-code": "za",
                "-phoneCode": "27",
                "-name": "South Africa"
              },
              {
                "-code": "kr",
                "-phoneCode": "82",
                "-name": "Korea, Republic Of"
              },
              {
                "-code": "es",
                "-phoneCode": "34",
                "-name": "Spain"
              },
              {
                "-code": "lk",
                "-phoneCode": "94",
                "-name": "Sri Lanka"
              },
              {
                "-code": "sh",
                "-phoneCode": "290",
                "-name": "Saint Helena, Ascension And Tristan Da Cunha"
              },
              {
                "-code": "pm",
                "-phoneCode": "508",
                "-name": "Saint Pierre And Miquelon"
              },
              {
                "-code": "sd",
                "-phoneCode": "249",
                "-name": "Sudan"
              },
              {
                "-code": "sr",
                "-phoneCode": "597",
                "-name": "Suriname"
              },
              {
                "-code": "sz",
                "-phoneCode": "268",
                "-name": "Swaziland"
              },
              {
                "-code": "se",
                "-phoneCode": "46",
                "-name": "Sweden"
              },
              {
                "-code": "ch",
                "-phoneCode": "41",
                "-name": "Switzerland"
              },
              {
                "-code": "sy",
                "-phoneCode": "963",
                "-name": "Syrian Arab Republic"
              },
              {
                "-code": "tw",
                "-phoneCode": "886",
                "-name": "Taiwan, Province Of China"
              },
              {
                "-code": "tj",
                "-phoneCode": "992",
                "-name": "Tajikistan"
              },
              {
                "-code": "tz",
                "-phoneCode": "255",
                "-name": "Tanzania, United Republic Of"
              },
              {
                "-code": "th",
                "-phoneCode": "+66",
                "-name": "Thailand"
              },
              {
                "-code": "tg",
                "-phoneCode": "228",
                "-name": "Togo"
              },
              {
                "-code": "tk",
                "-phoneCode": "690",
                "-name": "Tokelau"
              },
              {
                "-code": "to",
                "-phoneCode": "676",
                "-name": "Tonga"
              },
              {
                "-code": "tn",
                "-phoneCode": "216",
                "-name": "Tunisia"
              },
              {
                "-code": "tr",
                "-phoneCode": "90",
                "-name": "Turkey"
              },
              {
                "-code": "tm",
                "-phoneCode": "993",
                "-name": "Turkmenistan"
              },
              {
                "-code": "tv",
                "-phoneCode": "688",
                "-name": "Tuvalu"
              },
              {
                "-code": "ae",
                "-phoneCode": "971",
                "-name": "United Arab Emirates"
              },
              {
                "-code": "ug",
                "-phoneCode": "256",
                "-name": "Uganda"
              },
              {
                "-code": "gb",
                "-phoneCode": "44",
                "-name": "United Kingdom"
              },
              {
                "-code": "ua",
                "-phoneCode": "380",
                "-name": "Ukraine"
              },
              {
                "-code": "uy",
                "-phoneCode": "598",
                "-name": "Uruguay"
              },
              {
                "-code": "us",
                "-phoneCode": "1",
                "-name": "United States"
              },
              {
                "-code": "uz",
                "-phoneCode": "998",
                "-name": "Uzbekistan"
              },
              {
                "-code": "vu",
                "-phoneCode": "678",
                "-name": "Vanuatu"
              },
              {
                "-code": "va",
                "-phoneCode": "39",
                "-name": "Holy See (vatican City State)"
              },
              {
                "-code": "ve",
                "-phoneCode": "58",
                "-name": "Venezuela, Bolivarian Republic Of"
              },
              {
                "-code": "vn",
                "-phoneCode": "84",
                "-name": "Viet Nam"
              },
              {
                "-code": "wf",
                "-phoneCode": "681",
                "-name": "Wallis And Futuna"
              },
              {
                "-code": "ye",
                "-phoneCode": "967",
                "-name": "Yemen"
              },
              {
                "-code": "zm",
                "-phoneCode": "260",
                "-name": "Zambia"
              },
              {
                "-code": "zw",
                "-phoneCode": "263",
                "-name": "Zimbabwe"
              }
            ]
            }
        }', TRUE);
     }
     public function obtain_user_information()
       {

           $user_info = array(
               "displayname"=>"",
               "username"=>"",
               "phone"=>"",
               "user_id"=>"",
               "country"=>""
           );
           $user_id = $this->session->userdata('user_id');
           if($user_id)
           {
                $user["user_id"] = $user_id;
                $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:get_user_phone_number",
                        json_encode($user));
                $val_return_country = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:get_country",
                        json_encode($user));
                
               
                $phone_number = json_decode($val_return, TRUE);
                $country = json_decode($val_return_country, TRUE)["data"]["result"];
                $country_short_name = NULL;
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
                $real_phone_number_1 = str_replace("(", "", $phone_number["data"]["result"]);
                $real_phone_number = str_replace(")", "", $real_phone_number_1);
                
                $user_info["displayname"] = $this->session->userdata('displayname');
                $user_info["phone"] = sprintf("%s%s",$country_code, $real_phone_number);
                $user_info["username"] = $this->session->userdata('username');
		$user_info["user_id"] = $user_id;
                $user_info["country"] = $country;
                $this->_print(json_encode($user_info));
           }
           else
           {
               $this->set_error("obtain_user_information failed with invalid user id: (" . $user_id .")");
           }
       }
       
     
     public function obtain_user_listing_information()
       {           
           $user_id = $this->session->userdata('user_id');
           if($user_id)
           {
                //create am array structure to store the return listing details
                $listing_info = array(
                                    array(
                                            "ref_tag"=>"",
                                            "property_name"=>"",
                                            "price"=>"",
                                            "activate"=>""
                                         )
                                     );
               
                //setup the listing filter by user id
                $filter_struct["filter"]["user_id"] = $user_id;

                //get the filtered listing details
                $val_return_listing = GeneralFunc::CB_SendReceive_Service_Request("CB_Property:filter_listing",
                        json_encode($filter_struct));

                $listings = json_decode($val_return_listing, TRUE)["data"]["listing"];

                //populate the details for each listing into the placeholder array
                $index = 0;
                foreach ($listings as $listing)
                {
                    $listing_info[$index]["ref_tag"] = $listing["ref_tag"];
                    $listing_info[$index]["property_name"] = $listing["property_name"];
                    $listing_info[$index]["price"] = $listing["price"];
                    $listing_info[$index]["activate"] = $listing["activate"];
                    $index = $index + 1;
                }
                               

                $this->_print(json_encode($listing_info));
           }
           else
           {
               $this->set_error("obtain_user_listing_information failed with invalid user id: (" . $user_id .")");
           }
       }  
       
     public function remove_user_listing_information()
       {
           $ref_tag = explode(",",$this->_get_posted_value('reftag'));
           $user_id = $this->session->userdata('user_id');
           $return_status = NULL;
           
           if($user_id)
           {
               foreach ($ref_tag as $value)
               {
                    $ref_tag_array = array("ref_tag"=>$value); 
                     //get the filtered listing details
                      $val_return_listing = GeneralFunc::CB_SendReceive_Service_Request("CB_Property:delete_listing",
                              json_encode($ref_tag_array));

                      $return_status = json_decode($val_return_listing, true);

                      if( ($return_status != NULL) && 
                          (strpos($return_status["status_information"], "Successfully deleted data") === false))
                      {
                          break;
                      }

               }
               $this->_print(json_encode($return_status));
           }
           else
           {
               $this->set_error("remove_user_listing_information failed with invalid user id: (" . $user_id .")");
           }
       }
       
     public function obtain_user_inbox_information()
     {           
           $user_id = $this->session->userdata('user_id');
           if($user_id)
           {
                //create am array structure to store the return inbox details
                $listing_info = array(
                                    array(
                                            "ref_tag"=>"",
                                            "title"=>"",
                                            "sender"=>"",
                                            "date"=>""
                                         )
                                     );
               
                //setup the inbox filter by user id
                $filter_struct["filter"]["user_id"] = $user_id;

                //TODO: to update the following with the right function
                //get the filtered inbox details
                //$val_return_listing = GeneralFunc::CB_SendReceive_Service_Request("CB_Property:filter_listing",
                //        json_encode($filter_struct));

                $inboxs = json_decode($val_return_listing, TRUE)["data"]["inbox"];

                //populate the details for each listing into the placeholder array
                $index = 0;
                foreach ($inboxs as $inbox)
                {
                    $inbox_info[$index]["ref_tag"] = $inbox["ref_tag"];
                    $inbox_info[$index]["title"] = $inbox["title"];
                    $inbox_info[$index]["sender"] = $inbox["sender"];
                    $inbox_info[$index]["date"] = $inbox["date"];
                    $index = $index + 1;
                }
                               

                $this->_print(json_encode($inbox_info));
           }
           else
           {
               $this->set_error("obtain_user_inbox_information failed with invalid user id: (" . $user_id .")");
           }
     }  
       
     public function get_country_short_name()
     {
            $country_info = array();
            $country_short_name = "";
            if (count($_POST) == 1) {
                $country = $this->_get_posted_value('country');
                $country_short_name = array_search($country,  $this->countries);
                array_push($country_info, $country_short_name);
            }
           $this->_print($country_short_name);
     }
     public function get_country_location()
     {
         $location = NULL;
         if(count($_POST) == 1)
         {
             $country_short_name = $this->_get_posted_value('country_short_name');
             $location = $this->country_location[$country_short_name];
         }
         $this->_print(json_encode($location)); 
     }
   
  
   
    protected function set_error($error_string)
    {
        $log_location = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "logs".
                DIRECTORY_SEPARATOR . date("Ymd"). ".log";
        error_log($error_string ."\n", 3, $log_location);
    }
    protected function get_page404($error)
    {
            $title = "404 Page Not Found";
            
            $wsdl = $this->_get_wsdl_base_url();
            
            $this->extemplate->set_extemplate('page404_home');
            #$this->SEO_Tags($content);
            $this->extemplate->write('title', $title);
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
                'contactus'=>$wsdl.'#contact'
                #'title'=>$title,
            ) ,TRUE);
            $output = $this->extemplate->render(NULL, TRUE);
            return $output;
    }
    protected function get_page403($error, $home)
    {
            $title = "403 Forbidden";
            
            $wsdl = $this->_get_wsdl_base_url();
            
            $this->extemplate->set_extemplate("page403_home");
            $this->extemplate->write('title', $title);
            $this->extemplate->add_js($wsdl . "js/bootstrap.min.js", "import", FALSE, FALSE);
            $this->extemplate->add_js($wsdl . "js/jquery.easing.min.js", "import", FALSE, FALSE);
            //$this->extemplate->add_js($wsdl . "js/jstorage.min.js", "import", FALSE, FALSE);
            $this->extemplate->add_js($wsdl . "js/page-403.js", "import", FALSE, FALSE);
            
            $this->extemplate->add_css($wsdl . "css/bootstrap.css", "link", FALSE, FALSE);
            $this->extemplate->add_css($wsdl . "css/404.css", "link", FALSE, FALSE);
            
            
            //cb_change_profile
            $this->extemplate->write_view('content', '_usercontrols/cb_403_page',array(
                'reason'=>$error,
                'img403'=>$wsdl.'images/403img.svg',
                'homepage'=>base_url(),
                'contactus'=>$wsdl.'#contact',
                'title'=>$title,
                'nav'=>$home
            ) ,TRUE);
            $output = $this->extemplate->render(NULL, TRUE);
            return $output;
    }
}

class fb_type
{
    const fb_like = 0;
    const fb_recommend = 1;
    // etc.
}
?>
