<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * PLEASE IGONRE THIS FILE AS IT IS HALF WAY DONE
 * WILL REFACTOR ONCE HAVE TIME
 * 
 * This is the base class for all Service gateway
 * Which currently contain
 *  1. Service finder and handler 
 *  2. Error Handler
 * 
 * Any new Service must inherite this class
 */
class CBWS_Service_Base {
    //--------------------- Global Variable ----------------------
    // Error message
    public $is_error = FALSE;
    private $dev_error_msg = "";
    private $usr_error_msg = "";
    private $error_code = "";
    
    // For unit test purpose
    private $status_information = "Info: Constructor invoke only";

    // Return data
    private $return_data = "";
    
    // Library name for database query and error message
    public $service_name = "none_and_is_error";
    public $service_code = "CSB-NON";
    
    //--------------------- Setup Function ----------------------
    public function __construct()
    {
        // 1. For benchmark (profiler) to keep track total execute time
        //    Able to disable through "application/config/MY_config.php"
        // 2. For Error switching purpose
        $this->CI =& get_instance();
        $this->CI->config->load("MY_config");
    }
    
    /*
     * Contain list of serivce supported with auth
     * Service list content mean
     *     - True = Require AUTH
     *     - FALSE = Not require AUTH
     * 
     * @Return Array list of auth servie
     */
    public function service_list()
    {
        $service_list = array(
            '_auth_test' => TRUE,
            '_non_auth_test'=> FALSE
        );
        return $service_list;
    }
    
    
    //--------------------- Test Function ----------------------
    /*
     * API to test auth service hit
     */
    private function _auth_test($data)
    {
        $status_info = "Info: Complete CBWS_Service_Base:_auth_test Service";
        $return_data = $data;
        $this->set_data($status_info, $return_data);
    }
    
    /*
     * API to test non auth service hit
     */
    private function _non_auth_test($data)
    {
        $status_info = "Info: Complete CBWS_Service_Base:_non_auth_test Service";
        $return_data = $data;
        $this->set_data($status_info, $return_data);
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
    
    
    //--------------------- Generic Function ----------------------
    /*
     * Main entry for service, which include
     *    1. Check if the service exist
     *       a. Error if service not found
     *       b. Error if service need auth but no auth
     *    2. Invoke service
     * 
     * @Param String request_command["service"] Contain choosed service that need to execute, prefix is <Service Group name>:<service name>
     * @Param Array request_command["send_data"] Input data for service to process
     * @Param Bool request_command["AUTH"] Indicate have authorization or not
     * 
     * @Rreturn Array Service message 
     *      ["status"] Indicate the status of service run (Error, complete or etc). 
     *      ["status_information"] Message return for display purpose. 
     *      ["data"] Output data from the service
     */
    public function invoke_service($request_command)
    {
        // Check through the service list
        $service_name = $this->_search_service($request_command["service"], $request_command["AUTH"]);
        
        if($this->is_error !== TRUE)
        {
            // Invoke Service function
            $this->$service_name($request_command["send_data"]);
        }
          
        // Return complete data
        return $this->get_return_data_set();
    }
    
    /*
     * Model access generic API
     *  Able to instantiate and invoke Model, thus pass and retrieve
     *  data from the model
     * 
     * @Todo - No unit test yet, have to find a way to create one
     * 
     * @param Array data_array['model'] Name of model that require to call
     * @param Array data_array['function'] Function name of the model
     * @param Array data_array['data'] input data pass to the model function
     * 
     * @Return Anything Return information
     */
    protected function invoke_model_function($data_array)
    {
        if(! is_array($data_array))
        {
            $this->set_error("CSB-".$this->service_code."-IMF-1",
                            "For futher detail, please contact Admin",
                            "The provided data ".$data_array."is not an array for ".$this->service_name);
            return NULL;
        }
        
        // Check is there any key missing
        $detect_missing_key = array();
        if(!array_key_exists('model',$data_array)){array_push($detect_missing_key,'model');}else{$model = $data_array['model'];}
        if(!array_key_exists('function',$data_array)){array_push($detect_missing_key,'function');}else{$function = $data_array['function'];}
        if(!array_key_exists('data',$data_array)){array_push($detect_missing_key,'data');}else{$data = $data_array['data'];}

        if(sizeof($detect_missing_key) > 0)
        {
            $this->set_error("CSB-".$this->service_code."-IMF-2",
                            "For futher detail, please contact Admin",
                            "Missing key in invoke_model_function for ".$this->service_name.". Array data: ".json_encode($data_array));
            return NULL;
        }
        
        // Load model and function as no error detected
        $model_obj = $this->CI->load->model($model);
        
        if($data !== NULL)
        {
            $model_obj->$function($data);
        }
        else
        {
            $model_obj->$function();
        }
        
        $data_return = $model_obj->get_return_data_set();
                
        // Check Error
        $this->validate_return_data($model_obj);
        
        return $data_return;
        
    }
    
    
    /*
     * Library access generic API
     *  Able to instantiate and invoke library, thus pass and retrieve
     *  data from the library
     * 
     * @Todo - No unit test yet, have to find a way to create one
     * 
     * @param Array data_array['library'] Name of library that require to call
     * @param Array data_array['function'] Function name of the library
     * @param Array data_array['data'] input data pass to the model function
     * 
     * @Return Anything Return information
     */
    protected function invoke_library_function($data_array)
    {
        if(! is_array($data_array))
        {
            $this->set_error("CSB-".$this->service_code."-ILF-1",
                            "For futher detail, please contact Admin",
                            "The provided data for library is not an array for ".$this->service_name);
            return NULL;
        }
        
        // Check is there any key missing
        $detect_missing_key = array();
        if(!array_key_exists('library',$data_array)){array_push($detect_missing_key,'library');}else{$library = $data_array['library'];}
        if(!array_key_exists('function',$data_array)){array_push($detect_missing_key,'function');}else{$function = $data_array['function'];}
        if(!array_key_exists('data',$data_array)){array_push($detect_missing_key,'data');}else{$data = $data_array['data'];}

        if(sizeof($detect_missing_key) > 0)
        {
            $this->set_error("CSB-".$this->service_code."-ILF-2",
                            "For futher detail, please contact Admin",
                            "Missing key in invoke_library_function for ".$this->service_name.". Array data: ".json_encode($data_array));
            return NULL;
        }
        
        // Load model and function as no error detected
        $library_obj = $this->CI->load->library($library);
        
        if($data !== NULL)
        {
            $library_obj->$function($data);
        }
        else
        {
            $library_obj->$function();
        }
        
        $data_return = $library_obj->get_return_data_set();
                
        // Check Error
        $this->validate_return_data($library_obj);
                
        return $data_return;
        
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
    protected function data_key_init($data_array, $is_view)
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
            $this->set_error("CSB-".$this->service_code."-DKI-1",
                            "For further information, please contact Admin",
                            "data array pass to _data_key_init is NULL for ".$this->service_name);
            return NULL;
        }
        elseif(!is_array($data_array))
        {
            $this->set_error("CSB-".$this->service_code."-DKI-2",
                            "For further information, please contact Admin",
                            "data array pass to _data_key_init not an array for ".$this->service_name);
            return NULL;
        }
        
        // Call setting API from the caller class
        $array_key_change = $this->data_key_v_and_m();
        
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
        
        // Remove redundant key after change name
        $data_array = $this->_filter_data($data_array);
        
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
            $this->set_error("CSB-".$this->service_code."-DKI-3",
                            "For further information, please contact Admin",
                            "The result of _data_key_init is fully filtered for ".$this->service_name).". As input is ".json_encode($data_array);
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
                    $this->set_error("LBE-".$this->service_code."-AVE-1", 
                            "Internal error, please contact Admin", 
                            "Missing $key as key in array for ".$this->service_name.". With: ".json_encode($array));
                }
            }
        }
        else
        {
            if(!$bypass_err)
            {
                $this->set_error("LBE-".$this->service_code."-AVE-2", 
                        "Internal error, please contact Admin", 
                        "Pass in is not array for ".$this->service_name);
            }
        }
        return NULL;
    }
    
    //--------------------- Internal Function ----------------------
    /*
     * Retain dedicated key information only
     * 
     * @Param Array Input data that will be filter
     * 
     * @Return Array Filtered data
     */
    private function _filter_data($data_array)
    {
        // Coutner for how many data being set
        $set_data_cout = 0;

        // Call setting API from the caller class
        $accepted_key_array = $this->accepted_key();
        
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
            $this->set_error("CSB-".$this->service_code."-DKI-2",
                            "For further information, please contact Admin",
                            "No match key found for input data in _data_key_init for".$this->service_name);
            return NULL;
        }
        
        return $filtered_data;
    }
    
    /*
     * Search service list to see is the service supported
     * 
     * @Param String Full Service name
     */
    private function _search_service($service_command, $AUTH)
    {
        // Retrieve service group, split to [0] is Service group and [1] is service name
        $service = explode(":",$service_command);
        $extract_service = $service[1];
        $service_list = $this->service_list();
        
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
                        "CSB-".$this->service_code."-SC-1", 
                        "Require authentication for $service_command",
                        "Hit AUTH service for $service_command but no AUTH detected for ".$this->service_name);
            }
                
            // Pass AUTH check or no AUTH required
            return $extract_service;
        }
        
        // Doesn't have hit in the service list
        $this->set_error(
                            "CSB-".$this->service_code."-SC-2", 
                            "Service $service_command not supported",
                            "Service $service_command not found in list for ".$this->service_name);
        
        return "";
    }

    
    
}

?>
