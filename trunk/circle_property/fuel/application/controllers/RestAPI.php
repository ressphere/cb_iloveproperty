<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "CBWS_Interface.php";

/**
 * Main entrance for the REST API
 * There is two part handling
 *    1. Auth entrance with encryption
 *    2. Non Auth entrance with clear text
 *
 * @author MingYeang
 */
class RestAPI extends CBWS_Interface {
    
    // Inherite parent constructor
    //   1. Profiling
    function __construct() {
        parent::__construct();
    }
    
    // Inherite parent destructor
    //   1. Profiling
    function __destruct() {
        parent::__destruct();
    }
    
    /*
     * Easy API to check and access Array value through key
     */
    private function _get_array_value($array, $key)
    {
        if(array_key_exists($key, $array))
        {
            return $array[$key];
        }
        return NULL;
    }
    
    /*
     * REST pre-handle
     *    1. Obtain argument
     *    2. Check AUTH
     *    3. Decrypt if required
     */
    private function _REST_Handle()
    {
        // Check encruption requirement
        if($this->_get_array_value($_GET,"AUTH") == true)
        {
            $request_command["AUTH"] = true;
            
            // restore the data from url code
            $url_data = $this->_get_array_value($_GET,"data");

            // Perform decryption, if clear text input, screw it
            $this->load->library('encrypt');
            $data_string_decrypt = json_decode($this->encrypt->decode($url_data), true);
            
            if($data_string_decrypt === NULL || $this->_fail_auth_check($data_string_decrypt))
            {
                $request_command["AUTH"] = false;
                $request_command["status"] = "Error";
                $request_command["status_information"] = "Error: Fail AUTH";
            }
        }
        else
        {
            $request_command["AUTH"] = false;
            $data_string = urldecode($_GET);
            $data_string_decrypt = json_decode($data_string, true);
        }
        
        // Obtain necessary data
        if($data_string_decrypt !== NULL)
        {
            $request_command["service"] = $this->_get_array_value($data_string_decrypt,"service");
            $request_command["send_data"] = $this->_get_array_value($data_string_decrypt,"send_data");
        }
        
        // Debug purpose
        //echo "<br> get: ".json_encode($_GET)."<br>";
        //echo "<br> result: ".json_encode($request_command)."<br>";
        
        return $request_command;
    }
    
    /*
     * Check AUTH user name and password
     */
    private function _fail_auth_check($data_array)
    {
        $checker = true;
        
        $user = $this->_get_array_value($data_array,"user");
        $password = $this->_get_array_value($data_array,"password");
        
        if($user == "root" && $password == "1234abcd*")
        {
            $checker = false;
        }
        
        return $checker;
    }
    
    /**
     * 
     * Circle Binding Service REST Send gateway
     *    Use for input data process, return process status only
     * 
     * @param String request_command["service"] Contain choosed service that need to execute, prefix is <Service Group name>:<service name>
     * @param Array request_command["send_data"] Input data for service to process
     * 
     * @return json_string ["service"] Name of the service perform. ["status"] Indicate the status of service run (Error, complete or etc). ["status_information"] Message return for display purpose.
     */
    public function Service_Send()
    { 
       $request_command = $this->_REST_Handle();
       $return_information = $this->invoke_service_interface($request_command,"Send"); 
       
       echo json_encode($return_information);
    }
    
    /**
     * 
     * Circle Binding Service REST Recieve gateway
     *    Return reuqested service data, not require input data for process
     * 
     * @param String request_command["service"] Contain choosed service that need to execute, prefix is <Service Group name>:<service name>
     * 
     * @return json_string ["service"] Name of the service perform. ["status"] Indicate the status of service run (Error, complete or etc). ["status_information"] Message return for display purpose. ["data"] Output data from the service
     */
    public function Service_Receive()
    {
       $request_command = $this->_REST_Handle();
       $return_information = $this->invoke_service_interface($request_command,"Receive"); 
       
       echo json_encode($return_information);
    }
    
    /**
     * 
     * Circle Binding Service REST Send and Recieve gateway
     *    Will perform input data process, thus return output form the service
     * 
     * @param String request_command["service"] Contain choosed service that need to execute, prefix is <Service Group name>:<service name>
     * @param Array request_command["send_data"] Input data for service to process
     * 
     * @return json_string ["service"] Name of the service perform. ["status"] Indicate the status of service run (Error, complete or etc). ["status_information"] Message return for display purpose. ["data"] Output data from the service
     */
    public function Service_SendReceive()
    {
       $request_command = $this->_REST_Handle();
       $return_information = $this->invoke_service_interface($request_command,"SendReceive"); 
       
       echo json_encode($return_information);
    }
    
    /**
     * 
     * REST Test gateway, to indicate the webservice is working fine
     * 
     * @param None $dummy_command Just an dummy input
     * @return Json_string  Message string for simple testing
     */
    public function CB_Test_Gateway()
    {
        $request_command = $this->_REST_Handle();
        
        // Benchmark purpose
        if ($this->dump_benchmark_file === True)
        {
            $data = "\tCB_Test_gateway";
            write_file($this->benchmark_dump_file, $data, 'a+');
            
        }
        
        if($request_command["AUTH"] == True)
        {
            echo json_encode("Test: Success to Authenticate the request by Webservice");
        }
        else
        {
            echo json_encode("Test: Failed to Authenticate the request by Webservice");
        }
    }
    
    
    
}

?>
