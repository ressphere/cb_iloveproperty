<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'CBWS_Service_Base.php';

/**
 * Circle Property Service
 *    To handle all service related to property
 * 
 */
class CB_Property extends CBWS_Service_Base{
    //--------------------- Global Variable ----------------------
    // Library that interact with dedicated database
    private $properties_library_name = "properties_listing_lib";
    
    // Error handler
    public $service_name = "cb_property";
    public $service_code = "SBP";
    
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
            "test_service"  => TRUE,
            "upload_listing" => TRUE,
            "delete_listing" => TRUE,
            "listing_detail" => TRUE,
            "filter_listing" => TRUE,
            "user_listing_condition" => TRUE,
            "change_listing_activate" => TRUE,
            "get_country_state" => TRUE,
            "get_display_data" => TRUE,
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
            "furnished_type" => true,
            "occupied" => true,
            "service_type" => true,
            "state" => true,
            "area" => true,
            "postcode" => true,
            "street" => true,
            "country" => true,
            "location" => true,
            "currency" => true,
            "size_measurement_code" => true,
            "price" => true,
            "auction" => true,
            "buildup" => true,
            "landarea" => true,
            "bedrooms" => true,
            "bathrooms" => true,
            "monthly_maintanance" => true,
            "remark" => true,
            "property_category" => true,
            "property_type" => true,
            "tenure" => true,
            "land_title_type" => true,
            "unit_name" => true,
            "reserve_type" => true,
            "facilities" => true,
            "property_photo" => true,
            "car_park" => true,
            
            // for data delete, detail data display
            "ref_tag" => true,
            
            // For data filtering
            "limit" => true,
            "filter" => true,
            "offset" => true,
            "buildup >=" => true,
            "buildup <=" => true,
            "price >=" => true,
            "price <=" => true,
            
            // For retrieve user listing profile, data insert and mark deactive
            "user_id" => true,
            
            // For mark deactive
            "activate" => true,
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
    
    
    //--------------------- Test Function ----------------------
    /*
     * Test service
     */
    public function test_service($input_data_array)
    {
        $this->set_data("Info: Complete CB_Property:test_service Service",$input_data_array);
        
    }
    
    //--------------------- Service Function ----------------------
    
    /**
     *  To upload listing to database inserted by user
     */
    public function upload_listing($input_data)
    {
        $property_info = $this->data_key_init($input_data, true);
        
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
            'function' => "insert_properties_listing",
            'data' => json_encode($property_info)
        );

        // Pump in data (contain error check)
        $insert_return = $this->invoke_library_function($library_data);
        
        if($this->is_error){return 0;}

        $status_information = "Info: Successfully inserted data";
        $return_data = $insert_return["data"];
        $this->set_data($status_information,$return_data);

    }
    
    /**
     *  To delete specific listing base on ref_tag
     *      ** Please use "change_listing_activate" instate if not mean to remove 
     *          the listing from dataase
     */
    public function delete_listing($input_data)
    {
        $property_info = $this->data_key_init($input_data, true);
        
        if($this->is_error){return 0;}
        
        if(!array_key_exists("ref_tag", $property_info))
        {
             $this->set_error($this->service_code."-DL-1",
                        "Fail to delete listing. For further information, please contact Admin",
                        "Data array doesn't contain ref_tag key ".$this->service_name.". Which ". json_encode($property_info));
             return 0;
        }
        
        // Build model array data
        $library_data = array(
            'library' => $this->properties_library_name,
            'function' => "remove_properties_listing",
            'data' => json_encode($property_info)
        );

        // Pump in data (contain error check)
        $insert_return = $this->invoke_library_function($library_data);

        if($this->is_error){return 0;}
        
        $status_information = "Info: Successfully deleted data";
        $return_data = $insert_return["data"];
        $this->set_data($status_information,$return_data);
    }
    
    /*
     * To obtain listing detail
     */
    public function listing_detail($input_data)
    {
        $property_info = $this->data_key_init($input_data, true);
        
        if($this->is_error){return 0;}

        if(!array_key_exists("ref_tag", $property_info))
        {
             $this->set_error($this->service_code."-LD-1",
                        "Fail display listing detail. For further information, please contact Admin",
                        "Data array doesn't contain ref_tag key ".$this->service_name.". Which ". json_encode($property_info));
             return 0;
        }


        // Build model array data
        $library_data = array(
            'library' => $this->properties_library_name,
            'function' => "get_detail_listing",
            'data' => json_encode($property_info)
        );

        // Pump in data (contain error check)
        $insert_return = $this->invoke_library_function($library_data);
        
        if($this->is_error){return 0;}

        $status_information = "Info: Successfully retrieve data for ".$property_info["ref_tag"];
        $return_data = $insert_return["data"];
        $this->set_data($status_information,$return_data);
    }
    
    
    /*
     * To obtain filter list base on follow param
     *  1. filter   - Filter data and value
     *  2. limit    - number of data display
     *  3. offset   - off set the specified number from display
     * 
     */
    public function filter_listing($input_data)
    {
        // First level key change
        $filter_info = $this->data_key_init($input_data, true);
        
        // Perform second level key change (filter data)
        $filter_info["filter"] = $this->data_key_init($filter_info["filter"], true);
        
        if($this->is_error){return 0;}
        
        // Build model array data
        $library_data = array(
            'library' => $this->properties_library_name,
            'function' => "get_filter_listing",
            'data' => json_encode($filter_info)
        );

        // Pump in data (contain error check)
        $filter_return = $this->invoke_library_function($library_data);

        if($this->is_error){return 0;}

        $status_information = "Info: Successfully retrieve data listing filter";
        $return_data = $filter_return["data"];
        //$return_data = $input_data_array;
        $this->set_data($status_information,$return_data);
    }
    
    /*
     * To retrieve specific user listing related information
     *  1. total number of listing submitted
     *  2. total'number of activation listing
     *  3. total number of non-activate listing
     *  4. system limit number of listing can activate
     *  5. is the specific user can still upload or activate data
     */
    public function user_listing_condition($input_data)
    {
        $info = $this->data_key_init($input_data, true);
        
        if($this->is_error){return 0;}

        // Check user_id
        if(!array_key_exists("user_id", $info))
        {
             $this->set_error($this->service_code."-ULC-1",
                        "Fail to retreive user information. For further information, please contact Admin",
                        "Data array doesn't contain user_id key ".$this->service_name.". Which ". json_encode($info));
             return 0;
        }

        // Return data define
        $return_data["max_activate"] = 3;

        // Filter data build
        $filter_data["filter"]["user_id"] = $info["user_id"];

        // For activate data handle
        $filter_data["filter"]["activate"] = '1';
        $this->filter_listing($filter_data);
        $active_data_set = $this->get_return_data_set();

        if($this->is_error === true){return 0;}

        else {$return_data["activate_num"] = sizeof($active_data_set["data"]);}

        if ($return_data["max_activate"] >= $return_data["activate_num"])
        {
            $return_data["allow_insert"] = TRUE;
        }
        else
        {
            $return_data["allow_insert"] = FALSE;
        }

        // For non-activate data handle
        $filter_data["filter"]["activate"] = '0';
        $this->filter_listing($filter_data);
        $non_active_data_set = $this->get_return_data_set();

        if($this->is_error === true){return 0;}

        else {$return_data["non_activate_num"] = sizeof($non_active_data_set["data"]);}

        $return_data["total_num"] = $return_data["activate_num"] + $return_data["non_activate_num"];

        // Return data
        $status_information = "Info: Successfully retrieve data listing user listing condition";
        $this->set_data($status_information,$return_data);
    }
    
    /*
     * To change the activate flag for the specific listing
     *  1. Search will base on ref_tag and user_id
     */
    public function change_listing_activate($input_data)
    {

        $info = $this->data_key_init($input_data, true);
        if($this->is_error){return 0;}
        $mark_data["ref_tag"] = $this->array_value_extract($info, "ref_tag");
        if($this->is_error){return 0;}
        $mark_data["user_id"] = $this->array_value_extract($info, "user_id");
        if($this->is_error){return 0;}
        $mark_data["activate"] = $this->array_value_extract($info, "activate");
        if($this->is_error){return 0;}
        
        // Build model array data
        $library_data = array(
            'library' => $this->properties_library_name,
            'function' => "change_listing_activate",
            'data' => json_encode($mark_data)
        );

        // invoke library API, include error check
        $mark_return = $this->invoke_library_function($library_data);

        if($this->is_error){return 0;}
        
        $status_information = "Info: ".$mark_return["status_information"];
        $return_data = $mark_return["data"];
        $this->set_data($status_information,$return_data);
    }
    
    /*
     * Obtain whole country and state list
     * To obtain filter list base on follow param
     *  1. filter   - Filter data and value
     *  2. limit    - number of data display
     *  3. offset   - off set the specified number from display
     * 
     */
    public function get_country_state($input_data)
    {
        $filter_info = NULL;
        
        // Bypass the value check when there is no filtering happen
        if($input_data !== NULL)
        {
            // First level key change
            $filter_info = $this->data_key_init($input_data, true);

            // Perform second level key change (filter data)
            $filter_info["filter"] = $this->data_key_init($filter_info["filter"], true);
        }
        
        if($this->is_error){return 0;}
        
        // Build model array data
        $library_data = array(
            'library' => $this->properties_library_name,
            'function' => "get_country_state",
            'data' => json_encode($filter_info)
        );

        // Pump in data (contain error check)
        $filter_return = $this->invoke_library_function($library_data);

        if($this->is_error){return 0;}

        $status_information = "Info: Successfully retrieve data for state and country";
        $return_data = $filter_return["data"];
        //$return_data = $input_data_array;
        $this->set_data($status_information,$return_data);
    }
    
    /*
     * Obtain following display data, which only when there is listing
     *  1. country 
     *  2. state
     *  3. property_type
     *  4. property_category
     * 
     * To obtain filter list base on follow param
     *  1. filter   - Filter data and value
     *  2. limit    - number of data display
     *  3. offset   - off set the specified number from display
     * 
     */
    public function get_display_data($input_data)
    {
        // First level key change
        $filter_info = $this->data_key_init($input_data, true);
        
        // Perform second level key change (filter data)
        $filter_info["filter"] = $this->data_key_init($filter_info["filter"], true);
        
        if($this->is_error){return 0;}
        
        // Build model array data
        $library_data = array(
            'library' => $this->properties_library_name,
            'function' => "get_display_data",
            'data' => json_encode($filter_info)
        );

        // Pump in data (contain error check)
        $filter_return = $this->invoke_library_function($library_data);

        if($this->is_error){return 0;}

        $status_information = "Info: Successfully retrieve filter data for state, country, property_type and property_category";
        $return_data = $filter_return["data"];
        //$return_data = $input_data_array;
        $this->set_data($status_information,$return_data);
    }
    //--------------------- Internal Function ----------------------
    
}

?>
