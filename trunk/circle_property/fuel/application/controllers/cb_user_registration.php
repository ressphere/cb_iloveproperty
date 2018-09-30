<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    require_once 'base.php';
    require_once '_utils/GeneralFunc.php';
    class cb_user_registration extends base
    {
        
        ####### This function will load the login page######################################
        ####### This function will return the html that will display the UI#################
        public function beginRegister()
        {
            
             $msg = "";
             $success = FALSE;
             $is_login = $this->_is_login();
             //$is_activated = $this->_is_login(FALSE);
             
             #start register to push to database
             if ($is_login) 
             {
                $msg = "<span class='error'>Please logout and login again</span>";
                //$this->_begin_logout();
             }
             else 
             {
                 # Get all of the parameters
                 $CI = & get_instance();
                 $CI->load->helper('url');
                 $CI->load->library('session');
                 $CI->load->config('tank_auth', TRUE);
                 $display_name = $this->_get_posted_value('display_name');
                 $email = $this->_get_posted_value('email');
                 $password = $this->_get_posted_value('password');
                 $repassword = $this->_get_posted_value('repassword');
                 $country = $this->_get_posted_value('country');
                 $area = $this->_get_posted_value('area');
                 $phone = $this->_get_posted_value('phone');
                
                 $term_condition = $this->_get_posted_value('term_condition');
                 $cap = $this->_get_posted_value('captcha');                 
                 $use_username = $this->config->item('use_username');
                 $email_activation = $this->config->item('email_activation');
                 
                 if(is_null($display_name) || $display_name === "")
                 {
                     $msg = "<span class='error'> Display name cannot be empty.</span>";
                 }
                 elseif(is_null($email) || !$this->_validate_email($email))
                 {
                     $msg = "<span class='error'> Email is not a valid format.</span>";
                     
                 }
                 elseif((is_null($password) || is_null($repassword)) || ($password != $repassword))
                 {
                     $msg = "<span class='error'>Password and confirmed password are not match</span>";
                 }
                 elseif((is_null($password) || is_null($repassword)) || strlen($password) <= 0)
                 {
                     $msg = "<span class='error'>Password cannot be empty</span>";
                 }
                 elseif(strlen($password) < 6 || strlen($password) > 12)
                 {
                     $msg = "<span class='error'>Password length must between 6 to 12 characters </span>";
                 }
                 elseif(is_null($area) || !is_numeric($area))
                 {
                     $msg = "<span class='error'>Area code must be number</span>";
                 }
                 elseif(is_null($phone) || !is_numeric($phone))
                 {
                     $msg = "<span class='error'>Phone must be number</span>";
                 }
                 elseif(is_null($term_condition) || $term_condition != "true")
                 {
                     $msg = "<span class='error'>Please understand and agree to the terms and conditions</span>";
                 }
                 elseif(is_null($cap) || $this->_check_recaptcha($cap) === FALSE)
                 {
                     $msg = "<span class='error'> Captcha checking fail, please retry</span>";
                     //$msg =  $this->config->item('website_name');
                 }
                 else
                 {
                     //Perform registration
                     $phone = $this->_getCorrectFormatPhone("($area)$phone", $country);
                     $Members_Info["username"] = $use_username ? $email : ''; 
                     $Members_Info["display_name"] = $display_name;
                     $Members_Info["email"] = $email;
                     $Members_Info["password"] = $password;
                     $Members_Info["phone"] = $phone;
                     $Members_Info["country"] = $country;
                     $Members_Info["email_activation"] = $this->config->item('email_activation');
                     $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:create_member",  json_encode($Members_Info));
      
                    
                     $return_data = json_decode($val_return, TRUE);
                     if (!is_null($return_data["data"]["result"]) && !array_key_exists("error", $return_data["data"]["result"])) 
                        {
                            $data = $return_data["data"]["result"];
                            $data['site_name'] =  $this->config->item('website_name');

                           if ($email_activation) {									// send "activate" email
				$data['activation_period'] = $this->config->item('email_activation_expire') / 3600;
				$this->_send_email('activate', $data['email'], $data);
                            } else {
				if ($this->config->item('email_account_details')) {	// send "welcome" email
                                        $this->_send_email('welcome', $data['email'], $data);
				}
                            }
                           $success = TRUE;
                           
                        }
                        else 
                        {
                            $errors = $return_data["data"]["result"]["error"];
                            if (isset($errors['phone'])) 
                            {
                                $msg = "<span class='error'>" . $phone . " is in used. Please try another phone</span>";
                            }
                            elseif (isset($errors['displayname'])) 
                            {
                                $msg = "<span class='error'> Reserved keyword or non-alphabetic/numberic character is found in " . $display_name . " Please try another name</span>";
                            }
                            elseif (isset($errors['username'])) 
                            {
                                $msg = "<span class='error'>" . $email . " is in used. Please try another email</span>";
                            }
                            elseif (isset($errors['email'])) 
                            {
                                $msg = "<span class='error'>" . $email . " is in used. Please try another email</span>";
                            }
                            elseif (isset($errors['banned'])) 
                            {
                                $msg = "<span class='error'>" . $login . " is banned from page.</span>";
                            } 
                            elseif (isset($errors['not_activated'])) 
                            {				// not activated user
                                $msg = "<span class='error'>" . $login . " is not activated.</span>";

                            } 
                            else
                            {
                                $msg = "<span class='error'> Fail to register user, please try again</span>";
                            }
                            //$msg = "<span class='error'> Fail to register user, please try again</span>";
                            $success = FALSE;
                        }

                 }
                 
                 
             }
             if ($success === FALSE)
             {
                $captcha_html = $this->_create_recaptcha();
                $data["captcha_html"] = $captcha_html;
                $data["msg"] = $msg;
                $this->_print(json_encode($data));
             }
             else
             {
                 $data["msg"] = "Success";
                 $this->_print(json_encode($data));
             }
        }
      
        public function registerView()
        {
            
            $this->_print($this->_registerView());
        }
        public function getAreaCode()
        {
            $country = $this->_get_posted_value("country");
            if(!is_null($country))
            {
                $this->_print(json_encode($this->_get_state_codes($country)));
            }
            else
            {
                $this->_print("");
            }
        }
        public function beginLogin()
        {
             $login = $this->_get_posted_value('username');
             $password = $this->_get_posted_value('password');
             $this->session->unset_userdata('activate_email');
             $remember=FALSE;
             $val_return = NULL;
             if(!is_null($login) && !is_null($password))
             {
                $is_login = $this->_is_login();
                //$is_activated = $this->_is_login(FALSE);
             
				
                if ($is_login) 
                {
                    $this->_print( "<span class='error'>Please logout and login again</span>");
                } 
                else 
                {
                    //Begin login here
                     $data['login_by_username'] = ($this->config->item('login_by_username') AND
                                                $this->config->item('use_username'));
                     $data['login_by_email'] = $this->config->item('login_by_email');
                     $data['use_recaptcha'] = $this->config->item('use_recaptcha');
                     $cap_success = true;
                     $msg = "Success";
                     $cap = $this->_get_posted_value('captcha');
                     $challenge = $this->_get_posted_value('challenge');
                     $login_parameters["login"] = $login;
                     $is_login_exceeded_json = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:is_max_login_attempts_exceeded",
                        json_encode($login_parameters));
                     $is_login_exceeded_data = json_decode($is_login_exceeded_json, TRUE);
		     $is_login_exceeded = $is_login_exceeded_data["data"]["result"];
                     if ($is_login_exceeded) {
                          //$recaptcha_html = $this->_create_recaptcha();
                          
                          if(is_null($cap) || is_null($challenge) || !$this->_check_recaptcha ($this->config->item('website_name', 'tank_auth'),
                                  $cap, $challenge))
                          {
                                
                                $cap_success = false;
                          }
                     }
                     $login_parameters["login"] = $login;
                     $login_parameters["password"] = $password;
                     $login_parameters["remember"] = $remember;
                     $login_parameters["login_by_username"] = $data['login_by_username'];
                     $login_parameters["login_by_email"] = $data['login_by_email'];
                     if($cap_success)
                     {
                        $val_return_json = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:login", 
                             json_encode($login_parameters));
                        $val_return_data = json_decode($val_return_json, TRUE);
			$val_return = $val_return_data["data"]["result"];
                     }
                    if ($cap_success === FALSE || (!is_null($val_return) && count($val_return) > 0 && $val_return[0] === FALSE)) 
                     {	
                        $errors = $val_return[count($val_return) - 1];
                        //$errors = json_decode($returned_error, TRUE)["data"]["result"];
                        if (isset($errors['banned'])) 
                        {
                             $msg = "<span class='error'>" . $login . " is banned from page.</span>";
                        } 
                        elseif (isset($errors['not_activated'])) 
                        {
                             // not activated user
                            $this->session->set_userdata(array('activate_email' => $login));

                            $html_link = "<a id='resend_activation' href=''>HERE</a>";
                            $msg = "<span class='error'>" . $login . " is not activated.</span><BR>";
                            $msg = $msg . "Please click " . $html_link . " to re-send activation";

                        } 
                        elseif(isset($errors['login']) || isset($errors['password'])) 
                        {	
                            // fail
                            $data['show_captcha'] = FALSE;
                            $msg = "<span class='error'>Invalid username or password<span>";
                        }
                        elseif($cap_success == false) {
                            $msg = "<span class='error'> Invalid image text, please retype</span>";
                        }
                        else {
                            $msg = "<span class='error'>Fail to login, please try again</span>";
                        }
                        //$this->_print('exceeded_login');
                        $this->_print($this->require_login_captcha($login, $msg));
                     }
                     else
                     {
                         $user_id = $val_return[1];
                         $username = $val_return[2];
                         $status = $val_return[3];
                         $displayname = $val_return[4];
                         $this->session->set_userdata(array(
								'user_id'	=> $user_id,
								'username'	=> $username,
								'status'	=> $status?TRUE:FALSE,
                                                                'displayname'   => $displayname
						));
                         //error_log("cb_user_registration - begin login \n", 3, "C:\log\log.txt");
                         //error_log("cb_user_registration - userid". $user_id ."\n", 3, "C:\log\log.txt");
                         $this->session->set_userdata('secure','1');
                         
                         $this->_print($msg);
                         
                     }
                    
                    
                }
            }
        }
       
       
        public function loginView()
        {
            
            $this->_print($this->_loginView());
        }

        public function forgotpassView()
        {
            
            $this->_print($this->_forgotpassView());
        }
       
        public function logoutView()
        {
            
            $this->_print($this->_logoutView());
        }
       
        public function activate()
        {
            //$this->extemplate->set_extemplate('default');
            $user_id		= $this->uri->segment(3);
            $new_email_key	= $this->uri->segment(4);
            $content = "Circle Properties activation";
            $title = "Activate my account";
            $this->SEO_Tags($content);
            $this->set_title($title);
            
            

            // Load wsdl base.js as the login related stuft is at there
            $this->wsdl = $this->session->userdata('wsdl_base_url');
            if($this->wsdl === FALSE)
            {
                $this->wsdl = $this->_get_wsdl_base_url();
                $this->session->set_userdata('wsdl_base_url', $this->wsdl);
            }
            $this->extemplate->add_css($this->wsdl . 'css/base.css', 'link', FALSE, FALSE);
            $this->extemplate->add_css($this->wsdl . 'css/bootstrap.min.css', 'link', FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl .'js/jquery.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl .'js/_utils/jquery.makeclass.min.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl . 'js/bootstrap-mit.min.js' , 'import', FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl . 'js/base.js', 'import', FALSE, FALSE);
            $this->extemplate->add_js($this->wsdl . 'js/cb_user_registration.js', 'import', FALSE, FALSE);
                 
           
            // Activate user
			$member["user_id"] = $user_id;
			$member["new_email_key"] = $new_email_key;
        
			$val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:activate_user", json_encode($member));
			$result = json_decode($val_return, TRUE);
			$result = $result["data"]["result"];
            if ($result) {		// success
                    GeneralFunc::CB_Receive_Service_Request("CB_Member:begin_logout");
                    $activate_content["msg"] = "<B>Congratulation</B> your account is activate, please proceed to login";
            } else {
                $activate_content["msg"] = "<B>Sorry</B> we fail to activate your account.";
            }
             if(!is_null($this->logo))
            {
                $activate_content["Logo"] = $this->logo;
            }
            $this->extemplate->write_view('contents', '_usercontrols/cb_user_registration', $activate_content, TRUE);
            $this->extemplate->render();
        }
        public function logout()
        {
            do{
                $this->_begin_logout();
            } while($this->_is_login());
            $this->_print("<B>Successfully Logout</B>. Thank you.");
        }
        public function isLogin()
        {
            if($this->_is_login())
            {
               $this->_print($this->_get_user_id());
            }
            else
            {
                $this->_print(-1);
            }
        }
        public function create_captcha()
        {
            $type = $this->_get_posted_value('type');
            $this->_print($this->_create_captcha($type));
        }
        
        public function resend_activation_email()
        {
            $mail = $this->session->userdata('activate_email');
            $msg = "Fail to send the activation email, please contact us for further assistance";
            if($mail)
            {
                $email["address"] = $mail;
                $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:change_email",
                    json_encode($email));
                $data = json_decode($val_return, TRUE);
                if(!is_null($data))
                {
                    $data = $data["data"]["result"];
                    $data['site_name'] =  $this->config->item('website_name');
                    $data['activation_period'] = $this->config->item('email_activation_expire') / 3600;
                    $mail_status = $this->_send_email('activate', $data['email'], $data);
                    if($mail_status)
                    {
                        $msg = "Activation email is sent to " . $mail . "<BR> Please check your <B>inbox</B> and <B>junk mail</B> to activate your account.";
                    }
                    else
                    {
                        $msg = "Activation email fail to send to " . $mail;
                    }
                }
                
            }
            $this->_print($msg);
        }
        
        public function begin_password()
        {
            $msg = "";
            $success = TRUE;
            $mail = $this->_get_posted_value('email');
            if(is_null($mail) || !$this->_validate_email($mail))
            {
                $msg = "<span class='error'> Email is not a valid format.</span>";
                $success = FALSE;
            }
            if($success)
            {
                $email["address"] = $mail;
                $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:forgot_password",
                    json_encode($email));
                $data = json_decode($val_return, TRUE);
				$data = $data["data"]["result"];
                if(!is_null($data) && !isset($data['errors']))
                {
                    $data['site_name'] =  $this->config->item('website_name');

                    // Send email with password activation link
                    $this->_send_email('forgot_password', $data['email'], $data);
                    $success = TRUE;
                    $msg = "Success";
                }
                else {
					if(is_null($data))
					{
						$msg = "<span class='error'>internal error data is null</span>";
					}
					else
					{
						$msg = "<span class='error'>Your email is not registered in our system.</span>";
					}
                    $success = FALSE;
                }
                
            }
            $data["msg"] = $msg;
            $this->_print(json_encode($data));
            
        }
        
        public function change_password()
        {
           $CI = & get_instance();
           $CI->load->helper('url');
           $CI->load->library('session');
           $CI->load->library('extemplate');
           
            $msg = "";
            $success = TRUE;
            $data = NULL;
            $change_pass_obj = NULL;
            $current_pass = $this->_get_posted_value('current_password');
            $pass = $this->_get_posted_value('password');
            $confirmed_pass = $this->_get_posted_value('confirmed_password');
            if( empty($pass))
            {
                $msg = "<span class='error'>ERROR:Password cannot be empty</span>";
                $success = FALSE;
            }
            elseif ( empty($current_pass)) 
            {
                $msg = "<span class='error'>ERROR:Current password cannot be empty</span>";
                $success = FALSE;
            }
            elseif ( empty($confirmed_pass)) 
            {
                $msg = "<span class='error'>ERROR:Confirmed password cannot be empty</span>";
                $success = FALSE;
            }
            elseif ($confirmed_pass !== $pass)
            {
                $msg = "<span class='error'>ERROR:Password does not match with confirmed password</span>";
                $success = FALSE;
            }
            
            if($success)
            {
                $change_pass_obj["new_password"] = $pass;
                $change_pass_obj["old_password"] = $current_pass;
               
                if(!$change_pass_obj && (!isset($change_pass_obj["old_password"]) || !isset( $change_pass_obj["new_password"])))
                {
                    $msg = var_dump($change_pass_obj);//$data['new_password'];
                    $success = FALSE;
                }
                else
                {
                    $data['old_password'] = $change_pass_obj["old_password"];
                    $data['new_password'] = $change_pass_obj["new_password"];
                }
            }
            if($success)
            {
                $data['user_id'] = $this->session->userdata('user_id');
                $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:change_password", json_encode($data));
                $data = json_decode($val_return, TRUE);
                $data = $data["data"]["result"];
                if(!is_null($data))
                {
                    $data['site_name'] = $CI->config->item('website_name');
                    if(isset($data["error"]))
                    {;
                        $success = FALSE;
                        $msg = "<span class='error'>ERROR:The existing password is NOT correct!!!</span>";
                        #$msg = "<span class='error'>" . var_dump($forgot_pass_obj) . "</span>";
                    }
                    else
                    {;
                        $success = TRUE;
                        $msg = "SUCCESS:You have successfully changed your password.";
                    }
                }
                else {
                    $msg = "<span class='error'>Your password cannot be reset, please check with the admin.</span>";
                    $success = FALSE;
                }
                
            }
            $data["msg"] = $msg;
            $data["status"] = $success;
            $this->_print(json_encode($data));
            
        }
        
         #/cb_user_registration/forgotpassword/
        public function forgotpassword()
        {
           $CI = & get_instance();
           $CI->load->helper('url');
           $CI->load->library('session');
           $CI->load->library('extemplate');
           $user_id		= $CI->uri->segment(3);
           $new_email_key	= $CI->uri->segment(4);
           if(strlen($new_email_key) < 32)
           {
               return;
           }
           #cache information
           $data['user_id'] = $user_id;
           $data['new_pass_key'] = $new_email_key;
           $CI->session->set_userdata("forgotpassword", $data);
           #$this->session->set_userdata("new_pass_key", $new_email_key);
           
           $content = "Circle Properties password retrieval";
            $title = "Reset my account password";
            $this->SEO_Tags($content);
            $this->set_title($title);
            
            $this->wsdl = $this->session->userdata('wsdl_base_url');
            if($this->wsdl === FALSE)
            {
                $this->wsdl = $this->_get_wsdl_base_url();
                $this->session->set_userdata('wsdl_base_url', $this->wsdl);
            }
            $CI->extemplate->add_css($this->wsdl . 'css/base.css', 'link', FALSE, FALSE);
            $CI->extemplate->add_css($this->wsdl . 'css/bootstrap.min.css', 'link', FALSE, FALSE);
            $CI->extemplate->add_css($this->wsdl . 'css/forgot_password.css', 'link', FALSE, FALSE);
            $CI->extemplate->add_js($this->wsdl .'js/jquery.min.js', 'import', FALSE, FALSE);
            $CI->extemplate->add_js($this->wsdl .'js/_utils/jquery.makeclass.min.js', 'import', FALSE, FALSE);
            $CI->extemplate->add_js($this->wsdl . 'js/bootstrap-mit.min.js' , 'import', FALSE, FALSE);
            $CI->extemplate->add_js($this->wsdl . 'js/base.js', 'import', FALSE, FALSE);
            $CI->extemplate->add_js($this->wsdl . 'js/cb_user_registration.js', 'import', FALSE, FALSE);
            $CI->extemplate->add_js($this->wsdl . 'js/cb_new_reset_password.js', 'import', FALSE, FALSE);
            
            $reset_content["Password"] = "Enter new password";
            $reset_content["ConfirmedPassword"] = "Confirm new password";
             if(!is_null($this->logo))
            {
                $reset_content["Logo"] = $this->logo;
            }
            //$this->session->userdata("forgotpassword", $data);
            $CI->extemplate->write_view('contents', '_usercontrols/cb_user_reset_password', $reset_content, TRUE);
            $this->_print($CI->extemplate->render('', TRUE));
            //echo $new_email_key; 
            //$this->session->set_userdata("forgotpassword", $data);
            
        }
        public function begin_reset_password()
        {
            $CI = & get_instance();
           $CI->load->helper('url');
           $CI->load->library('session');
           $CI->load->library('extemplate');
           
            $msg = "";
            $success = TRUE;
            $data = NULL;
            $forgot_pass_obj = NULL;
            $pass = $this->_get_posted_value('password');
            $confirmed_pass = $this->_get_posted_value('confirmed_password');
            if( empty($pass))
            {
                $msg = "<span class='error'>Password cannot be empty</span>";
                $success = FALSE;
            }
            elseif ( empty($confirmed_pass)) 
            {
                $msg = "<span class='error'>Confirmed password cannot be empty</span>";
                $success = FALSE;
            }
            elseif ($confirmed_pass !== $pass)
            {
                $msg = "<span class='error'>Password does not match with confirmed password</span>";
                $success = FALSE;
            }
            if($success)
            {
                $data["new_password"] = $pass;
                $forgot_pass_obj = $CI->session->userdata("forgotpassword");
                
                if(!$forgot_pass_obj && (!isset($forgot_pass_obj["user_id"]) || !isset( $forgot_pass_obj["new_pass_key"])))
                {
                    $msg = var_dump($forgot_pass_obj);//$data['new_pass_key'];
                    $success = FALSE;
                }
                else
                {
                    #$msg = var_dump($forgot_pass_obj);
                    $data['user_id'] = $forgot_pass_obj["user_id"];
                    $data['new_pass_key'] = $forgot_pass_obj["new_pass_key"];
                }
            }
           
            if($success)
            {
                
                $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Member:reset_password", json_encode($data));
                $data = json_decode($val_return, TRUE);
                $data = $data["data"]["result"];
                if(!is_null($data))
                {
                    $data['site_name'] = $CI->config->item('website_name');
                    if(isset($data["error"]))
                    {
                        $success = FALSE;
                        $msg = $data["error"];
                        #$msg = "<span class='error'>" . var_dump($forgot_pass_obj) . "</span>";
                    }
                    else
                    {
                        $success = TRUE;
                        $msg = "Success";
                    }
                }
                else {
                    $msg = "<span class='error'>Your password cannot been reset, please check with the admin.</span>";
                    $success = FALSE;
                }
                
            }
            $data["msg"] = $msg;
            $this->_print(json_encode($data));
            
        }
        public function get_wsdl_base_url()
        {
            $this->_print($this->_get_wsdl_base_url());
        }
        public function get_user_info()
        {
             $user_info = array('user_id'=>-1, 
                 'username'=>'');
             if($this->_is_login())
             {
                 
                 $user_info['user_id'] = $this->_get_user_id();
                 $user_info['username'] = $this->_get_username();
             }
             $this->_print(json_encode($user_info));
        }
        
    }
?>
