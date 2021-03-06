<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'CBWS_Service_Base.php';

/**
 * Circle Property Service
 *    To handle all service related to property
 * 
 */
class CB_Currency extends CBWS_Service_Base{
    //--------------------- Global Variable ----------------------
    // Library that interact with dedicated database
    private $properties_library_name = "currency_convertor";
    
    // Error handler
    public $service_name = "cb_currenct";
    public $service_code = "SBC";
    
    //--------------------- Setup Function ----------------------
    /**
     * Normal Constructor
     * *** Please don't touch this unless is necessary ***
     * 
     * @param Array (optional)Data that contain all product information using key and value
     */
    public function __construct()
    {
        parent::__construct();
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
            "get_currency_list" => TRUE
        );
        return $service_list;
    }
    
    /**
     * Contain all accepted View key 
     *  Using view key is due to view key unlikely to change
     * 
     * @return Array List of the supported data
     */
    public function accepted_key()
    {
        // @todo - enchance to become input must_have check 
        
        // Contain all the accepted key
        // Format:
        //   True = Accepted key
        //   False = Disabled key
        $accept_key = array(
            // For insert and update data
            currency => TRUE
            
        );
        
        return $accept_key;
    }
    
    /*
     * Setting function which contain all name change for data key value
     * Array key for view to model or vise versa
     * 
     * @Return Array That contain view and model keys
     */
    public function data_key_v_and_m()
    {
        // This array store all the keys need to be change from view to model
        // Format: 
        //    "view_key_name" => "model_key_name"
        $array_key_change = array(
            "unit_name" => "property_name",
            "location" => "map_location",
            "postcode" => "post_code",
            
        );
        
        return $array_key_change;
    }
    
    //--------------------- Service Function ----------------------
    
    /**
     *  To get the list of available currency
     */
    public function get_currency_list()
    {   
        // file dump -- for testing purpose -- Start --
        /*
        $current = "\n------------------------------\n";
        $current .= "CB_Property  -- upload_listing -- ori input\n";
        $current .= gettype($input_data);
        $current .= "\n";
        $current .= json_encode($input_data);
        $current .= "\n";
        $current .= "\nCB_Property  -- upload_listing -- after init\n";
        $current .= json_encode($property_info);
        error_log($current, 3, "D:/webdev/resphere_test_dump.txt");   
        // file dump -- for testing purpose -- End --*/
        
        if($this->is_error){return 0;}
        
        // Build model array data
        $library_data = array(
            'library' => $this->properties_library_name,
            'function' => "get_supported_currency",
            'data' =>''
        );

        // Pump in data (contain error check)
        $currency_return = $this->invoke_library_function($library_data);
        
        if($this->is_error){return 0;}

        $status_information = "Info: Successfully get supported currency";
        $return_data = $currency_return["data"];
        $this->set_data($status_information,$return_data);

    }
    
    public function get_currency_type_string($input_data)
    {
        $currency_enum = $this->data_key_init($input_data, true);
        if($this->is_error){return 0;}
        
        // Build model array data
        $library_data = array(
            'library' => $this->properties_library_name,
            'function' => "get_currency_type_string",
            'data' => $currency_enum
        );

        // Pump in data (contain error check)
        $currency_return = $this->invoke_library_function($library_data);
        
        if($this->is_error){return 0;}

        $status_information = "Info: Successfully convert currency enum to string";
        $return_data = $currency_return["data"];
        $this->set_data($status_information,$return_data);
    }
    
    public function get_currency_type_enum($input_data)
    {
        $currency_enum = $this->data_key_init($input_data, true);
        if($this->is_error){return 0;}
        
        // Build model array data
        $library_data = array(
            'library' => $this->properties_library_name,
            'function' => "get_currency_type_enum",
            'data' => $currency_enum
        );

        // Pump in data (contain error check)
        $currency_return = $this->invoke_library_function($library_data);
        
        if($this->is_error){return 0;}

        $status_information = "Info: Successfully convert currency string to enum";
        $return_data = $currency_return["data"];
        $this->set_data($status_information,$return_data);
    }
    
    
    //--------------------- Internal Function ----------------------
    
}

?>
