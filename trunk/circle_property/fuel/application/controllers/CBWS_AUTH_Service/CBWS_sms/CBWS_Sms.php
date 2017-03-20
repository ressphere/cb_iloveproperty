<?php		
 require_once 'isms/sms.php';		
 class CBWS_Sms {		
     private $sms_obj = NULL;		
     public function __construct() {		
         $this->sms_obj = new isms();		
     }		
     		
     public function SendSms($destination, $message, $type=2)		
     {		
         if($this->sms_obj->getBalance() > 0)		
         {		
             return $this->sms_obj->BeginSendSms($destination, $message, $type);		
         }		
         return false;		
     }		
     		
     public function CheckBalance()		
     {		
         return $this->sms_obj->getBalance();		
     }		
 }