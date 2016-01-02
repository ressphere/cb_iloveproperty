<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "CBWS_Interface.php";

class main extends CBWS_Interface {
    // For SOAP purpose
    private $server = NULL;
    
    // Auth purpose
    protected $Auth = False;
    
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
    
    // To check whether the caller have Auth
    //    ** Dono how this able to work as no caller found
    public function AuthHeader($Header)
    {
        if($Header->username == 'root' && $Header->password == hash('md5', '1234abcd*'))
            $this->Auth = true;
    }

    
    public function index() {
            echo '<?xml version ="1.0" encoding ="UTF-8" ?>';
            // turn off the wsdl cache
            ini_set('soap.wsdl_cache_enabled', '0');
            
          
            $this->server = new SoapServer('cb_main.wsdl', array(
                    'trace' => 0,
                    'exceptions'   => 0,
                    'style'         => SOAP_DOCUMENT,
                    'use'         => SOAP_LITERAL,
                    'soap_version'   => SOAP_1_2,
                    'encoding'      => 'UTF-8'
            ));
            
            
            $this->server->setObject($this);
            $this->server->handle();
            
    }
    
    /**
     * 
     * Insert addtional information require for servvice process
     *   Currently item assert are
     *      1. AUTH - Indicating the caller have authentication or not
     *   
     * @access private
     * 
     * @param Array request_command Array that going to pass to service gateway
     * @return Array request_command With new key and value assert
    */
    private function information_insert($request_command)
    {
        // Authenticate to specified service to be requested
        if($this->Auth == True)
        {
            $request_command["AUTH"] = TRUE;
        }
        else
        {
            $request_command["AUTH"] = FALSE;
        }
        
        return $request_command;
    }
    
    /**
     * 
     * Circle Binding Service Send gateway
     *    Use for input data process, return process status only
     * 
     * @param String request_command["service"] Contain choosed service that need to execute, prefix is <Service Group name>:<service name>
     * @param Array request_command["send_data"] Input data for service to process
     * 
     * @return json_string ["service"] Name of the service perform. ["status"] Indicate the status of service run (Error, complete or etc). ["status_information"] Message return for display purpose.
     */
    public function _CB_Service_Send($request_command)
    { 
       $request_command = $this->information_insert($request_command);
       $return_information = $this->invoke_service_interface($request_command,"Send"); 
       
       return json_encode($return_information);
    }
    
    /**
     * 
     * Circle Binding Service Recieve gateway
     *    Return reuqested service data, not require input data for process
     * 
     * @param String request_command["service"] Contain choosed service that need to execute, prefix is <Service Group name>:<service name>
     * 
     * @return json_string ["service"] Name of the service perform. ["status"] Indicate the status of service run (Error, complete or etc). ["status_information"] Message return for display purpose. ["data"] Output data from the service
     */
    public function _CB_Service_Receive($request_command)
    {
       $request_command = $this->information_insert($request_command);
       $return_information = $this->invoke_service_interface($request_command,"Receive"); 
       
       return json_encode($return_information);
    }
    
    /**
     * 
     * Circle Binding Service Send and Recieve gateway
     *    Will perform input data process, thus return output form the service
     * 
     * @param String request_command["service"] Contain choosed service that need to execute, prefix is <Service Group name>:<service name>
     * @param Array request_command["send_data"] Input data for service to process
     * 
     * @return json_string ["service"] Name of the service perform. ["status"] Indicate the status of service run (Error, complete or etc). ["status_information"] Message return for display purpose. ["data"] Output data from the service
     */
    public function _CB_Service_SendReceive($request_command)
    {
       $request_command = $this->information_insert($request_command);
       $return_information = $this->invoke_service_interface($request_command,"SendReceive"); 
       
       return json_encode($return_information);
    }
    
    /**
     * 
     * Test gateway, to indicate the webservice is working fine
     * 
     * @param None $dummy_command Just an dummy input
     * @return Json_string  Message string for simple testing
     */
    public function _CB_Test_Gateway($dummy_command)
    {
        // Benchmark purpose
        if ($this->dump_benchmark_file === True)
        {
            $data = "\tCB_Test_gateway";
            write_file($this->benchmark_dump_file, $data, 'a+');
            
        }
        
        if($this->Auth == True)
        {
            return json_encode("Test: Success to Authenticate the request by Webservice");
        }
        else
        {
            return json_encode("Test: Failed to Authenticate the request by Webservice");
        }
    }
    
    
}


?>