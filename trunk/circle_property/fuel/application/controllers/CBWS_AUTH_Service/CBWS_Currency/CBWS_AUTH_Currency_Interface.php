<?php
require_once 'CBWS_Currency.php';

class CBWS_AUTH_Currency_Interface{
    
     public function Service_AUTH_Request($request_command)
     {
        // Use to contain return data or Error data if service not found
        $data_receive = array();
        
        // Retrieve service group, split to [0] is Service group and [1] is service name
        $service = explode(":",$request_command["service"]);
        $CB_Currency_Obj = new CBWS_Currency();
        $return_data["result"] = "";
        $info = "";
        $data_receive["status"] = "Complete";
        // Select service group
        switch($service[1])
        {
            // Test AUTH gateway, not follow prefix
            case "get_currency_list":
                $codes = $CB_Currency_Obj->get_supported_currency();
                $return_data["result"] = $codes;
                $info = "Info: Complete CB_Currency:get_currency_list";
                break;
            
            case "get_converted_currency_value":
                $codes = $CB_Currency_Obj->get_converted_currency_value($request_command["send_data"]);
                $return_data["result"] = $codes;
                $info = "Info: Complete CB_Currency:get_converted_currency_value";
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