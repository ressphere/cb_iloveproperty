<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'CBWS_Property/CBWS_AUTH_Property_Interface.php';
require_once 'CBWS_Member/CBWS_AUTH_Member_Interface.php';
require_once 'CBWS_Currency/CBWS_AUTH_Currency_Interface.php';
require_once 'CBWS_ressphere_home/CBWS_AUTH_Ressphere_Home_Interface.php';
require_once 'CBWS_sms/CBWS_AUTH_Sms_Interface.php';
require_once 'CBWS_Info_Interface.php';

class CBWS_AUTH_Service_Interface {
    
    /**
     * 
     * Authentication Service Main gateway
     *    Will select base on <Service Group Name> and divert them to corresponding service gateway
     * 
     * @param String request_command["service"] Contain choosed service that need to execute, prefix is <Service Group name>:<service name>
     * @param Array request_command["send_data"] Input data for service to process
     * 
     * @return Array ["status"] Indicate the status of service run (Error, complete or etc). ["status_information"] Message return for display purpose. ["data"] Output data from the service
     */
    public function Service_AUTH_Request($request_command)
    {
        // Use to contain return data or Error data if service not found
        $data_receive = array();
        
        // Retrieve service group, split to [0] is Service group and [1] is service name
        $service = explode(":",$request_command["service"]);
     
        // Select service group
        switch($service[0])
        {
            // Test AUTH gateway, not follow prefix
            case "test_auth_service":
                $data_receive["data"] = $request_command["send_data"];
                $data_receive["status"] = "Complete";
                $data_receive["status_information"] = "Info: Complete test_auth_service Service";
                break;
            case "CB_Property":
                $cb_property = new CBWS_AUTH_Property_Interface();
                $data_receive = $cb_property->Service_AUTH_Request($request_command);
                break;
            case "CB_Member":
                $cb_property = new CBWS_AUTH_Member_Interface();
                $data_receive = $cb_property->Service_AUTH_Request($request_command);
                break;
             case "CB_Ressphere_Home":
                $cb_home = new CBWS_AUTH_Ressphere_Home_Interface();
                $data_receive = $cb_home->Service_AUTH_Request($request_command);
                break;
            case "CB_Info":
                $cb_info = new CBWS_Info_Interface();
                $data_receive = $cb_info->Service_AUTH_Request($request_command);
                break;
            case "CB_Currency":
                $cb_info = new CBWS_AUTH_Currency_Interface();
                $data_receive = $cb_info->Service_AUTH_Request($request_command);
                break;
            case "CB_Sms":
                $cb_info = new CBWS_AUTH_Sms_Interface();
                $data_receive = $cb_info->Service_AUTH_Request($request_command);
                break;
            // No Group found for AUTH Service
            default:
                $data_receive["status"] = "Error";
                $data_receive["status_information"] = "Error: Service Group not provided hi ".$request_command["service"]." for".$service[0];
                $data_receive["auth_service_not_found"] = True;
         }
         
         // Data return
         return $data_receive;
    }
    
}

?>
