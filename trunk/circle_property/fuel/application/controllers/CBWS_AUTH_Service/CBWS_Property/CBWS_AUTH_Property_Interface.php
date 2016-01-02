<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'CB_Property_component.php';

class CBWS_AUTH_Property_Interface {
    
    /**
     * 
     * Authentication Propertyt Service Interface
     *    Will select base on <Service Name> and divert them to corresponding service gateway
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
        switch($service[1])
        {
            // Test AUTH gateway, not follow prefix
            case "test_service":
                $data_receive["data"] = $request_command["send_data"];
                $data_receive["status"] = "Complete";
                $data_receive["status_information"] = "Info: Complete CB_Property:test_auth_service Service";
                break;
            case "create_request":
                $property_component = new CB_Property_component(json_decode($request_command["send_data"],TRUE));
                $property_component->create_request();
                $data_receive = $property_component->status_return();
                break;
            case "search_filter_info":
                $property_component = new CB_Property_component();
                $query_data = $property_component->get_filter_data($request_command["send_data"]);
                $data_receive = $property_component->status_return();
                $data_receive["data"] = $query_data; // as the $data_recieve being overwrite by asserting status
                break;
            case "remove_data":
                $property_component = new CB_Property_component(json_decode($request_command["send_data"],TRUE));
                $property_component->remove_request();
                $data_receive = $property_component->status_return();
                break;
            case "get_package":
                $property_component = new CB_Property_package(json_decode($request_command["send_data"],TRUE));
                $query_data->get_package();
                $data_receive = $property_component->status_return();
                $data_receive["data"] = $query_data;
                break;
            // No Group found for AUTH Service
            default:
                $data_receive["status"] = "Error";
                $data_receive["status_information"] = "Error: Service not provided for ".$service[1];
                $data_receive["auth_service_not_found"] = True;
         }
         
         // Data return
         return $data_receive;
    }
    
}

?>
