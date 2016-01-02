<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CBWS_Service_Interface {
   
    /**
     * 
     * None Authentication Service Main gateway
     *    Will select base on <Service Group Name> and divert them to corresponding service gateway
     * 
     * @param String request_command["service"] Contain choosed service that need to execute, prefix is <Service Group name>:<service name>
     * @param Array request_command["send_data"] Input data for service to process
     * 
     * @return Array ["status"] Indicate the status of service run (Error, complete or etc). ["status_information"] Message return for display purpose. ["data"] Output data from the service
     */
    public function Service_NONE_AUTH_Request($request_command)
    {
        // Use to contain return data or Error data if service not found
        $data_receive = array();
        
        // Retrieve service group, split to [0] is Service group and [1] is service name
        $service = explode(":",$request_command["service"]);
        
        // Select service group
        switch($service[0])
        {
            // Test Non AUTH gateway, not follow prefix
            case "test_none_auth_service":
                $data_receive["data"] = $request_command["send_data"];
                $data_receive["status"] = "Complete";
                $data_receive["status_information"] = "Info: Complete test_none_auth_service Service";
                break;
            // No Group found for non AUTH Service
            default:
                $data_receive["status"] = "Error";
                $data_receive["status_information"] = "Error: Service Group not provided for non AUTH ".$service[0];
         }
         
         // Data return
         return $data_receive;
    }
}

?>
