<?php		
 require_once 'CBWS_Sms.php';		
 		
 class CBWS_AUTH_Sms_Interface{		
     		
      public function Service_AUTH_Request($request_command)		
      {		
         // Use to contain return data or Error data if service not found		
         $data_receive = array();		
         		
         // Retrieve service group, split to [0] is Service group and [1] is service name		
         $service = explode(":",$request_command["service"]);		
 				
         		
         $return_data["result"] = "";		
         $info = "";		
         $data = "";		
         $data_receive["status"] = "Complete";		
 	$CBWS_Sms_Obj = new CBWS_Sms();		
         switch($service[1])		
         {		
             // Test AUTH gateway, not follow prefix		
             case "send_sms":		
                 $sms_info = json_decode($request_command["send_data"],TRUE);		
                 $data = $CBWS_Sms_Obj->SendSms($sms_info["destination"], $sms_info["message"]);		
                 $return_data["result"] = $data;		
                 $info = "Ressphere send sms ";		
                 break;		
          }		
          $data_receive["data"] = $return_data;		
          $data_receive["status_information"] = $info;		
          // Data return		
          return $data_receive;		
      }		
 } 