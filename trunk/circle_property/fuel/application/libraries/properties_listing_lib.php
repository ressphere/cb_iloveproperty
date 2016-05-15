<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('_utils/cb_base_libraries.php');

/**
 * This libraries handle all data manipulation for porperties listing part
 *
 */
class properties_listing_lib extends cb_base_libraries
{
    // ------------ Setup Function ---------------------------------------------
    public $library_name = "properties_listing_lib";
    public $library_code = "LPL";
    
    /*
     * Constructor 
     */
    function __construct()
    {
        // Invoke parent constructor
       parent::__construct();
    }
    
    private function property_data_convert()
    {
        $convert_data = array(
            "furnished_type" => array (
                "Full Furnished" => "Fully",
                "Partially Furnished" => "Partially",
                "No Furnished" => "No"
            ),
            "occupied" => array (
                "No" => 0,
                "Yes" => 1
            ),
            "land_title_type" => array (
                "residential" => "Residential",
                "commercial" => "Commercial",
            ),
            "state" => array (
                "Penang" => "Pulau Pinang"
            ),
            "service_type" => array(
                "buy"   => "SELL",
                "BUY"   => "SELL",
                "sell"  => "SELL",
                "Rent"  => "RENT",
                "rent"  => "RENT",
                "Room"  => "RENT",
                "room"  => "RENT",
                "ROOM"  => "RENT"
            )
        );
        
        return $convert_data;
    }
    
    //--------------------- Generic Function -----------------------------------

    /*
     * API that use to asset data into database
     * @access public
     * 
     * @param String Json input that contain information that require to store
     *  Input field (all string input unless specified):
     *      furnished_type
     *      occupied
     *      service_type
     *      state
     *      area
     *      post_code
     *      street
     *      country
     *      map_location - array("k", "B")
     *      currency
     *      price
     *      auction
     *      buildup
     *      landarea
     *      bedrooms
     *      bathrooms
     *      monthly_maintanance
     *      remark
     *      property_type
     *      property_category
     *      tenure
     *      land_title_type
     *      user_id
     *      property_name
     *      reserve_type
     *      facilities - array()
     *      property_photo - array(array("path","description"),)
     * 
     * 
     * @return string Reference Tag
     */
    function insert_properties_listing($properties_json)
    {
        $properties_raw = json_decode($properties_json, true);

        // Change input data to model support data, overwrite
        $properties = $this->data_value_convertor($properties_raw, $this->property_data_convert(), true);
        
        // Check if the listing submitted before
        $ref_tag = $this->array_value_extract($properties, "ref_tag", true);
        $search_condition = array(); // Init it so that later won't screw
        if($ref_tag !== NULL)
        {
            $search_condition["ref_tag"] =$ref_tag;
        }
        
        // -------- Special handle -------- start -----------------
        // Safe bypass when map_location is not in the picture
        if(array_key_exists("map_location", $properties))
        {
            // Special handle for map location or google ip
            $properties["map_location"] = json_encode($properties["map_location"]);
        }
        
        // Provide current malaysia time for activate_time, edit_time and create_time
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $properties["edit_time"] = date('Y-m-d H:i:s', time());
        
        if($ref_tag === NULL)
        {
            // Set relavent time
            $properties["activate_time"] = date('Y-m-d H:i:s', time());
            $properties["create_time"] = date('Y-m-d H:i:s', time());
            
             // Default to activate when insert
            $properties["activate"] = '1';
        }
        
        if(array_key_exists("auction", $properties))
        {
            $properties["auction"] = date('Y-m-d H:i:s', strtotime($properties["auction"]));
        }
        
        // -------- Special handle -------- end -----------------
        
        $this->CI->load->model('properties_listing_model'); 
        $properties_listing_model = new $this->CI->properties_listing_model;
        $properties_listing_model->insert_data(json_encode($properties),$search_condition);
        
        // validate data and set current error
        $this->validate_return_data($properties_listing_model);
        
        if($this->is_error) {return 0;}
        
        // Data retrieved
        $listing_return = $properties_listing_model->get_return_data_set();

        // Obtain listing ID
        $property_id = $listing_return["data"]["id"];
        
        // Remove facility and photo if update, as dono got new or change. so reflush require
        // @todo - here duplicate with remove listing, can consolidate
        if($ref_tag !== NULL)
        {
            // Obtain photo link
            $this->CI->load->model('property_photo_model'); 
            $property_photo_model = new $this->CI->property_photo_model;
            $photo_obj_list = $property_photo_model->find_all(array("property_id" => $property_id), "","","","");

            $this->CI->load->helper('file');

            // Remove file through link and data in db
            foreach ($photo_obj_list as $photo_obj)
            {
                // @todo - might need to remove photo actual file here
                $photo_obj->delete();
            }

            // Remove db for facility
            $this->CI->load->model('facilities_properties_listing_model'); 
            $facilities_properties_listing_model = new $this->CI->facilities_properties_listing_model;
            $facilities_properties_listing_model->delete(array("property_id" => $property_id));

        }
        
        // Insert facilities if have any
        if(array_key_exists("facilities", $properties))
        {
            $this->CI->load->model('facilities_properties_listing_model'); 
            $facilities_properties_listing_model = new $this->CI->facilities_properties_listing_model;

            foreach ($properties["facilities"] as $facility_name)
            {
                if ($facility_name !== NULL)
                {
                    $data_set["property_id"] = $property_id;
                    $data_set["facility_name"] = $facility_name;

                    $facilities_properties_listing_model->insert_data(json_encode($data_set));

                    $this->validate_return_data($facilities_properties_listing_model);

                    if($this->is_error){break;}
                }
            }
        }
        
        if($this->is_error){return 0;}
        
        // Check facility and insert photo link if have any
        if(array_key_exists("property_photo", $properties))
        {
            $this->CI->load->model('property_photo_model'); 
            $property_photo_model = new $this->CI->property_photo_model;

            foreach ($properties["property_photo"] as $photo_data_set)
            {
                $data_set["property_id"] = $property_id;
                $data_set["path"] = $photo_data_set["path"];
                $data_set["description"] = $photo_data_set["description"];

                $property_photo_model->insert_data(json_encode($data_set));

                $this->validate_return_data($facilities_properties_listing_model);

                if($this->is_error){break;}
            }  
        }
        
        // @todo - clean the assert data when fail (e.g. photo fail to insert will need to remove the listing and facility inserted data)

        if ($this->is_error){return 0;}
        
        // Provide ref tag when success
        $return_data["ref_tag"] = $properties_listing_model->ref_tag;
        $this->set_data("Complete insert data", $return_data);
        
        // file dump -- for testing purpose -- Start --
        /*$current = "\n------------------------------\n";
        $current .= "properties_listing_lib  -- upload_listing -- ori input\n";
        $current .= json_encode($properties)."\n";
        $current .= json_encode($search_condition);
        error_log($current, 3, "D:/webdev/resphere_test_dump.txt");
        // file dump -- for testing purpose -- End --*/
    }
    
    
    /*
     * API to mark the listing to non-activate
     * 
     * @param String Json input that contain following info
     *      ref_tag - Tag id which point to specific listing
     *      user_id - To double check the listing is submitted by same ppl
     *      activate - flag to indicate the lastest activate status 
     * 
     */
    function change_listing_activate($info_json)
    {
        $info = json_decode($info_json, true);
        $ref_tag = $this->array_value_extract($info, "ref_tag");
        $user_id = $this->array_value_extract($info, "user_id");
        $activate = $this->array_value_extract($info, "activate") === "true"?1:0;
        if($this->is_error){return 0;}
        
        $this->CI->load->model('properties_listing_model'); 
        $properties_listing_model = new $this->CI->properties_listing_model;
        
        // Obtain listing model through tag
        //$listing_obj = $properties_listing_model->find_one(array("ref_tag" => $ref_tag, "user_id"=>$user_id));
        $where = array("ref_tag" => $ref_tag, "user_id"=>$user_id);
        $result = $properties_listing_model->update(array('activate'=>$activate ? 1: 0), 
                $where);      
        if($result)
        {
            $data_array = array(
                "ref_tag"=>$info_json,
                "activate_time" => date('m/d/Y h:i:s a', time())
            );
            
            $this->set_data("Complete change activation status", json_encode($data_array));
        }
        else
        {
            
            $this->set_error( "LPL-MLN-1",
                    "Fail to de-activate the specific listing, please contact admin",
                    "No listing hit for ref_tag $ref_tag and user_id $user_id in remove_properties_listing ".json_encode($listing_obj)
                    );
        }
    }
    
    /*
     * API to remove listing through ref code, by perform
     *    1. Remove photo (todo and need revisit)
     *    2. Remove photo and property db
     *    3. Remove listing
     * 
     * @param String Json input that contain following info
     *      ref_tag - Tag id which point to specific listing
     * 
     */
    function remove_properties_listing($info_json)
    {
        $info = json_decode($info_json, true);
        $ref_tag = $this->array_value_extract($info, "ref_tag");
        
        if($this->is_error){return 0;}
        
        $this->CI->load->model('properties_listing_model'); 
        $properties_listing_model = new $this->CI->properties_listing_model;

        // Obtain listing model through tag
        $listing_obj = $properties_listing_model->find_one(array("ref_tag" => $ref_tag));

        if(is_object($listing_obj))
        {
            $listing_id = $listing_obj->id;

            // Obtain photo link
            $this->CI->load->model('property_photo_model'); 
            $property_photo_model = new $this->CI->property_photo_model;
            $photo_obj_list = $property_photo_model->find_all(array("property_id" => $listing_id), "","","","");

            $this->CI->load->helper('file');

            // Remove file through link and data in db
            foreach ($photo_obj_list as $photo_obj)
            {
                $photo_link = $photo_obj->path;

                // @todo - remove the actual file if UI not handle
                //delete_files($photo_link);

                $photo_obj->delete();
            }

            // Remove db for facility
            $this->CI->load->model('facilities_properties_listing_model'); 
            $facilities_properties_listing_model = new $this->CI->facilities_properties_listing_model;
            $facilities_properties_listing_model->delete(array("property_id" => $listing_id));

            // Remove listing
            $listing_obj->delete();

            // @todo - better benchmark on removing data
            $this->set_data("Complete delete data", $info);

        }
        else
        {
            $this->set_error( "LPL-RPL-1",
                    "Fail to remove listing, please contact admin",
                    "No listing hit for ref_tag $ref_tag in remove_properties_listing ".json_encode($listing_obj)
                    );
        }
    }
    
    /*	
     * API to retireve detail listing base on ref_tag
     *    1. Detect ref_tag
     *    2. Perform database query
     *       a. listing data
     *       b. photo link (requrie listing id)
     *       c. facility (require listing id)
     * 
     * @param Array Json input which contain ref_tag
     */
    function get_detail_listing($info_json)
    {
        
        $info = json_decode($info_json, true);
        
        $ref_tag = $this->array_value_extract($info, "ref_tag");
 
        // Stop if have error
        if($this->is_error){return 0;}
            
        $this->CI->load->model('properties_listing_model'); 
        $properties_listing_model = new $this->CI->properties_listing_model;


        // Obtain listing model through tag
        $properties_listing_model->query_detail_data_setup();
        $listing_array = $properties_listing_model->find_one(array("ref_tag" => $ref_tag),"","array");
        
        if($this->is_error){return 0;}
        
        if(sizeof($listing_array) != 0)
        {
            // ---- Extract user information
            $user_id = $this->array_value_extract($listing_array, "user_id");
            $this->CI->load->model('users_model'); 
            if($this->is_error){return 0;}
            
            $users_model = new $this->CI->users_model;
            $users_array_list = $users_model->find_all(array("id" => $user_id), "","","","array");
            
            // Believe that have one and only one data
            $listing_array["username"] = $this->array_value_extract($users_array_list[0], "username");
            $listing_array["phone"] = $this->array_value_extract($users_array_list[0], "phone");
            $listing_array["email"] = $this->array_value_extract($users_array_list[0], "email");
            $listing_array["displayname"] = $this->array_value_extract($users_array_list[0], "displayname");
            
            // ---- Extract listing related information
            $listing_id = $this->array_value_extract($listing_array, "id");

            if($this->is_error){return 0;}
            
            // Obtain photo link
            $this->CI->load->model('property_photo_model'); 
            $property_photo_model = new $this->CI->property_photo_model;
            $photo_array_list = $property_photo_model->find_all(array("property_id" => $listing_id), "","","","array");
            $photo_array_output= array();

            // Make it display nicely
            foreach($photo_array_list  as $photo_array)
            {
                $photo_detail_array["path"] = $photo_array["path"];
                $photo_detail_array["description"] = $photo_array["description"];
                array_push($photo_array_output, $photo_detail_array);
            }

            // Push in photo data for display purpose
            $listing_array["property_photo"] = $photo_array_output;


            // Obtain facility
            $this->CI->load->model('facilities_properties_listing_model'); 
            //$facilities_properties_listing_model = new $this->CI->facilities_properties_listing_model;
            $facilities_properties_listing_model = new $this->CI->facilities_properties_listing_model;

            $facility_list_record = $facilities_properties_listing_model->find_all(array("property_id" => $listing_id), "","","","array");
            $facility_array= array();

            // Make it display nicely
            foreach($facility_list_record  as $facility_obj)
            {
                array_push($facility_array, $facility_obj["name"]);
            }

            // Push in facility data for display purpose
            $listing_array["facilities"] = $facility_array;

            // pump out data
            $this->set_data("Complete extract detail data", $listing_array);
        }
        else
        {
            $this->set_error( "LPL-GDL-1",
                    "Fail to retrieve listing detail, please contact admin",
                    "No listing hit for ref_tag $ref_tag in get_detail_listing ".json_encode($listing_array)
                    );
        }
    }

    
    /*
     * API to retrieve listing with filter dump
     *    1. Detect filter entity
     *    2. Arrange filter entity for query purpose
     *    3. Perform database query
     * 
     * @param String Json input which contain filter condition if have any
     * @param String Json output which contain following information
     *                  a. property_name
     *                  b. price
     *                  c. currency
     *                  d. landarea
     *                  e. furnished_type
     *                  f. bedroom and bathroon number (@todo - missing carpark)
     *                  g. date posting
     *                  h. activation status
     */
    function get_filter_listing($info_json)
    {  
        
        $info = json_decode($info_json, true);
        
        // Change input data to model support data, overwrite
        $info = $this->data_value_convertor($info, $this->property_data_convert(), true);
        $info["filter"] = $this->data_value_convertor($info["filter"], $this->property_data_convert(), true);
        
        // Presume the list match the query requirement
        // @Todo - this assumption shouldn't made in the first place
        // @Todo - have second level of filter to avoid query crash
        
        // Filtering example:
        //$info["filter"]["ref_tag"] = "RSP-SL-6";  // String filter example
        //$info["filter"]["bedrooms >"] = "1"; // number range search example
        //$info["filter"]["bedrooms <"] = "3";
        
        // Safe guard for offset and limit (display all data)
        if (! array_key_exists("limit", $info))
        {
            $info["limit"] = NULL;
        }

        if (! array_key_exists("offset", $info))
        {
            $info["offset"] = NULL;
        }
        
        // Stop if have error
        if($this->is_error){return 0;}
        
        // Select display info
        $statement["select"] = [
            "property_name",
            "ref_tag",
            "currency",
            "price",
            "buildup",
            "furnished_type",
            "bedrooms",
            "bathrooms",
            "activate_time",
            "activate",
            "size_measurement_code"
        ];

        // Model setup
        $this->CI->load->model('properties_listing_model'); 
        $properties_listing_model = new $this->CI->properties_listing_model;
        
        // Process filter query to correspoding column name
        $filter_query = $properties_listing_model->process_filter_data_query($info["filter"]);

        // INFO ***
        //      - Arrangement will follow activate time (latest activate to old activation)
        $properties_listing_model->query_detail_data_setup($statement);
        
        // Empty the select statment as it already define through query_detail_data_setup
        $query_statement["select"] = "";
        
        //query_statement['limit'] = $info["limit"];
        //$query_statement['offset'] = $info["offset"];
        $query_statement['order_by'] = "activate_time desc";
        
        // Form query statement building, exclude ">", "<", "=>" and "=<" key form like
        $query_statement["where"] = NULL;
        $query_statement['like'] = NULL;
        
        foreach ($filter_query as $key => $value)
        {
            // Extract last 2 value of the key
            $key_sub = substr($key,strlen($key)-1,1);
            
            // Inclue the no need like column
            if($key_sub == ">" || $key_sub === "<" || $key_sub === "=" ||
                   $key === "activate" || $key === "id")
            {
                $query_statement["where"][$key] = $filter_query[$key];
            }
            else
            {
                //$query_statement['like'][$key] = $filter_query[$key];
                $query_statement['like']["LOWER($key)"] = strtolower($filter_query[$key]);
            }
        }
        
        // Remove NULL statment
        foreach ($query_statement as $key => $value)
        {
            if($value === NULL)
            {
                unset($query_statement[$key]);
            }
        }
       
        
        // Specified the return type is array
        $properties_listing_model->set_return_method("array");
        
        //$listing_array = $properties_listing_model->find_all($filter_query,"activate_time desc",$info["limit"],$info["offset"],"array","");
        $listing_array_num_query = $properties_listing_model->query($query_statement);
        $listing_count = $listing_array_num_query->num_records();
        //$listing_array = $listing_array_query->result();  // Return is query object
        
        // Debug use to expose the query string and data
        //$properties_listing_model->debug_query();
        //$properties_listing_model->debug_data();
        
        // Query for data display, for offset and limit
        $query_statement['limit'] = $info["limit"];
        $query_statement['offset'] = $info["offset"];
       
        $properties_listing_model->set_return_method("array");
        $properties_listing_model->query_detail_data_setup($statement);
        $listing_array_query = $properties_listing_model->query($query_statement);
        $listing_array = $listing_array_query->result();
        
        //$properties_listing_model->query_detail_data_setup();
        //$listing_count = $properties_listing_model->record_count($filter_query);
        
        
        $this->validate_return_data($properties_listing_model);
        if ($this->is_error === true){return;}
        
        // Photo extract to obtain photo link
        
        for($index = 0; $index < sizeof($listing_array); $index = $index + 1)
        {
            $this->CI->load->model('property_photo_model'); 
            $property_photo_model = new $this->CI->property_photo_model;
            $photo_array_list = $property_photo_model->find_all(array("property_id" => $listing_array[$index]["id"]), "","","","array");
            $photo_array_output= array();

            // Make it display nicely
            foreach($photo_array_list  as $photo_array)
            {
                $photo_detail_array["path"] = $photo_array["path"];
                $photo_detail_array["description"] = $photo_array["description"];
                array_push($photo_array_output, $photo_detail_array);
            }
            
            // Push in photo data for display purpose
            //$listing_array["property_photo"] = $photo_array_output;
            $listing_array[$index]["property_photo"] = $photo_array_output;
            
            $this->validate_return_data($property_photo_model);
            if ($this->is_error === true){return;}
        }
        
        $return_data["listing"] = $listing_array;
        $return_data["count"] = $listing_count;
        $this->set_data("Complete extracted data", $return_data);
        
        /*// Debug usage -- start
        $current = "\n------------------------------\n";
        $current .= "properties_listing_lib  -- filter\n";
        $current .= "data input: ".json_encode($info)."\n";
        $current .= "query input: ".json_encode($query_statement)."\n";
        $current .= "data output: ".json_encode($return_data)."\n";
        error_log($current, 3, "D:/webdev/resphere_test_dump.txt");
        //Debug usage -- end */
    }

    /*
     * API to retrieve country and state
     *    1. Detect filter entity
     *    3. Perform database query
     * 
     * @param String Json input which contain filter condition if have any
     * @param String Json output which contain following information
     *                  a. country
     *                  b. state
     */
    function get_country_state($info_json)
    {
        $info = json_decode($info_json, true);
        
        // Allow filter bypass as currencies request not needed
        if ($info !== NULL)
        {
            // Change input data to model support data, overwrite
            $info = $this->data_value_convertor($info, $this->property_data_convert(), true);
            $info["filter"] = $this->data_value_convertor($info["filter"], $this->property_data_convert(), true);
        }
        else
        {
            $info = array();
            $info["filter"] = array();
        }
        
        // Presume the list match the query requirement
        // @Todo - this assumption shouldn't made in the first place
        // @Todo - have second level of filter to avoid query crash
        
        // Filtering example:
        //$info["filter"]["country"] = "Malaysia";  // String filter example
        
        // Safe guard for offset and limit (display all data)
        if (! array_key_exists("limit", $info))
        {
            $info["limit"] = NULL;
        }
        if (! array_key_exists("offset", $info))
        {
            $info["offset"] = NULL;
        }
        
        // Stop if have error
        if($this->is_error){return 0;}
        
        // Model setup
        $this->CI->load->model('state_country_model'); 
        $state_country_model = new $this->CI->state_country_model;
        
        // Process filter query to correspoding column name
        $filter_query = $state_country_model->process_filter_data_query($info["filter"]);
        
        // INFO ***
        //      - Arrangement will follow activate time (latest activate to old activation)
        $state_country_model->query_detail_data_setup();
        $state_country_array = $state_country_model->find_all($filter_query,"",$info["limit"],$info["offset"],"array","");
        $state_country_model->query_detail_data_setup();
        $state_country_count = $state_country_model->record_count($filter_query);
        
        // Get currency related information
        $this->CI->load->model('country_model'); 
        $country_model = new $this->CI->country_model;
        $country_model->query_detail_data_setup();
        $currency_array = $country_model->find_all("","","","","array","");
        
        $this->validate_return_data($state_country_model);
        if ($this->is_error === true){return;}
        
        $return_data["state_country"] = $state_country_array;
        $return_data["count"] = $state_country_count;
        $return_data["currency"] =$currency_array;
        $this->set_data("Complete extracted data", $return_data);
        
        /*
        // Debug usage -- start
        $current = "\n------------------------------\n";
        $current .= "properties_listing_lib  -- filter\n";
        $current .= "data input: ".json_encode($info)."\n";
        $current .= "data output: ".json_encode($return_data)."\n";
        error_log($current, 3, "D:/webdev/resphere_test_dump.txt");
        //Debug usage -- end */
    }
    
    /*
     * API to retrieve display country and state and return only state have listing
     *    1. Detect filter entity
     *    2. Perform database query
     * 
     * @param String Json input which contain filter condition if have any
     * @param String Json output which contain following information
     *                  a. country
     *                  b. state
     *                  c. property_type
     *                  d. property_category
     */
    function get_display_data($info_json)
    {
        $info = json_decode($info_json, true);
        
        // Change input data to model support data, overwrite
        $info = $this->data_value_convertor($info, $this->property_data_convert(), true);
        $info["filter"] = $this->data_value_convertor($info["filter"], $this->property_data_convert(), true);
        
        // Presume the list match the query requirement
        // @Todo - this assumption shouldn't made in the first place
        // @Todo - have second level of filter to avoid query crash
        
        // Filtering example:
        //$info["filter"]["country"] = "Malaysia";  // String filter example
        
        // Safe guard for offset and limit (display all data)
        if (! array_key_exists("limit", $info))
        {
            $info["limit"] = NULL;
        }
        if (! array_key_exists("offset", $info))
        {
            $info["offset"] = NULL;
        }
        
        // Stop if have error
        if($this->is_error){return 0;}
        
        // Select display info
        $statement["select"] = [
            "state.name as state",
            "country.name as country",
            "property_type",
            "property_category"
        ];
      
        //@todo - not yet complete
        
        
        // Model setup
        $this->CI->load->model('properties_listing_model'); 
        $properties_listing_model = new $this->CI->properties_listing_model;
        
        // Process filter query to correspoding column name
        $filter_query = $properties_listing_model->process_filter_data_query($info["filter"]);
        
        // INFO ***
        //      - Arrangement will follow activate time (latest activate to old activation)
        $properties_listing_model->query_detail_data_setup($statement, true);
        $state_country_array = $properties_listing_model->find_all($filter_query,"",$info["limit"],$info["offset"],"array","");
        $properties_listing_model->query_detail_data_setup();
        $state_country_count = $properties_listing_model->record_count($filter_query);
        
        
        $this->validate_return_data($properties_listing_model);
        if ($this->is_error === true){return;}
        
        $return_data["query_data"] = $state_country_array;
        $return_data["count"] = $state_country_count;
        $this->set_data("Complete extracted data", $return_data);
        
        
        // Debug usage -- start
        /*$current = "\n------------------------------\n";
        $current .= "properties_listing_lib  -- filter\n";
        $current .= "data input: ".json_encode($info)."\n";
        $current .= "data output: ".json_encode($return_data)."\n";
        error_log($current, 3, "D:/webdev/resphere_test_dump.txt");
        //Debug usage -- end */
    }

    // ------------ Private Function -------------------------------------------
    
}