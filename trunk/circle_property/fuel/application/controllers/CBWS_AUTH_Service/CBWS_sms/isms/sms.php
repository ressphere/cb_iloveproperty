<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class isms
{
    //private $username="ressphere2017";
    //private $password="1234abcd*";
    private $username="cornelius";
    private $password="123qwe";

    private function ismscURL($link){
      $http = curl_init($link);
      if (FALSE === $http)
        return 'failed to initialize';
      curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);
      $http_result = curl_exec($http);
      if (FALSE === $http_result)
        return curl_error($http). ":". curl_errno($http);
      curl_getinfo($http, CURLINFO_HTTP_CODE);
      curl_close($http);
      return $http_result;
    }
    public function getBalance()
    {
        $fp="http://isms.com.my/isms_balance.php?un=$this->username&pwd=$this->password";
        $result = $this->ismscURL($fp);
        return floatval($result);
    }
    
    public function BeginSendSms($destination, $message, $type=2)
    {
      $html_message = html_entity_decode($message, ENT_QUOTES, 'utf-8'); 
      $encoded_message = urlencode($html_message);
     
      $sender_id = urlencode("661013");
      
      $fp = "http://www.isms.com.my/isms_send.php";
      $fp .= "?un=$this->username&pwd=$this->password&dstno=$destination&msg=$encoded_message&type=$type&sendid=$sender_id";
      //echo $fp;
      
      $result = $this->ismscURL($fp);
      return $result !== FALSE;
    }
}
?>