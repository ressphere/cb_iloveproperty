<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class isms
{
    private $username="ressphere";
    private $password="1234abcd*";
    private function ismscURL($link){

      $http = curl_init($link);
      curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);
      $http_result = curl_exec($http);
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
    
    public function send($destination, $message, $type=2)
    {
      $html_message = html_entity_decode($message, ENT_QUOTES, 'utf-8'); 
      $encoded_message = urlencode($html_message);
     
      $sender_id = urlencode("661013");
      
      $fp = "https://www.isms.com.my/isms_send.php";
      $fp .= "?un=$this->username&pwd=$this->password&dstno=$destination&msg=$encoded_message&type=$type&sendid=$sender_id";
      //echo $fp;
      
      $result = $this->ismscURL($fp);
      return $result;
    }
}
?>