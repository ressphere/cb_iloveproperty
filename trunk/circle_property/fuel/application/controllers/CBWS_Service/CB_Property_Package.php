<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'CBWS_Service_Base.php';


/*
 * @Todo - there is some improvement for the CBWS_Servic Base
 *         All implementation should be revisit
 */


class CB_Property_package extends CBWS_Service_Base{
    
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
    
    /*
     * Specified AUTH support service
     * 
     * @Return Array list of auth servie
     */
    private function auth_service_list()
    {
        $auth_service = [
            "test_service"  => TRUE,
            "get_package" => TRUE
        ];
        return $auth_service;
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
    
    /*
     * Test service
     */
    private function test_service($input_data_array)
    {
        $this->set_data($input_data_array, "Info: Complete CB_Property_Package:test_service Service");
        
    }
    
    public function get_package()
    {
        // Extract data from database
        $property_package['where'] = array('active' => 'yes');
        $return_query_data = $this->CI->cb_manage_property_package->get_property_package($property_package);
        $status_information = "Info: Retrieve specific data from database for CB_Property_component";
        
        $this->set_data($return_query_data,$status_information);
    }
}
?>
