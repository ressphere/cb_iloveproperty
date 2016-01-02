<?php
require_once 'unit_test_main.php';

class CB_Member_unit_test extends unit_test_main
{
   function __construct() {
        parent::__construct();
        
        $current_file_name = pathinfo(__FILE__, PATHINFO_FILENAME);
        $this->benchmark_dump_file("\n".$current_file_name);
        
    }
   
   public function _unit_test_create_user() {
       
       $Members_Info["username"] = "chunmuntan82@gmail.com"; 
       $Members_Info["email"] = "chunmuntan82@gmail.com";
       $Members_Info["password"] = "1234abcd*";
       $Members_Info["phone"] = "(+60)0177002928"; 
       $Members_Info["email_activation"] = $email_activation = $this->config->item('email_activation', 'tank_auth');
       $val_return = $this->SendReceive_Service("CB_Member:create_member",  json_encode($Members_Info));
      
       //Expected output
       $return_data = json_decode($val_return, TRUE);
       $data["user_id"] = "";
       
       if (!is_null($return_data["data"]["result"]) &&
               key_exists("user_id", $return_data["data"]["result"]))
       {
           $data["user_id"] = $return_data["data"]["result"]["user_id"];
           if(!is_null($data["user_id"]))
           {
                $data["email"] = "jhtcmy2k@hotmail.com";
                $data["phone"] = "(+60)0177002928";
                $data["username"] = "";
           }
           else {
            $data["error"] = $return_data["data"]["result"]["error"];
          }
       }
       
       $golden_data["result"] = $data;
       $golden["service"] = "CB_Member:create_member";
       $golden["status"] = "Complete";
       $golden["status_information"] = "Info: Complete CB_Member:create member";
       $golden["data"] = $golden_data;
       
       $val_golden = json_encode($golden);
       
       $note = "Return value -- ". $val_return . "<br>";
       $note = $note."Golden value -- $val_golden";
       
       $this->unit->run($val_return, $val_golden, "Test CB_Property AUTH Send Recieved gateway", $note);

   }

   public function _unit_test_get_country_code()
   {
       $Country_Info["country"] = "Hong Kong";
       $val_return = $this->SendReceive_Service("CB_Member:get_state_codes", 
               json_encode($Country_Info));
       $val_golden["result"] = array(
                     "012",
                     "013",
                     "014",
                     "015",
                     "016",
                     "017",
                     "019",
                     "010",
                     "011",
                     "03",
                     "04",
                     "05",
                     "06",
                     "07",
                     "09",
                     "82",
                     "84",
                     "85",
                     "86",
                     "88",
                     "89"    
                 );
       $golden["service"] = "CB_Member:get_country_code";
       $golden["status"] = "Complete";
       $golden["status_information"] = "Info: Get country code";
       $golden["data"] = $val_golden;
       $note = "Return value -- ". $val_return . "<br>";
       $note = $note."Golden value -- ". json_encode($golden);
       $this->unit->run($val_return, json_encode($golden), "Test CB_Member get country code gateway", $note);
   }
   public function _unit_test_get_country_list()
   {
       $val_return = $this->Receive_Service("CB_Member:get_country_list");
      
       //Expected output
       $data["result"] = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
       $golden["service"] = "CB_Member:get_country_list";
       $golden["status"] = "Complete";
       $golden["status_information"] = "Info: Get country list";
       $golden["data"] = $data;
       
       $val_golden = json_encode($golden);
       
       $note = "Return value -- ". $val_return . "<br>";
       $note = $note."Golden value -- $val_golden";
       
       $this->unit->run($val_return, $val_golden, "Test CB_Member get country list", $note);
   }
    public function _unit_test_validate_email()
   {
       $mail["address"] = "chunmuntan@yahoo.com";
       $val_return = $this->SendReceive_Service("CB_Member:validate_email", 
               json_encode($mail));
      
       //Expected output
       $data["result"] = "chunmuntan@yahoo.com";
       $golden["service"] = "CB_Member:validate_email";
       $golden["status"] = "Complete";
       $golden["status_information"] = "Info: validate email";
       $golden["data"] = $data;
       
       $val_golden = json_encode($golden);
       
       $note = "Return value -- ". $val_return . "<br>";
       $note = $note."Golden value -- $val_golden";
       
       $this->unit->run($val_return, $val_golden, "Test CB_Member validate email", $note);
   }
    public function _unit_test_validate_invalid_email()
   {
       $mail["address"] = "chunmuntan";
       $val_return = $this->SendReceive_Service("CB_Member:validate_email", 
               json_encode($mail));
      
       //Expected output
       $data["result"] = FALSE;
       $golden["service"] = "CB_Member:validate_email";
       $golden["status"] = "Complete";
       $golden["status_information"] = "Info: validate email";
       $golden["data"] = $data;
       
       $val_golden = json_encode($golden);
       
       $note = "Return value -- ". $val_return . "<br>";
       $note = $note."Golden value -- $val_golden";
       
       $this->unit->run($val_return, $val_golden, "Test CB_Member validate invalid email", $note);
   }
    public function _unit_test_send_activate_email()
   {
       $email_prop["type"] = "activate"; 
       $email_prop["email"] = "chunmuntan@yahoo.com";
       $send_data['site_name'] = "ressphere.com";
       $send_data['activation_period'] = 3600 / 3600;

       $email_prop["data"] = $send_data;
       $val_return = $this->SendReceive_Service("CB_Member:send_email", 
               json_encode($email_prop));
      
       //Expected output
       $data["result"] = TRUE;
       $golden["service"] = "CB_Member:send_email";
       $golden["status"] = "Complete";
       $golden["status_information"] = "Info: send email";
       $golden["data"] = $data;
       
       $val_golden = json_encode($golden);
       
       $note = "Return value -- ". $val_return . "<br>";
       $note = $note."Golden value -- $val_golden";
       
       $this->unit->run($val_return, $val_golden, "Test CB_Member send activate email", $note);
   }
     public function _unit_test_send_welcome_email()
   {
       $email_prop["type"] = "welcome"; 
       $email_prop["email"] = "chunmuntan@yahoo.com";
       $send_data['site_name'] = "ressphere.com";
       //$data['activation_period'] = $this->CI->config->item('email_activation_expire', 'tank_auth') / 3600;

       $email_prop["data"] = $send_data;
       $val_return = $this->SendReceive_Service("CB_Member:send_email", 
               json_encode($email_prop));
      
       //Expected output
       $data["result"] = TRUE;
       $golden["service"] = "CB_Member:send_email";
       $golden["status"] = "Complete";
       $golden["status_information"] = "Info: send email";
       $golden["data"] = $data;
       
       $val_golden = json_encode($golden);
       
       $note = "Return value -- ". $val_return . "<br>";
       $note = $note."Golden value -- $val_golden";
       
       $this->unit->run($val_return, $val_golden, "Test CB_Member send welcome email", $note);
   }
   public function  _unit_test_get_captcha()
   {
       //get_create_captcha
        $val_return = $this->Receive_Service("CB_Member:get_create_captcha");
        $note = "Return value -- ". $val_return . "<br>";
        $val_golden = "";
        //$note = $note."Golden value -- $val_golden";
	$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_string', "Test CB_Member create captcha", $note);
   }
   public function  _unit_test_check_captcha()
   {
       //get_create_captcha
        $captcha_code["code"] = "Nd8DShkJ";
        $captcha_code["word"] = "Nd8DShkJ";
        $captcha_code["time"] = "0";
		$val_return = $this->SendReceive_Service("CB_Member:check_captcha", json_encode($captcha_code));
        $note = "Return value -- " .  $captcha_code["code"] . "=". $val_return . "<br>";
        //$note = $note."Golden value -- $val_golden";
		$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_bool', "Test CB_Member check captcha", $note);
   }
   
   public function  _unit_test_logout()
   {
       //get_create_captcha
        $val_return = $this->Receive_Service("CB_Member:begin_logout");
        $note = "Return value -- ".$val_return . "<br>";
        //$note = $note."Golden value -- $val_golden";
		$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_bool', "Test CB_Member test logout", $note);
   }
   public function _unit_test_activate_user()
   {
       $member["user_id"] = "";
       $member["new_email_key"] = "";
        
       $val_return = $this->SendReceive_Service("CB_Member:activate_user", json_encode($member));
       $note = "Return value -- ".$val_return . "<br>";
	   $data = json_decode($val_return, TRUE);
       $this->unit->run($data["data"]["result"], 'is_bool', "Test CB_Member test activate user", $note);
   }
   public function  _unit_test_is_login()
   {
       //get_create_captch
       $activated["result"] = TRUE;
        $val_return = $this->SendReceive_Service("CB_Member:is_login", 
                json_encode($activated));
        $note = "Return value -- ".$val_return . "<br>";
        //$note = $note."Golden value -- $val_golden";
		$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_bool', "Test CB_Member is login", $note);
   }
   
   public function _unit_test_get_user_id()
   {
        $val_return = $this->Receive_Service("CB_Member:get_user_id");
        $note = "Return value -- ".$val_return . "<br>";
        //$note = $note."Golden value -- $val_golden";
		$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_bool', "Test CB_Member is get user id", $note);
   }
   public function _unit_test_is_max_login_attempts_exceeded()
   {
        $login_parameters["login"] = "chunmuntan@yahoo.com";
        $val_return = $this->SendReceive_Service("CB_Member:is_max_login_attempts_exceeded",
                json_encode($login_parameters));
        $note = "Return value -- ".$val_return . "<br>";
		$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_bool', "Test CB_Member is max login", $note);
   }
   public function _unit_test_login()
   {
        $login_parameters["login"] = "chunmuntan@yahoo.com";
        $login_parameters["password"] = "1234abcd*";
        $login_parameters["remember"] = TRUE;
        $login_parameters["login_by_username"] = FALSE;
        $login_parameters["login_by_email"] = TRUE;
        $val_return = $this->SendReceive_Service("CB_Member:login", 
                json_encode($login_parameters));
         $note = "Return value -- ".$val_return . "<br>";
        //$note = $note."Golden value -- $val_golden";
		$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_bool', "Test CB_Member login", $note);
        
   }
   public function _unit_test_get_error()
   {
        $val_return = $this->Receive_Service("CB_Member:get_error");
        $note = "Return value -- ".$val_return . "<br>";
        //$note = $note."Golden value -- $val_golden";
		$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_array', "Test CB_Member is get user id", $note);
   }
   public function _unit_test_change_email()
   {
        $email["address"] = "jhtcmy2k@hotmail.com";
        $val_return = $this->SendReceive_Service("CB_Member:change_email",
                json_encode($email));
        $note = "Return value -- ".$val_return . "<br>";
        //$note = $note."Golden value -- $val_golden";
		$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_array', "Test CB_Member is get user id", $note);
       
   }
   public function _unit_test_recaptcha_check()
   {
       $captcha_code["remote_addr"] = '';
       $captcha_code["challenge_field"];
       $captcha_code["response_field"];
       $val_return = $this->SendReceive_Service("CB_Member:check_recaptcha",
                json_encode($captcha_code));
        $note = "Return value -- ".$val_return . "<br>";
        //$note = $note."Golden value -- $val_golden";
		$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_array', "Test CB_Member is get user id", $note);
   }
   public function _unit_test_reset_password()
   {
               $data["new_password"] = "1234";
        $data['user_id'] = "1";
        
        $data['new_pass_key'] = "9046ba45958301bbe17ae4a76212120d";
        
        $val_return = $this->SendReceive_Service("CB_Member:reset_password",
                json_encode($data));
        $note = "Return value -- ".$val_return . "<br>";
		$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_array', "Test CB_Member reset password", $note);

       
   }
    public function _unit_test_forgot_password()
   {
        $email["address"] = "chunmuntan@yahoo.com";
        $val_return = $this->SendReceive_Service("CB_Member:forgot_password",
                json_encode($email));
        
        echo date('Y-m-d H:i:s') . '</BR>';
        echo time();
        $note = "Return value -- ".$val_return . "<br>";
        //$note = $note."Golden value -- $val_golden";
		$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_array', "Test CB_Member forgot password", $note);
        $user_data = $data["data"]["result"];
   }
   //CB_Ressphere_Home:get_home_video
    public function _unit_test_get_home_video()
   {
       $val_return = $this->SendReceive_Service("CB_Ressphere_Home:get_home_video");
        $note = "Return value -- ".$val_return . "<br>";
        //$note = $note."Golden value -- $val_golden";
		$data = json_decode($val_return, TRUE);
        $this->unit->run($data["data"]["result"], 'is_array', "Test CB_Member is get user id", $note);
   }
   
   public function _unit_test_get_phone_number()
   {
       $user["user_id"] = 2;
       $val_return = $this->SendReceive_Service("CB_Member:get_user_phone_number", json_encode($user));
       $note = "Return value -- ".$val_return . "<br>";
       //$note = $note."Golden value -- $val_golden";
       $data = json_decode($val_return, TRUE);
       $this->unit->run($data["data"]["result"], 'is_string', "Test CB_Member get phone number", $note);
   }
   
   public function _unit_test_get_country_by_id()
   {
       $user["user_id"] = 2;
       $val_return = $this->SendReceive_Service("CB_Member:get_country", json_encode($user));
       $note = "Return value -- ".$val_return . "<br>";
       //$note = $note."Golden value -- $val_golden";
       $data = json_decode($val_return, TRUE);
       $this->unit->run($data["data"]["result"], 'is_string', "Test CB_Member get phone number", $note); 
   }
   
   public function test_list()
   {
       /*$this->_unit_test_get_country_code();
       $this->_unit_test_recaptcha_check();
       $this->_unit_test_get_home_video();
       $this->_unit_test_forgot_password();
       $this->_unit_test_reset_password();
       $this->_unit_test_create_user();
       $this->_unit_test_send_activate_email();
       $this->_unit_test_get_captcha();
        $this->_unit_test_check_captcha();
       $this->_unit_test_create_user();
       $this->_unit_test_get_country_code();
       $this->_unit_test_validate_email();
       $this->_unit_test_validate_invalid_email();
       $this->_unit_test_send_activate_email();
       $this->_unit_test_send_welcome_email();
       $this->_unit_test_get_country_list();
       $this->_unit_test_get_captcha();
       $this->_unit_test_check_captcha();
       $this->_unit_test_login();
       
       $this->_unit_test_is_login();
       $this->_unit_test_get_user_id();
       $this->_unit_test_logout();
       $this->_unit_test_is_max_login_attempts_exceeded();
       $this->_unit_test_activate_user();

       $this->_unit_test_get_error();
       $this->_unit_test_cbsw_service();*/
       $this->_unit_test_get_phone_number();
       $this->_unit_test_get_country_by_id();
       echo $this->unit->report();
   }
}
