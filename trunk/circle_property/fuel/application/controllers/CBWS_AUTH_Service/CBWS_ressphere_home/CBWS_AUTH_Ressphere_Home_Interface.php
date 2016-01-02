<?php
require_once 'CBWS_Ressphere_Home.php';

class CBWS_AUTH_Ressphere_Home_Interface{
    
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
	$CB_RS_Home_Obj = new CBWS_Ressphere_Home();
        switch($service[1])
        {
            // Test AUTH gateway, not follow prefix
            case "get_features_list":
                $data = $CB_RS_Home_Obj->get_features();
                $return_data["result"] = $data;
                $info = "Ressphere home page categories are returned";
                break;
            case "get_about_us":
                $data = $CB_RS_Home_Obj->get_content();
                $return_data["result"] = $data;
                $info = "Ressphere home page about us are returned";
                break;
            case "get_home_video":
                $data = $CB_RS_Home_Obj->get_home_video();
                $return_data["result"] = $data;
                $info = "Ressphere home page video are returned";
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