<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CBWS_Member {
    private $CI = NULL;
    function __construct() {
        
        //$this->ci =& get_instance
        
        //$this->load->database();
        $this->CI =& get_instance();
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $this->CI->load->library('Tank_auth');
        
    }

    public function get_country_list()
    {
        $countries = array();
        foreach ($this->CI->tank_auth->get_countries() as $row)
        {
            array_push($countries, $row['name']);
        }
        return $countries;
    }
    
    public function get_user_property_listing_limit($user_id)
    {

        return $this->CI->tank_auth->get_user_prop_listing_limit($user_id);
    }
    
     public function get_user_property_sms_limit($user_id)
    {

        return $this->CI->tank_auth->get_user_property_sms_limit($user_id);
    }
    
    public function set_user_property_sms_limit($user_id)
    {
        return $this->CI->tank_auth->set_user_property_sms_limit($user_id);
    }
    
    public function create_user($username, $display_name, $email, $password, $phone, $email_activation, $country)
    {
        //return "Create User";
         return $this->CI->tank_auth->create_user($username,$display_name,$email,$password,$phone, $email_activation, $country);
    }
    public function get_state_codes ($country)
    {
         $codeList = array();
         
        foreach ($this->CI->tank_auth->get_state_codes($country) as $row)
        {
            $state_code = $row['state_code'];
            $pos = strrpos($state_code, "(");
            if($pos !== FALSE)
            {
                $state_code = str_replace('(','', $state_code);
                $state_code = str_replace(')','', $state_code);
            }
            array_push($codeList, $state_code);
        }
         //array_push($codeList, $country);
         return $codeList;
     }
    /**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */
    public function get_create_captcha()
    {
		$this->CI->load->helper('captcha');

		$cap = create_captcha(array(
			'img_path'		=> assets_server_path('captcha/', 'images'),
			'img_url'		=> base_url()."assets/images/captcha/",
			'font_path'		=> './'.$this->CI->config->item('captcha_fonts_path', 'tank_auth'),
			'font_size'		=> $this->CI->config->item('captcha_font_size', 'tank_auth'),
			'img_width'		=> $this->CI->config->item('captcha_width', 'tank_auth'),
			'img_height'	=> $this->CI->config->item('captcha_height', 'tank_auth'),
			'show_grid'		=> $this->CI->config->item('captcha_grid', 'tank_auth'),
			'expiration'	=> $this->CI->config->item('captcha_expire', 'tank_auth'),
		));

		// Save captcha params in session
		/*$this->CI->session->set_userdata(array(
				'captcha_word' => $cap['word'],
				'captcha_time' => $cap['time'],
		));*/
                $img_path = str_replace("\"", "'", $cap['image']);
		return array($img_path, $cap['word'], $cap['time']);
	}
    /**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
    public function check_captcha($code,$time, $word)
    {
		//$time = $this->CI->session->userdata('captcha_time');
		//$word = $this->CI->session->userdata('captcha_word');
                
		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		if ($now - $time > $this->CI->config->item('captcha_expire', 'tank_auth')) {
			return FALSE;

		} elseif (($this->CI->config->item('captcha_case_sensitive', 'tank_auth') AND
				$code != $word) OR
				strtolower($code) != strtolower($word)) {
	
			return FALSE;
		}
		return TRUE;
	}
    
        

    /**
	 * Create reCAPTCHA JS and non-JS HTML to verify user as a human
	 *
	 * @return	string
	 */
    public function get_create_recaptcha()
    {
		$this->CI->load->helper('recaptcha');

		// Add custom theme so we can get only image
		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML
		$html = recaptcha_get_html($this->CI->config->item('recaptcha_public_key', 'tank_auth'), null, false);

		return $html;
	}

     /**
	 * Callback function. Check if reCAPTCHA test is passed.
	 *
	 * @return	bool
	 */
     public function check_recaptcha($response_field)
     {
         $post_data = http_build_query(
            array(
                'secret' => $this->CI->config->item('recaptcha_secret_key', 'tank_auth'),
                'response' => $response_field
            )
        );

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data
            )
        );
        $context  = stream_context_create($opts);
        $response = file_get_contents($this->CI->config->item('recaptcha_verify_link', 'tank_auth'), false, $context);
        $result = json_decode($response);
        if (!$result->success) {
            //$msg = "--Client Response: ".$response_field."\n--Recaptcha Error: ".$result->error-codes."\n--Hostname: ".$result->hostname;
            //error_log("invalid: \n". $msg, 3, "C:\log\log.txt");
            return FALSE;
        }
                
	return TRUE;
    }
     public function validate_email($email)
     {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
     }
     
     public function is_max_login_attempts_exceeded($login)
     {
         return $this->CI->tank_auth->is_max_login_attempts_exceeded($login);
     }
     public function activate_user($user_id, $new_email_key)
     {
         return $this->CI->tank_auth->activate_user($user_id, $new_email_key);
     }
     public function begin_logout()
     {
         return $this->CI->tank_auth->logout();
     }
     public function login($login, $password, $remember, $login_by_username, $login_by_email)
     {
          return $this->CI->tank_auth->login($login, $password, $remember, $login_by_username, $login_by_email);
     }
     public function get_phone_number($user_id)
     {
         //country by user id
         return $this->CI->tank_auth->get_phone_number($user_id);
     }
     public function get_country($user_id)
     {
         //country by user id
         return $this->CI->tank_auth->get_country($user_id);
     }
     public function get_error()
     {
         return $this->CI->tank_auth->get_error_message();
     }
     public function change_email($email)
     {
         return $this->CI->tank_auth->change_email($email);
     }
     public function forgot_password($login)
     {
         date_default_timezone_set('Asia/Kuala_Lumpur');
         if (!is_null($data = $this->CI->tank_auth->forgot_password($login))) {
             $data['site_name'] = $this->CI->config->item('website_name', 'tank_auth');
	 } else {
	     $errors = $this->CI->tank_auth->get_error_message();
             foreach ($errors as $k => $v){	
                  $data['errors'][$k] = $v;
             }
         }
         return $data;
     }
      public function reset_password($user_id, $new_pass_key, $new_password)
     {
            $data = NULL;
            date_default_timezone_set('Asia/Kuala_Lumpur');
            // Try to activate user by password key (if not activated yet)
            if ($this->CI->config->item('email_activation', 'tank_auth')) {
		$this->CI->tank_auth->activate_user($user_id, $new_pass_key, FALSE);
            }
            
            if (!$this->CI->tank_auth->can_reset_password($user_id, $new_pass_key)) {
                    $data["error"] = 'auth_message_new_password_failed';
            }
            elseif (!is_null($data = $this->CI->tank_auth->reset_password(
                                            $user_id, $new_pass_key,
                                            $new_password)))
            {	// success
                    $data['site_name'] = $this->CI->config->item('website_name', 'tank_auth');

            } else {														// fail
                    $data["error"] = 'auth_message_new_password_failed';
            }
            return $data;
     }
    
     public function change_password($old_password, $new_password, $user_id)
     {
           $data = NULL;
           date_default_timezone_set('Asia/Kuala_Lumpur');
           $success = $this->CI->tank_auth->change_password($old_password, $new_password, $user_id);
           
            if ($success)
            {	// success
                    $data['site_name'] = $this->CI->config->item('website_name', 'tank_auth');
                    //$data["error"] = 'enter success';
                    $data["result"] = 'enter success';

            } else {// fail
                    $data["error"] = 'enter failed';
            }
            return $data;
     }
     
     public function is_user_banned($user_id)
     {
         return $this->CI->tank_auth->is_userbanned($user_id);
     }
     
     public function get_user_id_by_email($email)
     {
         return $this->CI->tank_auth->get_userid_by_email($email);
     }
     
}


?>
