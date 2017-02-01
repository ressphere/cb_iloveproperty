<?php
require_once 'base.php';
require_once '_utils/GeneralFunc.php';
require_once '_utils/Whatsapp/PhoneUtils.php';
//require_once '_utils/Whatsapp/registerCode.php';
class PhoneRegistration extends base
{
    public function index()
    {
       $content = "Obtain whatsapp registration code";
       $title = "Get the 6 digit code";
       $this->SEO_Tags($content);
       
       $wsdl = $this->_get_wsdl_base_url();
       $this->extemplate->set_extemplate('page404_home');
	   $this->extemplate->write('title', $title);
       $this->extemplate->add_js($wsdl . 'js/jquery.easing.min.js', 'import', FALSE, FALSE);
         //cb_change_profile
       $this->extemplate->write_view('content', '_usercontrols/get_code',array() ,TRUE);
       
       $this->extemplate->render();
       
    }

    public function GetAccessCode()
    {
       if(isset($_POST['txtPhoneNo']))
       {
            $method = "sms";
            $PhoneUtilsObj = new PhoneUtils();
            $result = $PhoneUtilsObj->GetAccessCode($_POST["txtPhoneNo"], $method, FALSE);
            $this->GetPhonePassword($method . ": " . $result->status);
            
       }
       else
       {
           redirect(base_url() . '/index.php/PhoneRegistration/');
       }
    }
    
    public function GetPasswordDb()
    {
        $this->load->model('whatsapp_model');
        if(isset($_POST['txtPhoneNo']))
        {
            $username = $_POST['txtPhoneNo'];
            $query = $this->db->get_where('whatsapp', array('username' => $username), 1, 0);
            if($query->num_rows() > 0)
            {
                $code = $query->first_row()->access_code;
                $PhoneUtilsObj = new PhoneUtils();
                $result = $PhoneUtilsObj->GetAccessPassword($username, $code);
                if($result->status == 'ok')
                {
                    echo $result->pw;
                }
            }
            else
            {
                echo "No access code found";
            }
        }
        else
        {
             echo "No phone number provided";
        }
    }
    public function ShowPassword()
    {
           $this->GetPhonePassword("");
    }
    
    public function GetPassword()
    {
       $this->GetPhonePassword("");
       if(isset($_POST['txtPhoneNo']) && isset($_POST['txtAccessCode']))
       {
            $PhoneUtilsObj = new PhoneUtils();
            $result = $PhoneUtilsObj->GetAccessPassword($_POST["txtPhoneNo"], $_POST['txtAccessCode'], FALSE);
            if($result->status == 'ok')
            {
                echo $result->pw;
            }
       }
       else
       {
          $this->GetPhonePassword();
       }
    }
    
    private function GetPhonePassword($result)
    {
       $content = "Obtain Phone Password";
       $title = "Get the password";
       $this->SEO_Tags($content);
       
       $wsdl = $this->_get_wsdl_base_url();
       $this->extemplate->set_extemplate('page404_home');
	   $this->extemplate->write('title', $title);
       $this->extemplate->add_js($wsdl . 'js/jquery.easing.min.js', 'import', FALSE, FALSE);
         //cb_change_profile
       $this->extemplate->write_view('content', '_usercontrols/get_password',array('result'=>$result) ,TRUE);
       
       $this->extemplate->render();
    }
}

?>
