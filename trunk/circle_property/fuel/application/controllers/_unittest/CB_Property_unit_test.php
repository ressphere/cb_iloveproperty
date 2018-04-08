<?php
require_once dirname(dirname(__FILE__)).'/CBWS_Service/CB_Property.php';
require_once 'unit_test_main.php';

// To invoke the unit test, please try following link
//   http://localhost/cb_iloveproperty/trunk/circle_property/_unittest/CB_Property_unit_test/test_list

class CB_Property_unit_test extends unit_test_main
{
    function __construct() {
        parent::__construct();
        
        $current_file_name = pathinfo(__FILE__, PATHINFO_FILENAME);
        $this->benchmark_dump_file("\n".$current_file_name);
        
    }
    
    ###########################unit test region####################################
    public function _unit_test_feature() {
        // Dummy input
        // @todo - To have better and reasonable dummy data
        $input_data_json = "{\"email\":\"chunmuntan@yahoo.com\",\"phone\":\"012-2825725\",\"service_type\":\"SELL\",\"price\":\"1000000.00\",\"auction\":\"09\\\/09\\\/2014\",\"buildup\":\"1500\",\"landarea\":\"2000\",\"bedrooms\":\"3\",\"bathrooms\":\"2\",\"ref\":\"10f5d5ba60f968debf8a2e414511809e\",\"furnished_type\":\"Full Furnished\",\"occupied\":\"No\",\"monthly_maintanance\":\"0.00\",\"remark\":\"gsgaha\",\"property_category\":\"Condo/Residence\",\"property_type\":\"Condo\",\"tenure\":\"Freehold\",\"transportation\":[\"Klia Express\",\"Stesen Monorail KL Sentral\",\"Stesen Putra Lrt Pasar Seni (kj24)\",\"KL Sentral\",\"Ekspres Rail Link\"],\"active\":1,\"user_id\":\"1\",\"property_photo\":[],\"facilities\":[\"BusinessCourt\",\"MINIMART\",\"CLUB\"],\"nearest_spot\":[\"Klia Express\",\"Stesen Monorail KL Sentral\",\"Stesen Putra Lrt Pasar Seni (kj24)\",\"KL Sentral\",\"Ekspres Rail Link\",\"Smk (p) Methodist (m)\",\"Institut Pengurusan Kesihatan\",\"Malaysia Aikido Association\",\"City Point\",\"Klinik Kesihatan Tanglin\",\"Agrobank\",\"PETRONAS - Bangsar\",\"Petron Jalan Tun Sambanthan\"]}";
        
        // Create component object
        $cb_property = new CB_Property();
        
        // Build service array
        $service_upload_listing = [
            "service" => "CB_Property:upload_listing",
            "send_data" => $input_data_json,
            "AUTH" => true
        ];
        
        $val_return = $cb_property->invoke_service($service_upload_listing);
        
        $val_return_json = json_encode($val_return);
        $val_golden = "";
        $note = "return result -- $val_return_json <br>";
        
        $this->unit->run($val_return_json, $val_golden, "Test CB_Property class upload_listing API", $note);
       
   }
   
   private function _unit_test_CBWS_CB_Property()
   {
        // ---------------- Test on feature -------------------------------------
        // Dummy data for input
        $input_data_list = array(
                "SELL" => array(
                    "service_type" => "SELL",
                    "currency" => "MYR",
					"size_measurement_code"=>"sqft",
                    "price"=>"500000.00",
                    "auction"=>"",
                    "buildup"=>"1500",
                    "landarea"=>"2000",
                    "car_park"=>"4",
                    "bedrooms"=>"3",
                    "bathrooms"=>"2",
                    //"ref_tag"=>"b0ac54efa448aeb66890ee4b865cd0a9",
                    "furnished_type"=>"Full Furnished",
                    "occupied"=>"No",
                    "monthly_maintanance"=>"200.00",
                    "remark"=>"Fot testing sell purpose",
                    "property_category"=> "Condo/Residence",
                    "property_type"=> "Condo",
                    "tenure"=>"Freehold",
                    "land_title_type"=>"Residential",
                    "active"=>1,
                    "user_id"=>"1",
                    "property_photo"=>[],
                    "facilities"=>["BBQ"],
                    "unit_name"=>"N-park Condominium Jalan Batu Uban Gelugor Penang Malaysia",
                    "state"=>"Pulau Pinang",
                    "area"=>"Gelugor",
                    "postcode"=>"11700",
                    "street"=>"Jalan Batu Uban",
                    "country"=>"Malaysia",
                    "location"=>array(
                        "k"=>3.1403075200382,
                        "B"=>101.68664550781),
                    "reserve_type"=>"BUMI LOT"
                ),
                "RENT" => array(
                    "service_type" => "RENT",
                    "currency" => "MYR",
					"size_measurement_code"=>"sqft",
                    "price"=>"6000.00",
                    "buildup"=>"100",
                    "landarea"=>"200",
                    "car_park"=>"1",
                    "bedrooms"=>"3",
                    "bathrooms"=>"2",
                    //"ref_tag"=>"b0ac54efa448aeb66890ee4b865cd0a9",
                    "furnished_type"=>"No Furnished",
                    "occupied"=>"Yes",
                    "remark"=>"Fot testing Rent purpose",
                    "property_category"=> "Land",
                    "property_type"=> "Bungalow Land",
                    "land_title_type"=>"Residential",
                    "active"=>1,
                    "user_id"=>"1",
                    "property_photo"=>[],
                    "facilities"=>["BBQ"],
                    "unit_name"=>"N-park Condominium Jalan Batu Uban Gelugor Penang Malaysia",
                    "state"=>"Pulau Pinang",
                    "area"=>"Gelugor",
                    "postcode"=>"11700",
                    "street"=>"Jalan Batu Uban",
                    "country"=>"Malaysia",
                    "location"=>array(
                        "k"=>3.1403075200382,
                        "B"=>101.68664550781),
                ),
            "ROOM" => array(
                    "service_type" => "ROOM",
                    "currency" => "MYR",
					"size_measurement_code"=>"sqft",
                    "price"=>"200.00",
                    "car_park"=>"1",
                    "bathrooms"=>"2",
                    //"ref_tag"=>"b0ac54efa448aeb66890ee4b865cd0a9",
                    "furnished_type"=>"Partially Furnished",
                    "occupied"=>"Yes",
                    "remark"=>"Fot testing Room purpose",
                    "property_category"=> "Room",
                    "property_type"=> "Middle Room",
                    "active"=>1,
                    "user_id"=>"1",
                    "property_photo"=>[],
                    "facilities"=>["BBQ"],
                    "unit_name"=>"N-park Condominium Jalan Batu Uban Gelugor Penang Malaysia",
                    "state"=>"Pulau Pinang",
                    "area"=>"Gelugor",
                    "postcode"=>"11700",
                    "street"=>"Jalan Batu Uban",
                    "country"=>"Malaysia",
                    "location"=>array(
                        "k"=>3.1403075200382,
                        "B"=>101.68664550781),
                ),
            );
        
    foreach ($input_data_list as $service_type => $input_data)
    {
        // ========================
        // Test database data insert
        $val_return = $this->SendReceive_Service("CB_Property:upload_listing",json_encode($input_data));

        $val_golden_array["status_information"] = "Info: Successfully inserted data";
        $note = "Return value -- $val_return <br>";
        $note = $note."Golden value -- ".json_encode($val_golden_array);

        $val_return_array = json_decode($val_return, true);
        $this->unit->run($val_return_array["status_information"], $val_golden_array["status_information"], "Test CB_Property upload_listing service for $service_type", $note);

        // Obtain inserted ref_tag
        $ref_tag = $val_return_array["data"];

        // ========================
        // Test detail data extract
        $val_return = $this->SendReceive_Service("CB_Property:listing_detail",json_encode($ref_tag));

        $val_golden_array["status_information"] = "Info: Successfully retrieve data for ".$ref_tag["ref_tag"];
        $note = "Return value -- $val_return <br>";
        $note = $note."Golden value -- ".json_encode($val_golden_array);

        $val_return_array = json_decode($val_return, true);
        $this->unit->run($val_return_array["status_information"], $val_golden_array["status_information"], "Test CB_Property listing_detail service for $service_type", $note);

        // ========================
        // Test on data search

        // Prepare filter data structure
        $filter_struct["limit"] = NULL;   // display all data 
        $filter_struct["offset"] = NULL;   // display all data 
        $filter_struct["filter"]["activate"] = '1';     // Data filter example
        $filter_struct["filter"]["price >"] = '490000';  // Range filter example
        $filter_struct["filter"]["price <"] = '610000';

        $val_return_detail = $this->SendReceive_Service("CB_Property:filter_listing",json_encode($filter_struct));

        $val_return_detail_array = json_decode($val_return_detail, true);
        $val_golden_detail = "Data not found in array size of ".sizeof($val_return_detail_array["data"]);
        $val_return_detail_modi = $val_return_detail_array;

        if ($val_return_detail_array["status"] == "Complete")
        {

            foreach ($val_return_detail_array["data"]["listing"] as $each_data)
            {
                if($each_data["ref_tag"] === $ref_tag["ref_tag"])
                {
                     $val_return_detail_modi = [];
                     $val_return_detail_modi["info"] = "Found in array size of ".sizeof($val_return_detail_array["data"]);
                     $val_return_detail_modi["data"] = $each_data;
                     $val_golden_detail = "Complete";
                     break;
                 }
             }
        }
        $val_golden_detail_json = json_encode($val_golden_detail);
        $val_return_detail_json = json_encode($val_return_detail_modi);
        $note = "Return value -- $val_return_detail_json <br>";
        $note = $note."Golden value -- $val_golden_detail_json";
        $this->unit->run($val_return_detail_array["status"], $val_golden_detail, "Test CB_Property filter_listing service for $service_type", $note);
        
        // ========================
        //  Test on unique/distinct filtering
        // Invoke data search
        $unique_country_filter_struct["limit"] = NULL;   // display all data 
        $unique_country_filter_struct["filter"]["activate"] = '1';     // Data filter example
        $unique_country_filter_struct["filter"]["service_type"] = $service_type;
        
        $val_return_detail = $this->SendReceive_Service("CB_Property:get_display_data",json_encode($unique_country_filter_struct));

        $val_return_detail_array = json_decode($val_return_detail, true);
        $val_golden_detail = "Data not found in array size of ".sizeof($val_return_detail_array["data"]);

        if(array_key_exists("count", $val_return_detail_array["data"]) && $val_return_detail_array["data"]["count"] > 0)
        {
            $val_golden_detail = "Complete";
        }
        else
        {
            $val_golden_detail = "Data not found in array size of ".$val_return_detail["data"]["count"];
        }

        $val_golden_detail_json = json_encode($val_golden_detail);
        $val_return_detail_json = json_encode($val_return_detail_array);
        $note = "Return value -- $val_return_detail_json <br>";
        $note = $note."Golden value -- $val_golden_detail_json";
        $this->unit->run($val_return_detail_array["status"], $val_golden_detail, "Test CB_Property get_display_data service for $service_type", $note);
        

        // ========================
        // Test on user data listing profile retrieve
        $user_id["user_id"] = $input_data["user_id"];
        $val_return = $this->SendReceive_Service("CB_Property:user_listing_condition",json_encode($user_id));
        $val_return_array = json_decode($val_return, true);

        $val_golden_array["status_information"] = "Info: Successfully retrieve data listing user listing condition";
        if ($val_return_array["data"]["activate_num"] < 1)
        {
            $val_golden_array["status_information"] = "Doesn't detect any activate listing, which it should";
        }

        $note = "Return value -- $val_return <br>";
        $note = $note."Golden value -- ".json_encode($val_golden_array);

        $this->unit->run($val_return_array["status_information"], $val_golden_array["status_information"], "Test CB_Property user_listing_condition service for $service_type", $note);

        
        // ========================
        // Test database data edit test
        $edit_data = $input_data;
        $edit_data["ref_tag"] = $ref_tag["ref_tag"];
        if ($service_type == "ROOM")
        {
            $edit_data["property_category"] = "Room";
            $edit_data["property_type"] = "Small Room";
        }
        else if ($service_type == "SELL")
        {
            $edit_data["property_category"] = "Office";
            $edit_data["property_type"] = "Office Suite";
        }
        else
        {
            $edit_data["property_category"] = "Apartment/Flat";
            $edit_data["property_type"] = "Other";
        }
        $facility_edit_array =  array("MINIMART", "TENNIS");
        $edit_data["facilities"] = $facility_edit_array;
            
        $val_return = $this->SendReceive_Service("CB_Property:upload_listing",json_encode($edit_data));
        $val_return_array = json_decode($val_return, true);

        $val_golden_array["status_information"] = "Info: Successfully inserted data";
        if($val_return_array["status_information"] == $val_golden_array["status_information"])
        {
              // Additional checking to confirm data change
              $val_return_detail_json = $this->SendReceive_Service("CB_Property:listing_detail",json_encode($ref_tag));
              $val_return_detail = json_decode($val_return_detail_json, TRUE);

              if ( ( $service_type == "ROOM" && $val_return_detail["data"]["property_type"] !== "Small Room") ||
                   ( $service_type == "SELL" && $val_return_detail["data"]["property_type"] !== "Office Suite") ||
                   ( $service_type == "RENT" && $val_return_detail["data"]["property_type"] !== "Other")
                 )
              {
                  $val_golden_array["status_information"] = "Fail to edit property_data as data: ".$val_return_detail_json;
              }
              if ($val_return_detail["data"]["facilities"] !== $facility_edit_array)
              {
                  $val_golden_array["status_information"] = "Fail to edit facility as data: ".$val_return_detail_json;
              }
        }

        $note = "Return value -- $val_return <br>";
        $note = $note."Golden value -- ".json_encode($val_golden_array);

        $this->unit->run($val_return_array["status_information"], $val_golden_array["status_information"], "Test CB_Property upload_listing service to edit data for $service_type", $note);

        
        // ========================
        // Test database data change activate status
        $activate_data = $ref_tag;
        $activate_data["user_id"] = $input_data["user_id"];
        $activate_data["activate"] = false;

        $val_return = $this->SendReceive_Service("CB_Property:change_listing_activate",json_encode($activate_data));
        $val_return_array = json_decode($val_return, true);

        $val_golden_array["status_information"] = "Info: Complete change activation status";
        if($val_return_array["status_information"] == $val_golden_array["status_information"])
        {
              // Additional checking to confirm data change
              $val_return_detail_json = $this->SendReceive_Service("CB_Property:listing_detail",json_encode($ref_tag));
              $val_return_detail = json_decode($val_return_detail_json, TRUE);

              if ($val_return_detail["data"]["activate"] !== "0")
              {
                  $val_golden_array["status_information"] = "Fail to set activate as data: ".$val_return_detail_json;
              }
        }

        $note = "Return value -- $val_return <br>";
        $note = $note."Golden value -- ".json_encode($val_golden_array);

        $this->unit->run($val_return_array["status_information"], $val_golden_array["status_information"], "Test CB_Property change_listing_activate service for $service_type", $note);


        // ========================
        // Test database data delete

        $val_return = $this->SendReceive_Service("CB_Property:delete_listing",json_encode($ref_tag));

        $val_golden_array["status_information"] = "Info: Successfully deleted data";
        $note = "Return value -- $val_return <br>";
        $note = $note."Golden value -- ".json_encode($val_golden_array);

        $val_return_array = json_decode($val_return, true);
        $this->unit->run($val_return_array["status_information"], $val_golden_array["status_information"], "Test CB_Property delete_listing service for $service_type", $note);
    }
   }
   
   public function test_generic_api()
   {
        // -------------- Simple test -------------------------------------------
        // Test CB_Property gateway
        $val_return = $this->SendReceive_Service("CB_Property:test_service","Test CB_AUTH gateway");

        $golden = array();
        $golden["service"] = "CB_Property:test_service";
        $golden["status"] = "Complete";
        $golden["status_information"] = "Info: Complete CB_Property:test_service Service"; 
        $golden["data"] = "Test CB_AUTH gateway"; 

        $val_golden = json_encode($golden);
        $note = "Return value -- $val_return <br>";
        $note = $note."Golden value -- $val_golden";

        $this->unit->run($val_return, $val_golden, "Test CB_Property AUTH Send Recieved gateway", $note);
        
        // -------------- Generic API test -------------------------------------------
        // Test country state obtain
        // Prepare filter data structure
        $filter_struct["filter"]["country"] = 'Malaysia';     // Data filter example

        $val_return_detail = $this->SendReceive_Service("CB_Property:get_country_state",json_encode($filter_struct));
        $val_return_detail_array = json_decode($val_return_detail, true);
        
        $val_golden_detail_json = "Complete";
        
        if ($val_return_detail_array["data"]["count"] != 14)
        {
            $val_return_detail_array["status"] = "Fail";
            $val_golden_detail_json = "Not have 14 state";
        }

        $note = "Return value -- $val_return_detail <br>";
        $note = $note."Golden value -- $val_golden_detail_json";
        
        $val_golden_detail = "Data not found in array size of ".sizeof($val_return_detail_array["data"]);
        $this->unit->run($val_return_detail_array["status"], $val_golden_detail_json, "Test CB_Property filter_listing service for country and state", $note);

   }
   
   public function test_list()
   {
       $this->test_generic_api();
       
       // Unit_test wrap around fail this, temporary disable
       //$this->_unit_test_feature();
       $this->_unit_test_CBWS_CB_Property();
       echo $this->unit->report();
   }

}
?>
