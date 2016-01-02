<?php
require_once 'CBWS_Member.php';

class CBWS_AUTH_Member_Interface{
    
     public function Service_AUTH_Request($request_command)
     {
        // Use to contain return data or Error data if service not found
        $data_receive = array();
        
        // Retrieve service group, split to [0] is Service group and [1] is service name
        $service = explode(":",$request_command["service"]);
        $CB_Member_Obj = new CBWS_Member();
        $return_data["result"] = "";
        $info = "";
        $data_receive["status"] = "Complete";
        // Select service group
        switch($service[1])
        {
            // Test AUTH gateway, not follow prefix
            case "get_state_codes":
                $Country_Info = json_decode($request_command["send_data"],TRUE);
                $codes = $CB_Member_Obj->get_state_codes($Country_Info["country"]);
                $return_data["result"] = $codes;
                $info = "Info: Complete CB_Member:get_state_code";
                break;
            case "create_member":
                //$data_receive["data"] = $request_command["send_data"];
                $Members_Info = json_decode($request_command["send_data"],TRUE);
                $result = $CB_Member_Obj->create_user(
                        $Members_Info["username"],
                        $Members_Info["display_name"],
                        $Members_Info["email"], 
                        $Members_Info["password"], 
                        $Members_Info["phone"], 
                        $Members_Info["email_activation"],
                        $Members_Info["country"]);
                $data["user_id"] = null;
                if(!is_null($result))
                {
                    $data["user_id"] = $result["user_id"];
                    $data["email"] = $result["email"];
                    $data["phone"] = $result["phone"];
                    $data["username"] = $result["username"];
                    $data["new_email_key"] = $result["new_email_key"];
                }
                else
                {
                    $data["error"] = $CB_Member_Obj->get_error();
                }
                $return_data["result"] = $data;
                $info = "Info: Complete CB_Member:create member";
                break;
            case "is_max_login_attempts_exceeded":
                $Members_Info = json_decode($request_command["send_data"],TRUE);
                $login = $Members_Info["login"];
                $data = $CB_Member_Obj->is_max_login_attempts_exceeded($login);
                $return_data["result"] = $data;
                $info = "Info: Check is maxlogin attempts exceeded for " . $login;
                break;
            case "activate_user":
                $Members_Info = json_decode($request_command["send_data"],TRUE);
                $user_id = $Members_Info["user_id"];
                $new_email_key = $Members_Info["new_email_key"];
                $return_data["result"] = $CB_Member_Obj->activate_user($user_id, $new_email_key);
                $info = "Info: Check is activated user for " . $user_id;
                break;
            case "login":
                $login_parameters = json_decode($request_command["send_data"],TRUE);
                //$login, $password, $remember, $login_by_username, $login_by_email
                $result = $CB_Member_Obj->login(
                        $login_parameters["login"], 
                        $login_parameters["password"], 
                        $login_parameters["remember"], 
                        $login_parameters["login_by_username"], 
                        $login_parameters["login_by_email"]);
                if($result[0] == FALSE)
                {
                    array_push($result, $CB_Member_Obj->get_error());
                }
                $return_data["result"] = $result;
                $info = "Info: Complete CB_Member:login";
                break;
            case "get_country_code":
                //$data_receive["data"] = $request_command["send_data"];
                $Country_Info = json_decode($request_command["send_data"],TRUE);
                $return_data["result"] = $CB_Member_Obj->get_country_code($Country_Info["country"]);
                $info = "Info: Get country code";
                break;
            case "get_user_phone_number":
                $user_info = json_decode($request_command["send_data"],TRUE);
                $return_data["result"] = $CB_Member_Obj->get_phone_number($user_info["user_id"]);
                $info = "Info: Get user phone number";
                break;
                
            case "get_country_list":
                $return_data["result"] = $CB_Member_Obj->get_country_list();
                $info = "Info: Get country list";
                break;
            case "get_create_captcha":
                $return_data["result"] = $CB_Member_Obj->get_create_captcha();
                $info = "Info: create captcha";
                break;
	    case "get_create_recaptcha":
                $result = $CB_Member_Obj->get_create_recaptcha();
                $result = str_replace(array("\n", "\t"),"", $result);
                
                $return_data["result"] = htmlentities($result);
                $info = "Info: create re-captcha";
                break;
			
            case "check_captcha":
                $captcha_code = json_decode($request_command["send_data"],TRUE);
                $return_data["result"] = $CB_Member_Obj->check_captcha($captcha_code["code"], 
                        $captcha_code["time"],
                        $captcha_code["word"]);
                $info = "Info: check captcha";
                break;
            case "check_recaptcha":
                $captcha_code = json_decode($request_command["send_data"],TRUE);
                $return_data["result"] = $CB_Member_Obj->check_recaptcha($captcha_code["remote_addr"], 
                        $captcha_code["challenge_field"],
                        $captcha_code["response_field"]);
                $info = "Info: check captcha";
                break;
            case "validate_email":
                $mail = json_decode($request_command["send_data"],TRUE);
                $return_data["result"] = $CB_Member_Obj->validate_email($mail["address"]);
                $info = "Info: validate email";
                break;
            case "begin_logout":
                $return_data["result"] = $CB_Member_Obj->begin_logout();
                $info = "Info: begin logout";
                break;
            case "change_email":
                $mail = json_decode($request_command["send_data"],TRUE);
                
                $return_data["result"] = $CB_Member_Obj->change_email($mail["address"]);
                $info = "Info: begin change email";
                break;
            case "forgot_password":
                $user_data = json_decode($request_command["send_data"], TRUE);
                
                $return_data["result"] = $CB_Member_Obj->forgot_password($user_data["address"]);
                $info = "Info: begin forgot password";
                break;
            case "reset_password":
                $user_data = json_decode($request_command["send_data"], TRUE);          
                $return_data["result"] = $CB_Member_Obj->reset_password($user_data['user_id'], 
                        $user_data['new_pass_key'], 
                        $user_data['new_password']);
                $info = "Info: begin reset password";
                break;
            case "change_password":
                $user_data = json_decode($request_command["send_data"], TRUE);          
                $return_data["result"] = $CB_Member_Obj->change_password($user_data['old_password'], 
                                                                         $user_data['new_password'],
                                                                         $user_data['user_id']);
                $info = "Info: begin change password";
                break;
            case "get_country":
                $user_data = json_decode($request_command["send_data"], TRUE);          
                $return_data["result"] = $CB_Member_Obj->get_country($user_data['user_id']);
                $info = "Info: get related user's country name";
                break;
            default:
                $data_receive["status"] = "Error";
                $info = "Error: Member service not provided for ".$service[1];
                $data_receive["auth_service_not_found"] = True;
         }
         $data_receive["data"] = $return_data;
         $data_receive["status_information"] = $info;
         // Data return
         return $data_receive;
     }
}