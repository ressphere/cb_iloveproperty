<?php
require_once 'ChatAPI/Registration.php';

class PhoneUtils
{
    public function GetAccessPassword($username, $code, $debug=TRUE)
    {
        // Create a instance of Registration class.
        $r = new Registration($username, $debug);
        return $r->codeRegister($code);
    }
    
    public function GetAccessCode($username,  $method, $debug=TRUE)
    {
        // Create a instance of Registration class.
        $r = new Registration($username, $debug);
        //$r->checkCredentials();
        return $r->codeRequest($method); // could be 'voice' too
    }
    
    private function Login($username, $password, $nickname="ressphere", $debug=TRUE)
    {
        $w = new WhatsProt($username, $nickname, $debug);
        $w->connect(); // Connect to WhatsApp network
        $w->loginWithPassword($password); // logging in with the password we got!
        $w->sendGetPrivacyBlockedList(); // Get our privacy list [Done automatically by the API]
        $w->sendGetClientConfig(); // Get client config [Done automatically by the API]   
    }
    
    public function SendMessage($username, $password, $nickname="ressphere", $to, $msg, $debug=TRUE)
    {
        $this->Login($username, $password);
        $w->sendMessageComposing($to); // Send composing
        $w->pollMessage();
        $w->sendMessagePaused($to); // Send paused
        $w->pollMessage();
        $w->sendMessage($to, $msg); // Send message
        $w->pollMessage();
    }
    
}
//$r->codeRegister($code);