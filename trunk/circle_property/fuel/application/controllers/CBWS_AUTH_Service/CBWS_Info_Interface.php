<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    class CBWS_Info_Interface {
     public function get_base_url()
     {
         return base_url();
     }
     public function Service_AUTH_Request($request_command)
     {
        // Use to contain return data or Error data if service not found
        $data_receive = array();
        
        // Retrieve service group, split to [0] is Service group and [1] is service name
        $service = explode(":",$request_command["service"]);
        $return_data["result"] = "";
        $info = "";
        $data_receive["status"] = "Complete";
        // Select service group
        switch($service[1])
        {
            // Test AUTH gateway, not follow prefix
            case "base_url":
                $return_data['result'] = $this->get_base_url();
                $info = "Web service base url is returned";
                break;
         }
         $data_receive["data"] = $return_data;
         $data_receive["status_information"] = $info;
         // Data return
         return $data_receive;
     }
      
    }
?>
