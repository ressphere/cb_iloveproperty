<?php

/*
 * This class provide all necessary generic function for libraries.
 * 
 * Provide following capability:
 *  1. Information handle
 *      a. Error handler
 *      b. Return data handler
 * 
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class cb_base_libraries extends CI_Controller{
 //--------------------- Global Variable ----------------------
    // Error message
    public $is_error = FALSE;
    public $dev_error_msg = "";
    public $usr_error_msg = "";
    public $error_code = "";
    
    // For unit test purpose
    public $status_information = "Info: Constructor invoke only";

    // Return data
    public $return_data = "";
    
    // Library name for database query and error message
    public $library_name = "none_and_is_error";
    public $library_code = "LBE-NON";
    
    // Service invoke flag
    public $library_service_invoke_flag = FALSE;
    
    //--------------------- Setup Function -------------------------------------
    /*
     * Constructor 
     */
    public function __construct()
    {
        // Invoke parent constrcutor
        //parent::__construct();
        $this->CI =& get_instance();
        
        // 1. For benchmark (profiler) to keep track total execute time
        //    Able to disable through "application/config/MY_config.php"
        // 2. For Error switching purpose
        //$this->CI =& get_instance();
        $this->CI->config->load("MY_config");
        //$this->config->load("MY_config");
    }

    //---------- Service invoke, for direct flow in ----------------------------
    /*
     * This API handle the invoke of service within the library, main entries
     *    1. Check if the service exist
     *       a. Error if service not found
     *       b. Error if service need auth but no auth
     *    2. Invoke service
     * 
     * @Param String request_command["service"] Contain choosed service that need to execute, prefix is <Service Group name>:<service name>
     * @Param Array request_command["send_data"] Input data for service to process
     * @Param Bool request_command["AUTH"] Indicate have authorization or not
     * 
     */
    public function library_direct_service_invoke($request_command)
    {
        
         // Check through the service list
        $library_name = $this->_library_search_service($request_command["service"], $request_command["AUTH"]);
        
        if($this->library_service_invoke_flag === TRUE)
        {
            // Invoke Service function
            $this->$library_name($request_command["send_data"]);
        }
        
    }
    
    /*
     * Contain list of serivce supported with auth - default empty
     * Service list content mean
     *     - True = Require AUTH
     *     - FALSE = Not require AUTH
     * 
     * @Return Array list of auth servie
     */
    public function library_service_list()
    {
        $service_list = array(
            //"test_service"  => TRUE,
        );
        return $service_list;
    }
            
    /*
     * Search service list to see is the service supported
     * 
     * @Param String Full Service name
     */
    private function _library_search_service($service_command, $AUTH)
    {
        // Retrieve service group, split to [0] is Service group and [1] is service name
        $service = explode(":",$service_command);
        $extract_service = $service[1];
        $service_list = $this->library_service_list();
        
        // Check list to see any hit avaliable
        if(array_key_exists($extract_service, $service_list))
        {
            
            // Got hit, hurray...
            $require_auth = $service_list[$extract_service];
            
            // Check AUTH requirement
            if ($require_auth === TRUE && $AUTH === FALSE)
            {
                // Error if no AUTH provided
                $this->set_error(
                        "CBL-".$this->library_code."-SC-1", 
                        "Require authentication for $service_command",
                        "Hit AUTH service for $service_command but no AUTH detected for ".$this->library_name);
            }
            else
            {
                $this->library_service_invoke_flag = TRUE;
            }
            
            // Pass AUTH check or no AUTH required
            return $extract_service;
        }
        
        return "";
    }
    
    //---------- Error and Return Data Handler Function ------------------------
    
    /*
     * API to handle error message
     * 
     * @param String Error code to know the location better (e.g. p-1 is property first error)
     * @param String Error string that display to customer 
     * @param String Detai error string that display for development purpose
     */
    protected function set_error($error_code, $usr_err_msg, $dev_err_msg)
    {
        $this->is_error = TRUE;
        $this->dev_error_msg = $dev_err_msg;
        $this->usr_error_msg = $usr_err_msg;
        $this->error_code = $error_code;
    }
    
    /*
     * API to set the return data and status information
     * 
     * @param String Status information
     * @param Jason data that will pass back to caller
     */
    protected function set_data($status_info, $data)
    {
        $this->status_information = $status_info;
        $this->return_data  = $data;
    }
    
    /*
     * API to set current obj error when the previous obj execution hit error
     * The validate object must have the same error handler
     * 
     * @param String Status information
     */
    protected function validate_return_data($data_obj)
    {
        // Transfer the error message when previous object execution fail
        if($data_obj->is_error === true)
        {
            $status_data = $data_obj->get_return_data_set();
            $this->set_error(
                    $status_data["status"], 
                    $status_data["status_information"],
                    $status_data["status_information"]
                    );
        }
        
    }
    
    /*
     * API to retrieve service execution result
     * 
     * @return Array Service message 
     *      ["status"] Indicate the status of service run (Error, complete or etc). 
     *      ["status_information"] Message return for display purpose. 
     *      ["data"] Output data from the service
     */
    public function get_return_data_set()
    {
        $data_set = NULL;
        
        // Select between valid condition and return result accordingly
        if ($this->is_error === TRUE)
        {
            $data_set["status"] = "Error ". $this->error_code;
            
            if ($this->CI->config->item('display_user_error')  === True)
            {
                $data_set["status_information"] = $this->usr_error_msg;
            }
            else
            {
                $data_set["status_information"] = $this->dev_error_msg;
            }
            
            $data_set["data"] = "";
        }
        else
        {
            $data_set["status"] = "Complete";
            $data_set["status_information"] = $this->status_information;
            
            if ($this->return_data === NULL)
            {
                $data_set["data"] = "";
            }
            else
            {
                $data_set["data"] = $this->return_data;
            }
        }
        
        return $data_set;
    }
    
    //--------------------- Generic Function -----------------------------------
    
    /*
     * API that support convert value to match the database
     */
    public function data_value_convertor($data, $convert_set, $is_ui_entries)
    {
        foreach ($convert_set as $key => $value_set)
        {
            if(array_key_exists($key, $data))
            {
                foreach ($value_set as $ui_value => $database_value)
                {
                    if($is_ui_entries === true)
                    {
                        if($data[$key] === $ui_value)
                        {
                            $data[$key] = $database_value;
                        }
                    }
                    else
                    {
                        if($data[$key] === $database_value)
                        {
                            $data[$key] = $ui_value;
                        }
                    }
                }
            }
        }
        
        return $data;
    }
    
    /*
     * API to convert single scale data converter
     */
    public function library_data_m_v_convert($data_array,$array_key_change,$is_view)
    {
        // Change base on direction
        if($is_view)
        {
            foreach ($array_key_change as $view_key => $model_key)
            {
                if($data_array !== NULL && array_key_exists($view_key, $data_array))
                {
                    $data_array[$model_key] = $data_array[$view_key];
                    unset($data_array[$view_key]);
                }
            }
        }
        else
        {
            foreach ($array_key_change as $view_key => $model_key)
            {
                if(array_key_exists($model_key, $data_array))
                {
                    $data_array[$view_key] = $data_array[$model_key];
                    unset($data_array[$model_key]);
                }
            }
        }
        return $data_array;
    }
    
    /*
     * API to detect and extract array value, error if not found
     * 
     * @param Array That will use for key check
     * @param String Key use for checking
     * @param Bool Bypass errors and return NULL
     */
    public function array_value_extract($array, $key, $bypass_err=false)
    {
        if(is_array($array))
        {
            if(array_key_exists($key, $array))
            {
                return $array[$key];
            }
            else
            {
                if(!$bypass_err)
                {
                    $this->set_error("LBE-".$this->library_code."-AVE-1", 
                            "Internal error, please contact Admin", 
                            "Missing $key as key in array for ".$this->library_name.". With: ".json_encode($array));
                }
            }
        }
        else
        {
            if(!$bypass_err)
            {
                $this->set_error("LBE-".$this->library_code."-AVE-2", 
                        "Internal error, please contact Admin", 
                        "Pass in is not array for ".$this->library_name);
            }
        }
        return NULL;
    }
    
    /*
     * Retain dedicated key information only
     * 
     * @Param Array Input data that will be filter
     * 
     * @Return Array Filtered data
     */
    private function _library_filter_data($data_array)
    {
        // Coutner for how many data being set
        $set_data_cout = 0;

        // Call setting API from the caller class
        $accepted_key_array = $this->library_accepted_key();
        
        // Loop through the initialize data list
        foreach ($accepted_key_array as $view_key => $key_enable)
        {
            if($key_enable)
            {
               if(array_key_exists($view_key,$data_array))
                {
                    $filtered_data[$view_key] = $data_array[$view_key];
                    $set_data_cout = $set_data_cout +1;
                } 
            }
        }
        
        if($set_data_cout == 0)
        {
            $this->set_error("LBE-".$this->library_code."-FD-1",
                            "For further information, please contact Admin",
                            "No match key found for input data in _data_key_init for".$this->library_name);
            return NULL;
        }
        
        return $filtered_data;
    }
    
    /*
     * To handle data array, which perform: (follow sequence)
     *    1. Take allow dedicated key and prevent data polution
     *    2. Key conversion from view to model and vise versa if any
     * 
     * @Param Array Data array that pass from view/model to model/view
     * @Param Boolen To determine the direction of conversion, True mean View to Mode
     * 
     * @Return Array Proccessed data with corresponding key
     */
    protected function library_data_key_init($data_array, $is_view)
    {
        //Check type and convert to array
        if (is_string($data_array))
        {
            $data_array = json_decode($data_array, TRUE);
        }
        elseif (is_object($data_array))
        {
            $data_array = (array)$data_array;
        }
        
        // Confirm the data_array is array 
        if($data_array === NULL)
        {
            $this->set_error("LBE-".$this->library_code."-DKI-1",
                            "For further information, please contact Admin",
                            "data array pass to _data_key_init is NULL for ".$this->library_name);
            return NULL;
        }
        elseif(!is_array($data_array))
        {
            $this->set_error("LBE-".$this->library_code."-DKI-2",
                            "For further information, please contact Admin",
                            "data array pass to _data_key_init not an array for ".$this->library_name);
            return NULL;
        }
        
        
        // To convert key name from UI to model name
        $data_array = $this->library_data_m_v_convert($data_array,$this->library_data_key_v_and_m(),TRUE);
        
        // Remove redundant key after change name
        $data_array = $this->_library_filter_data($data_array);
        
        
        // Remove NULL data
        foreach ($data_array as $key => $value)
        {
            if($value === NULL)
            {
                unset($data_array[$key]);
            }
            elseif(is_string($value) && $value === "")
            {
                unset($data_array[$key]);
            }
        }
        if($data_array === NULL)
        {
            $this->set_error("LBE-".$this->library_code."-DKI-3",
                            "For further information, please contact Admin",
                            "The result of _data_key_init is fully filtered for ".$this->library_name).". As input is ".json_encode($data_array);
        }
        
        return $data_array;
    }
    //--------------------- Internal Function ----------------------------------
    
}

?>
