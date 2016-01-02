<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'CBWS_AUTH_Service/CBWS_AUTH_Service_Interface.php';
require_once 'CBWS_Service/CBWS_Service_Interface.php';


class CBWS_Interface extends CI_Controller {

    // For profiling
    protected $dump_benchmark_file = false;
    protected $benchmark_dump_file = NULL;
    
    function __construct() {
        parent::__construct();

        // For benchmark (profiler) to keep track total execute time
        //    Able to disable through "application/config/MY_config.php"
        $this->config->load("MY_config");
        
        $this->dump_benchmark_file = false;
        // Change to this if perfunction benchmark without SOAP or REST gateway is required
        //$this->dump_benchmark_file = $this->config->item('dump_benchmark_file') ;
        
        if ($this->dump_benchmark_file  === True)
        {
            // Use for file access and writing
            $this->load->helper('file');
        
            // Begin benchmark tagging with "ws_code_start"
            $this->benchmark->mark("ws_code_start");
            $this->benchmark_dump_file =dirname(dirname(__FILE__))."../../../assets/benchmark_file.txt";
        }
    }
    
    function __destruct() {
        if ($this->dump_benchmark_file === True)
        {
            // End of Benchmark tagging with "ws_code_end"
            $this->benchmark->mark("ws_code_end");
            
            $data = "\t - " . $this->benchmark->elapsed_time('ws_code_start', 'ws_code_end'). "\n";
            write_file($this->benchmark_dump_file, $data, 'a+');
            
        }
    }
    
    function _base_url()
    {
        $protocol = $_SERVER['HTTPS'] ? "https" : "http";
        return $protocol . "://" . $_SERVER['HTTP_HOST'] . '/';
    }
    
    /*
     * List of the service group supported
     *    This list will use for check the supported service group
     * 
     * @Return Array Supported service group
     */
    private function service_group_list()
    {
        // Service group name must match with the file class/file name
        // Serivce group list content mean
        //    - TRUE = enable
        //    - FALSE = Disable or deactivate
        $service_gorup = array(
            // To test the usability of base class
            "CBWS_Service_Base" => TRUE,
            
            // Supported service group (case sensetive)
            "CB_Payment_Paypal" => TRUE,
            "CB_Property" => TRUE
        );
        
        return $service_gorup;
    }
    
    /**
     * 
     * Service gateway, entry point for all the services
     *   
     * @access public
     * 
     * @param String request_command["service"] Contain choosed service that need to execute, prefix is <Service Group name>:<service name>
     * @param Bool request_command["AUTH"] Indicate have authentication or not, which will perform check on non AUTH area of obtaining False
     * @param Array request_command["send_data"] Input data for service to process
     * 
     * @return Array ["status"] Indicate the status of service run (Error, complete or etc). ["status_information"] Message return for display purpose. ["data"] Output data from the service
    */
    private function _Service_request($request_command)
    {
        $return_information = NULL;
        
        if (array_key_exists("service", $request_command))
        {
            $service_group_list = $this->service_group_list();
            $service = explode(":",$request_command["service"]);
            $service_group = $service[0];

            if(array_key_exists($service_group, $service_group_list) && $service_group_list[$service_group] === TRUE)
            {
                require_once "CBWS_Service/".$service_group.".php";
                $service_group_obj = new $service_group();
                $return_information = $service_group_obj->invoke_service($request_command);
            }
            else
            {
                // Check AUTH to see any service hit for request
                if(array_key_exists("AUTH", $request_command) && $request_command["AUTH"] == TRUE)
                {
                    $cbws_auth_service_interface = new CBWS_AUTH_Service_Interface();
                    $return_information = $cbws_auth_service_interface->Service_AUTH_Request($request_command);
                }

                // Check NON-AUTH area to see any service hit for request when AUTH area not found or don't have AUTH right
                if (array_key_exists("auth_service_not_found", $return_information) || $request_command["AUTH"] == FALSE)
                {
                    $cbws_service_interface = new CBWS_Service_Interface();
                    $return_information = $cbws_service_interface->Service_NONE_AUTH_Request($request_command);
                }
            }
        }
        else
        {
            // Error Information insert for missing service key
            $return_information["status"] = "Error";
            $return_information["status_information"] = "Error: Missing service selection";
        }
        
        return $return_information;
    }
    
    
    /**
     * 
     * Service interfae invoker, thus perform data filter and return necessary information
     *   
     * @access private
     * 
     * @param String request_command["service"] Contain choosed service that need to execute, prefix is <Service Group name>:<service name>
     * @param Bool request_command["AUTH"] Indicate have authentication or not, which will perform check on non AUTH area of obtaining False
     * @param Array request_command["send_data"] Input data for service to process
     * @param String type Service type ("Send", "Receive", "SendRecieve")
     * 
     * @return Array ["service"] Name of the service perform. ["status"] Indicate the status of service run (Error, complete or etc). ["status_information"] Message return for display purpose. ["data"] Output data from the service
    */
    protected function invoke_service_interface($request_command,$type)
    {
        // Choice of data send
        $data_send["service"] = $request_command["service"];
        $data_send["AUTH"] = $request_command["AUTH"];
        
        if ($type == "Send" || $type == "SendReceive")
        {
            $data_send["send_data"] = $request_command["send_data"];
        }
        else
        {
            $data_send["send_data"] = NULL;
        }
        
        if (!array_key_exists("status",$request_command))
        {
            // Invoke Service
            $service_information = $this->_Service_request($data_send); 
            
            // Choose data to return
            $return_information["service"] = $request_command["service"];
            $return_information["status"] = $service_information["status"];
            $return_information["status_information"] = $service_information["status_information"];

            // Benchmark purpose
            if ($this->dump_benchmark_file === True)
            {
                $data = "\t" . $return_information["service"];
                write_file($this->benchmark_dump_file, $data, 'a+');

            }

            if ($type == "Receive" || $type == "SendReceive")
            {
                $return_information["data"] = $service_information["data"];
            }
        }
       
        return $return_information;
        //return $service_information;
    }
        
    
}

?>
