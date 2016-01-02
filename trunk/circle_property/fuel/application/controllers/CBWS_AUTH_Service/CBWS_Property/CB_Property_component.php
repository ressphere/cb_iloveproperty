<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Circle Property object, use for all processing related to property
 * 
 */
class CB_Property_component {
    
    //--------------------- Global Variable ----------------------
    // Array for all the property content
    private $property_info = NULL;
    
    // Preset data, which everyone must lisen
    private $list_of_data = NULL;
    
    // Status indicator
    private $status = "Pending";
    private $status_information = "Info: No status reported";
    private $error_flag = FALSE; // Use to stop process if data required
    
    // CI controller holder
    private $CI = NULL;
    
    
    //--------------------- Function ----------------------
    /**
     * Normal Constructor
     * 
     * @param Array (optional)Data that contain all product information using key and value
     */
    public function __construct()
    {
        // Initialize the data list for property
        $this->_init_list_of_data();
        
        if(func_num_args() !== 0)
        {
            $this->insert_property_data(func_get_arg(0));
        }
    }
    
    /**
     * Initialize the supported data list for the property and load model
     * 
     * @access private
     * @return Array List of the supported data
     */
    private function _init_list_of_data()
    {
        // Data initialization
        
        $this->list_of_data[0] = "Name";  // Need to have first data so the rest can be pushed
        array_push($this->list_of_data, "Price");
        array_push($this->list_of_data, "Property_info_image");
        
        // Load model for database access
        $this->CI =& get_instance();
        $this->CI->load->model('cb_manage_property');
    }
    
    
    /**
     * Return the status of the API run
     * 
     * @return Array Status after function execution
     */
    public function status_return()
    {
        $status_return["status"] = $this->status;
        $status_return["status_information"] = $this->status_information;
        
        return $status_return;
    }
    
    /**
     * Insert property data
     * 
     * @param Array $data_array Data that contain all property information using key and value
     */
    public function insert_property_data($input_data_array)
    {
        // Coutner for how many data being set
        $set_data_cout = 0;
        
        if($input_data_array === NULL)
        {
            $this->error_flag = TRUE;
            $this->status = "Error";
            $this->status_information = "Error: No info detected from the provioded input for CB_Property_component";
        }
        else
        {
            // Loop through the initialize data list
            foreach ($this->list_of_data as $data_key)
            {
                if(array_key_exists($data_key,$input_data_array))
                {
                    $this->property_info[$data_key] = $input_data_array[$data_key];
                    $set_data_cout = $set_data_cout +1;
                }
                else
                {
                    $this->property_info[$data_key] = NULL;
                }
            }
            
            if($set_data_cout > 0)
            {
                $this->status = "Complete";
                $this->status_information = "Info: Complete transfer $set_data_cout of data for CB_Property_component";
            }
            else
            {
                $this->error_flag = TRUE;
                $this->status = "Error";
                $this->status_information = "Error: No match key detacted for CB_Property_component";
            }
        }
    }
    
    /**
     * To insert data into database (Value must be preloaded!!!)
     */
    public function create_request()
    {
        if($this->error_flag === False)
        {
            if($this->property_info === NULL)
            {
                $this->error_flag = TRUE;
                $this->status = "Error";
                $this->status_information = "Error: No info detected for property detected for CB_Property_component";
            }
            else
            {
                // Pump in data
                if($this->CI->cb_manage_property->set_property_info(json_encode($this->property_info)))
                {
                    $this->status = "Complete";
                    $this->status_information = "Info: Inserted require data into database for CB_Property_component";
                }
                else
                {
                    $this->error_flag = TRUE;
                    $this->status = "Error";
                    $this->status_information = "Error: Fail to insert data into database for CB_Property_component";
                }
            }
        }
    }
    
    /**
     *  To Remove specific data from database (Value must be preloaded!!!)
     *  !!! Note !!! Not recommented using this as it will remove all data that have same value
     *  !!! Note !!! Please use remove through id API
     */
    public function remove_request()
    {
        if($this->error_flag === False)
        {
            if($this->property_info === NULL)
            {
                $this->error_flag = TRUE;
                $this->status = "Error";
                $this->status_information = "Error: No info detected for property detected for CB_Property_component";
            }
            else
            {
                // Pump in data
                if($this->CI->cb_manage_property->remove_property_info(json_encode($this->property_info)))
                {
                    $this->status = "Complete";
                    $this->status_information = "Info: Removed specific data from database for CB_Property_component";
                }
                else
                {
                    $this->error_flag = TRUE;
                    $this->status = "Error";
                    $this->status_information = "Error: Fail to insert data into database for CB_Property_component";
                }
            }
        }
    }
    
    
    public function get_filter_data($filter_requirement)
    {
        // Extract data from database
        $return_query_data = $this->CI->cb_manage_property->get_filter_property(json_decode($filter_requirement,TRUE));
        
        $this->status = "Complete";
        $this->status_information = "Info: Retrieve specific data from database for CB_Property_component";
        
        return $return_query_data;
    }
    
}

class CB_Property_package {
    
     //--------------------- Global Variable ----------------------
    // Array for all the property content
    private $package_info = NULL;
    
    // Preset data, which everyone must lisen
    private $list_of_data = NULL;
    
    // Status indicator
    private $status = "Pending";
    private $status_information = "Info: No status reported";
    private $error_flag = FALSE; // Use to stop process if data required
    
    // CI controller holder
    private $CI = NULL;
    
    
    //--------------------- Function ----------------------
    /**
     * Normal Constructor
     * 
     * @param Array (optional)Data that contain all product information using key and value
     */
    public function __construct()
    {
        // Initialize the data list for property
        $this->_init_list_of_data();
        
        if(func_num_args() !== 0)
        {
            $this->insert_property_data(func_get_arg(0));
        }
    }
    
    /**
     * Initialize the supported data list for the property and load model
     * 
     * @access private
     * @return Array List of the supported data
     */
    private function _init_list_of_data()
    {
        // Data initialization
        
        $this->list_of_data[0] = "Product Code";  // Need to have first data so the rest can be pushed
        array_push($this->list_of_data, "Price");
        array_push($this->list_of_data, "Listing Attempt");
        array_push($this->list_of_data, "Credit Point");
        array_push($this->list_of_data, "SMS Count");
        array_push($this->list_of_data, "Promotion");
        array_push($this->list_of_data, "Active");
        
        // Load model for database access
        $this->CI =& get_instance();
        $this->CI->load->model('cb_manage_property_package');
    }
    
    
    /**
     * Return the status of the API run
     * 
     * @return Array Status after function execution
     */
    public function status_return()
    {
        $status_return["status"] = $this->status;
        $status_return["status_information"] = $this->status_information;
        
        return $status_return;
    }
 
    public function get_package()
    {
        // Extract data from database
        $property_package['where'] = array('active' => 'yes');
        $return_query_data = $this->CI->cb_manage_property_package->get_property_package($property_package);
        
        $this->status = "Complete";
        $this->status_information = "Info: Retrieve specific data from database for CB_Property_component";
        
        return $return_query_data;
    }
}
?>
