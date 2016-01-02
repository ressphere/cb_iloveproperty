<?php
require_once 'GeneralFunc.php';

/*
 * This is the base class for unit test.
 * Wich currently support
 *    1. Benchmark handler
 *    2. Service gateway with benchmark wrap around
 */

class unit_test_main extends CI_Controller {
    
    function __construct() {
        parent::__construct();  
    }
    
    /*
     * Write data into benchark file when required
     * 
     * @Param String data to be write into benchmark dump file
     */
    public function benchmark_dump_file($string)
    {
        // For benchmark (profiler) to keep track total execute time
        //    Able to disable through "application/config/MY_config.php"
        $this->config->load("MY_config");
        
        if ($this->config->item('dump_benchmark_file') === True)
        {
            $this->load->helper('file');
            $benchmark_file_path =  dirname(dirname(__FILE__))."../../../../assets/benchmark_file.txt";
            write_file($benchmark_file_path, "\n".$string, 'a+');
            
        }
    }
    
    /*
     * Invoke function within class.
     * Contain wrap around for benhmark related code.
     * 
     * @Param String Class name that require function invoke
     * @Param String Function name that wish to invoke
     * @Param ANY input to the function (support single argument)
     * 
     * @Return Jason_string Value return by the function
     * 
     */
    public function direct_func_invoke($obj_name, $function_name, $argument)
    {
        // Create object
        $obj = new $obj_name;
        
        // Benchmark the function required time
        $this->benchmark->mark("ws_code_start");
        $val_return = $obj->$function_name($argument);
        $this->benchmark->mark("ws_code_end");
        
        $data = "$function_name - " . $this->benchmark->elapsed_time('ws_code_start', 'ws_code_end');
        $this->benchmark_dump_file($data);
        
        return $val_return;
    }
    
    /*
     * Invoke Service function within class.
     * Contain wrap around for benhmark related code.
     * 
     * @Param String Class name that require function invoke
     * @Param String Function name that wish to invoke
     * @Param ANY input to the function (support single argument)
     * 
     * @Return Jason_string Value return by the function
     * 
     */
    public function direct_service_func_invoke($obj_name, $function_name, $argument)
    {
        // Create object
        $obj = new $obj_name;
        
        // Benchmark the function required time
        $this->benchmark->mark("ws_code_start");
        $obj->$function_name($argument);
        $this->benchmark->mark("ws_code_end");
        
        $val_return = $obj->get_return_data_set();
                
        $data = "$function_name - " . $this->benchmark->elapsed_time('ws_code_start', 'ws_code_end');
        $this->benchmark_dump_file($data);
        
        return $val_return;
    }
    
    /*
     * Invoke CB send service request
     * 
     * @Param String Sevice that will be invoke
     * @Param String input to the function
     * 
     * @Return Jason_string Value return by the function
     * 
     */
    public function Send_Service($service, $argument)
    {
        // Benchmark the function required time
        $this->benchmark->mark("ws_code_start");
        $val_return = GeneralFunc::CB_Send_Service_Request($service,$argument);
        $this->benchmark->mark("ws_code_end");
        
        $data = "$service - " . $this->benchmark->elapsed_time('ws_code_start', 'ws_code_end');
        $this->benchmark_dump_file($data);
        
        return $val_return;
    }
    
    /*
     * Invoke CB recieve service request
     * 
     * @Param String Sevice that will be invoke
     * @Param String input to the function
     * 
     * @Return Jason_string Value return by the function
     * 
     */
    public function Receive_Service($service)
    {
        // Benchmark the function required time
        $this->benchmark->mark("ws_code_start");
        $val_return = GeneralFunc::CB_Receive_Service_Request($service);
        $this->benchmark->mark("ws_code_end");
        
        $data = "$service - " . $this->benchmark->elapsed_time('ws_code_start', 'ws_code_end');
        $this->benchmark_dump_file($data);
        
        return $val_return;
    }
    
    /*
     * Invoke CB send and recieve service request
     * 
     * @Param String Sevice that will be invoke
     * @Param String input to the function
     * 
     * @Return Jason_string Value return by the function
     * 
     */
    public function SendReceive_Service($service, $argument)
    {
        // Benchmark the function required time
        $this->benchmark->mark("ws_code_start");
        $val_return = GeneralFunc::CB_SendReceive_Service_Request($service,$argument);
        $this->benchmark->mark("ws_code_end");
        
        $data = "$service - " . $this->benchmark->elapsed_time('ws_code_start', 'ws_code_end');
        $this->benchmark_dump_file($data);
        
        return $val_return;
    }
    
    
    
}

?>
