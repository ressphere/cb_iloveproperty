<?php
require_once 'unit_test_main.php';

class lm_properties_listing_unit_test extends unit_test_main
{
    private $CI = NULL;
    function __construct() {
        parent::__construct();
        
        
        
        $current_file_name = pathinfo(__FILE__, PATHINFO_FILENAME);
        $this->benchmark_dump_file($current_file_name);
        
    }
    ###########################Generic API region########################################
    private function _dummy_data_set($model_usage = false)
    {
        $property_info = array();
        
        // ========= For Sell == Start =========================================
        // -- Data list that have difference compare to input
        if ($model_usage === true)
        {
            $property_info["SELL"]['furnished_type'] = 'Partially';
            $property_info["SELL"]['occupied'] = 1;
        }
        else
        {
            $property_info["SELL"]['furnished_type'] = 'Partially Furnished';
            $property_info["SELL"]['occupied'] = 'Yes';
        }
        
        // -- Data that doesn't have 1:1 relationship
        $property_info["SELL"]["state"] = "Pulau Pinang";
        $property_info["SELL"]["area"] = "Gelugor";
        $property_info["SELL"]["post_code"] = "11700";  // This is extra
        $property_info["SELL"]["street"] = "Jalan Batu Uban";  // This is extra
        //$property_info["address"] = "Jalan Batu Uban, 11700 Gelugor, Pulau Pinang, Malaysia";
        $property_info["SELL"]["country"] = "Malaysia";
        $property_info["SELL"]["map_location"] = array(
            "k" => 3.1403075200382,
            "B" => 101.68664550781
        );
        
        // -- Data list
        $property_info["SELL"]['service_type'] = 'SELL';
        $property_info["SELL"]['currency'] = 'MYR';
		$property_info["SELL"]['size_measurement_code'] = 'sqft';
        $property_info["SELL"]['price'] = '1200000.00';
        $property_info["SELL"]['auction'] = '01/31/2015 10:40 AM';
        $property_info["SELL"]['buildup'] = '2500';
        $property_info["SELL"]['landarea'] = '1230';
        $property_info["SELL"]['bedrooms'] = '3';
        $property_info["SELL"]['bathrooms'] = '2';
        //$property_info["SELL"]['ref'] = 'abc123456';
        $property_info["SELL"]['monthly_maintanance'] = '250.00';
        $property_info["SELL"]['remark'] = 'This is testing for SELL';
        $property_info["SELL"]['property_category'] = 'Condo/Residence';
        $property_info["SELL"]['property_type'] = 'Duplex';
        $property_info["SELL"]['tenure'] = 'Leasehold';
        $property_info["SELL"]["land_title_type"] = "Commercial";
        $property_info["SELL"]['user_id'] = '1';
        $property_info["SELL"]['property_name'] = 'test name 1 for SELL';//'the light'; 
        $property_info["SELL"]["reserve_type"] = "BUMI LOT";
        $property_info["SELL"]["car_park"] = "1";
        $property_info["SELL"]["active"] = 1;

        // -- Data that not in the listing table
        $property_info["SELL"]["property_photo"] = array(
            array(
                "path" => "http:\/\/localhost\/cb_iloveproperty\/trunk\/client_views\/properties_views\/assets\/images\/properties\/2ee05b56d98933ce2a6256ae0e57049f\/phpD95D.tmp", 
                "description" => "new year"
            ),
            array(
                "path" => "http:\/\/localhost\/cb_iloveproperty\/trunk\/client_views\/properties_views\/assets\/images\/properties\/2ee05b56d98933ce2a6256ae0e57049f\/phpD95D.tmp", 
                "description" => "new year 2"
            )
        );
        $property_info["SELL"]["facilities"] = array("PARKING", "SECURITY");
        // ========= For Sell == End ===========================================
        
        // ========= For RENT == Start =========================================
        // -- Data list that have difference compare to input
        if ($model_usage === true)
        {
            $property_info["RENT"]['furnished_type'] = 'Fully';
            $property_info["RENT"]['occupied'] = 0;
        }
        else
        {
            $property_info["RENT"]['furnished_type'] = 'Full Furnished';
            $property_info["RENT"]['occupied'] = 'No';
        }
        
        // -- Data that doesn't have 1:1 relationship
        $property_info["RENT"]["state"] = "Pulau Pinang";
        $property_info["RENT"]["area"] = "Gelugor";
        $property_info["RENT"]["post_code"] = "11700";  // This is extra
        $property_info["RENT"]["street"] = "Jalan Batu Uban";  // This is extra
        //$property_info["address"] = "Jalan Batu Uban, 11700 Gelugor, Pulau Pinang, Malaysia";
        $property_info["RENT"]["country"] = "Malaysia";
        $property_info["RENT"]["map_location"] = array(
            "k" => 3.1403075200382,
            "B" => 101.68664550781
        );
        
        // -- Data list
        $property_info["RENT"]['service_type'] = 'RENT';
        $property_info["RENT"]['currency'] = 'MYR';
		$property_info["RENT"]['size_measurement_code'] = 'sqft';
        $property_info["RENT"]['price'] = '1100000.00';
        $property_info["RENT"]['buildup'] = '500';
        $property_info["RENT"]['landarea'] = '230';
        $property_info["RENT"]['bedrooms'] = '9';
        $property_info["RENT"]['bathrooms'] = '3';
        //$property_info["RENT"]['ref'] = 'abc123456';
        $property_info["RENT"]['remark'] = 'This is testing for RENT';
        $property_info["RENT"]['property_category'] = 'Terrace/Link/Townhouse';
        $property_info["RENT"]['property_type'] = 'Single Storey';
        $property_info["RENT"]["land_title_type"] = "Industrial";
        $property_info["RENT"]['user_id'] = '1';
        $property_info["RENT"]['property_name'] = 'test name 2 for RENT';//'the light'; 
        $property_info["RENT"]["car_park"] = "4";
        $property_info["RENT"]["active"] = 1;

        // -- Data that not in the listing table
        $property_info["RENT"]["property_photo"] = array(
            array(
                "path" => "http:\/\/localhost\/cb_iloveproperty\/trunk\/client_views\/properties_views\/assets\/images\/properties\/2ee05b56d98933ce2a6256ae0e57049f\/phpD95D.tmp", 
                "description" => "new year"
            ),
            array(
                "path" => "http:\/\/localhost\/cb_iloveproperty\/trunk\/client_views\/properties_views\/assets\/images\/properties\/2ee05b56d98933ce2a6256ae0e57049f\/phpD95D.tmp", 
                "description" => "new year 2"
            )
        );
        $property_info["RENT"]["facilities"] = array("BBQ", "BusinessCenter", "MINIMART", "SAUNA");
        // ========= For RENT == End ===========================================
        
        // ========= For ROOM == Start =========================================
        // -- Data list that have difference compare to input
        if ($model_usage === true)
        {
            $property_info["ROOM"]['furnished_type'] = 'Fully';
            $property_info["ROOM"]['occupied'] = 0;
        }
        else
        {
            $property_info["ROOM"]['furnished_type'] = 'Full Furnished';
            $property_info["ROOM"]['occupied'] = 'No';
        }
        
        // -- Data that doesn't have 1:1 relationship
        $property_info["ROOM"]["state"] = "Pulau Pinang";
        $property_info["ROOM"]["area"] = "Gelugor";
        $property_info["ROOM"]["post_code"] = "11700";  // This is extra
        $property_info["ROOM"]["street"] = "Jalan Batu Uban";  // This is extra
        //$property_info["address"] = "Jalan Batu Uban, 11700 Gelugor, Pulau Pinang, Malaysia";
        $property_info["ROOM"]["country"] = "Malaysia";
        $property_info["ROOM"]["map_location"] = array(
            "k" => 3.1403075200382,
            "B" => 101.68664550781
        );
        
        // -- Data list
        $property_info["ROOM"]['service_type'] = 'ROOM';
        $property_info["ROOM"]['currency'] = 'MYR';
		$property_info["ROOM"]['size_measurement_code'] = 'sqft';
        $property_info["ROOM"]['price'] = '1100000.00';
        $property_info["ROOM"]['bathrooms'] = '3';
        //$property_info["ROOM"]['ref'] = 'abc123456';
        $property_info["ROOM"]['remark'] = 'This is testing for ROOM';
        $property_info["ROOM"]['property_category'] = 'Room';
        $property_info["ROOM"]['property_type'] = 'Junior Master';
        $property_info["ROOM"]['user_id'] = '1';
        $property_info["ROOM"]['property_name'] = 'test name 3 for ROOM';//'the light'; 
        $property_info["ROOM"]["car_park"] = "4";
        $property_info["ROOM"]["active"] = 1;
        
        // -- Data that not in the listing table
        $property_info["ROOM"]["property_photo"] = array(
            array(
                "path" => "http:\/\/localhost\/cb_iloveproperty\/trunk\/client_views\/properties_views\/assets\/images\/properties\/2ee05b56d98933ce2a6256ae0e57049f\/phpD95D.tmp", 
                "description" => "new year"
            ),
            array(
                "path" => "http:\/\/localhost\/cb_iloveproperty\/trunk\/client_views\/properties_views\/assets\/images\/properties\/2ee05b56d98933ce2a6256ae0e57049f\/phpD95D.tmp", 
                "description" => "new year 2"
            )
        );
        $property_info["ROOM"]["facilities"] = array("BBQ", "BusinessCenter", "MINIMART", "SAUNA");
        // ========= For ROOM == End ===========================================
        
        // Convert to Json and return
        return $property_info;
    }
    
    ###########################unit test region####################################        
    public function _library_test() 
    {

        //  Obtain data
        $property_info_list = $this->_dummy_data_set(false);
        
        foreach($property_info_list as $service_type => $property_info)
        {
            $property_info_json = json_encode($property_info);
            
            //  Setup libraries
            $this->CI =& get_instance();
            $this->CI->load->library('properties_listing_lib');


            //---------------- Test on data insert --------------------------------
            // Invoke data insert
            $this->CI->properties_listing_lib->insert_properties_listing($property_info_json);

            $val_return_insert =  $this->CI->properties_listing_lib->get_return_data_set();

            // Extract reg_tag for later use
            $reg_tag_array = $val_return_insert["data"];

            $val_golden_insert = "Complete";
            $val_golden_insert_json = json_encode($val_golden_insert);
            $val_return_insert_json = json_encode($val_return_insert);
            $note = "Return value -- $val_return_insert_json <br>";
            $note = $note."Golden value -- $val_golden_insert_json";
            $this->unit->run($val_return_insert["status"], $val_golden_insert, "Test lm_porperties_listing libraries insert data for $service_type", $note);


            //---------------- Test on extract data detail --------------------------------
            // Invoke data insert
            $this->CI->properties_listing_lib->get_detail_listing(json_encode($reg_tag_array));

            $val_return_detail =  $this->CI->properties_listing_lib->get_return_data_set();

            $val_golden_detail = "Complete";
            $val_golden_detail_json = json_encode($val_golden_detail);
            $val_return_detail_json = json_encode($val_return_detail);
            $note = "Return value -- $val_return_detail_json <br>";
            $note = $note."Golden value -- $val_golden_detail_json";
            $this->unit->run($val_return_detail["status"], $val_golden_detail, "Test lm_porperties_listing libraries retrieve detail data for $service_type", $note);

            //---------------- Test on data search --------------------------------
            // Prepare filter data structure
            //$filter_struct = json_decode("{\"limit\":9,\"filter\":{\"state\":\"Penang\",\"country\":\"Malaysia\",\"activate\":1,\"service_type\":\"SELL\"},\"offset\":0}",true);
            
            $filter_struct["limit"] = NULL;   // display all data 
            $filter_struct["filter"]["activate"] = '1';     // Data filter example
            $filter_struct["filter"]["price >"] = '1000000';  // Range filter example
            $filter_struct["filter"]["price <="] = '1300000';
            //$filter_struct["filter"]["property_type"] = 'Duplex';
            
            // Invoke data search
            $this->CI->properties_listing_lib->get_filter_listing(json_encode($filter_struct));

            $val_return_detail =  $this->CI->properties_listing_lib->get_return_data_set();

            $val_golden_detail = "Data not found in array size of ".sizeof($val_return_detail["data"]["listing"]);
            $val_return_detail_modi = $val_return_detail;

            foreach ($val_return_detail["data"]["listing"] as $each_data)
            {
                if($each_data["ref_tag"] === $reg_tag_array["ref_tag"])
                {
                    $val_return_detail_modi = [];
                    $val_return_detail_modi["info"] = "Found in array size of ".sizeof($val_return_detail["data"]["listing"]);
                    $val_return_detail_modi["data"] = $each_data;
                    $val_golden_detail = "Complete";
                    break;
                }
            }

            $val_golden_detail_json = json_encode($val_golden_detail);
            $val_return_detail_json = json_encode($val_return_detail_modi);
            $note = "Return value -- $val_return_detail_json <br>";
            $note = $note."Golden value -- $val_golden_detail_json";
            $this->unit->run($val_return_detail["status"], $val_golden_detail, "Test lm_porperties_listing libraries display filter data for $service_type", $note);

            //--------------- Test on unique/distinct filtering -------------------------------
            // Invoke unique data search
            $unique_country_filter_struct["limit"] = NULL;   // display all data 
            $unique_country_filter_struct["filter"]["activate"] = '1';     // Data filter example
            $unique_country_filter_struct["filter"]["service_type"] = $service_type;
            
            if ($service_type == "ROOM")
            { 
               $unique_country_filter_struct["filter"]["property_category"] = "Room";
            }
     
            
            $this->CI->properties_listing_lib->get_display_data(json_encode($unique_country_filter_struct));

            $val_return_unique_country =  $this->CI->properties_listing_lib->get_return_data_set();
            
            if(array_key_exists("count", $val_return_unique_country["data"]) && $val_return_unique_country["data"]["count"] > 0)
            {
                $val_golden_detail = "Complete";
            }
            else
            {
                $val_golden_detail = "Data not found in array size of ".$val_return_unique_country["data"]["count"];
            }
            
            $val_golden_detail_json = json_encode($val_golden_detail);
            $val_return_detail_json = json_encode($val_return_unique_country);
            $note = "Return value -- $val_return_detail_json <br>";
            $note = $note."Golden value -- $val_golden_detail_json";
            $this->unit->run($val_return_detail["status"], $val_golden_detail, "Test lm_porperties_listing libraries unique country display filter data for $service_type", $note);


            //---------------- Test on listing update  --------------------------------
            // Edit listing information
            $edit_data = $property_info;
            $edit_data["ref_tag"] = $reg_tag_array["ref_tag"];
            
            if ($service_type == "ROOM")
            {
                $edit_data["property_category"] = "Room";
                $edit_data["property_type"] = "Master";
            }
            else if ($service_type == "SELL")
            {
                $edit_data["property_category"] = "Industrial";
                $edit_data["property_type"] = "Factories";
            }
            else
            {
                $edit_data["property_category"] = "Shop";
                $edit_data["property_type"] = "Shop House";
            }
            
            
            $facility_edit_array =  array("BusinessCenter", "NURSERY", "JACUZZI");
            $edit_data["facilities"] = $facility_edit_array;
            
            $this->CI->properties_listing_lib->insert_properties_listing(json_encode($edit_data));
            $val_return_edit =  $this->CI->properties_listing_lib->get_return_data_set();
            
            $val_golden_edit = "Complete";
            if($val_return_edit["status"] == $val_golden_edit)
            {
                // Additional checking to confirm data change
                $this->CI->properties_listing_lib->get_detail_listing(json_encode($reg_tag_array));
                $val_return_detail =  $this->CI->properties_listing_lib->get_return_data_set();

                if (($service_type == "ROOM" && $val_return_detail["data"]["property_type"] !== "Master") ||
                    ($service_type == "SELL" && $val_return_detail["data"]["property_type"] !== "Factories") ||
                    ($service_type == "RENT" && $val_return_detail["data"]["property_type"] !== "Shop House")
                    )
                {
                    $val_golden_edit = "Fail to edit data as detected property_type return is: ".json_encode($val_return_detail);
                }
                if ($val_return_detail["data"]["facilities"] !== $facility_edit_array)
                {
                    $val_golden_edit = "Fail to edit data as detected facility return is: ".json_encode($val_return_detail);
                }
            }
            
            $val_golden_edit_json = json_encode($val_golden_edit);
            $val_return_edit_json = json_encode($val_return_edit);
            $note = "Return value -- $val_return_edit_json <br>";
            $note = $note."Golden value -- $val_golden_edit_json";
            $this->unit->run($val_return_edit["status"], $val_golden_edit, "Test lm_porperties_listing libraries edit data for $service_type", $note);
            
            
            //---------------- Test on activation status update --------------------------------
            // Change listing activation status
            $activate_data = $reg_tag_array;
            $activate_data["user_id"] = $property_info["user_id"];
            $activate_data["activate"] = false;

            $this->CI->properties_listing_lib->change_listing_activate(json_encode($activate_data));
            $val_return_deactivate =  $this->CI->properties_listing_lib->get_return_data_set();

            $val_golden_deactivate = "Complete";
            if($val_return_deactivate["status"] == $val_golden_deactivate)
            {
                // Additional checking to confirm data change
                $this->CI->properties_listing_lib->get_detail_listing(json_encode($reg_tag_array));
                $val_return_detail =  $this->CI->properties_listing_lib->get_return_data_set();

                if ($val_return_detail["data"]["activate"] !== "0")
                {
                    $val_golden_deactivate = "Fail to set activate as data: ".json_encode($val_return_detail);
                }
            }

            $val_golden_deactivate_json = json_encode($val_golden_deactivate);
            $val_return_deactivate_json = json_encode($val_return_deactivate);
            $note = "Return value -- $val_return_deactivate_json <br>";
            $note = $note."Golden value -- $val_golden_deactivate_json";
            $this->unit->run($val_return_deactivate["status"], $val_golden_deactivate, "Test lm_porperties_listing libraries chagne activate data for $service_type", $note);

            //---------------- Test on data delete --------------------------------
            // Invoke data delete
            $this->CI->properties_listing_lib->remove_properties_listing(json_encode($reg_tag_array));
            $val_return_delete =  $this->CI->properties_listing_lib->get_return_data_set();

            $val_golden_delete = "Complete";
            $val_golden_delete_json = json_encode($val_golden_delete);
            $val_return_delete_json = json_encode($val_return_delete);
            $note = "Return value -- $val_return_delete_json <br>";
            $note = $note."Golden value -- $val_golden_delete_json";
            $this->unit->run($val_return_delete["status"], $val_golden_delete, "Test lm_porperties_listing libraries remove data for $service_type", $note);
        }

   }
   
   private function _model_test()
   {
       // Load properties listing model
       $this->CI =& get_instance();
       
       // Get dummy data
       $property_info_json = $this->_dummy_data_set(true);
       
       // Load model and perform insert
       $this->CI->load->model('properties_listing_model');
       $this->CI->properties_listing_model->insert_data($property_info_json);
       $val_return_insert = $this->CI->properties_listing_model->get_return_data_set();
       
       $val_golden_insert = "Complete";
       $val_golden_insert_json = json_encode($val_golden_insert);
       $val_return_insert_json = json_encode($val_return_insert);
       $note = "Return value -- $val_return_insert_json <br>";
       $note = $note."Golden value -- $val_golden_insert_json";
       $this->unit->run($val_return_insert["status"], $val_golden_insert, "Test lm_porperties_listing module record data", $note);
       
   }
   
   public function test_generic_api()
   {
       // ====== Test country state obtain
        // 
        //  Setup libraries
        $this->CI =& get_instance();
        $this->CI->load->library('properties_listing_lib');
        
        // Prepare filter data structure
        //$filter_struct["filter"]["country"] = "Malaysia";

        // Invoke data search
        $this->CI->properties_listing_lib->get_country_state(NULL);

        $val_return_detail =  $this->CI->properties_listing_lib->get_return_data_set();
        
        $val_golden_detail_json = "Pass";
        
        if ($val_return_detail["data"]["count"] != 14)
        {
            $val_return_detail["status"] = "Fail";
            $val_golden_detail_json = "Not have 14 state";
        }
        //$val_golden_detail_json = json_encode($val_golden_detail);
        $val_return_detail_json = json_encode($val_return_detail);
        $note = "Return value -- $val_return_detail_json <br>";
        $note = $note."Golden value -- $val_golden_detail_json";
        $this->unit->run($val_return_detail["status"], "Complete", "Test lm_porperties_listing libraries display filter data for country_state", $note);
   }
   
   public function test_list()
   {   
       $this->test_generic_api();
       //$this->_model_test();
       $this->_library_test();
       echo $this->unit->report();
   }
}
?>
