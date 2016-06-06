<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(dirname(__FILE__)).'/properties_base.php';
require_once 'measurement_type_manager.php';
require_once 'GeneralFunc.php';

class properties_info extends properties_base {
    
    // =============== Defult list
    /*
     * location and contries list
     *
     */
    function obtain_location_list ()
    {
        // ------------------------
        // Base settings  
        $database_list = [
            "selected_country" => "Malaysia",
            "selected_state" => "Pulau Pinang",
            "property_category_selection" => "All Category",
            "property_type_selection" => "All Type",
        ];
        
        // --------------------------
        // Retrieve filter data for country, state, property_type and property_category
        $base_filter_struct["filter"]["activate"] = '1';      // Only display data that active
        $base_filter_struct["filter"]["service_type"] = $this->session->userdata('action');    // Display related listing type
        
        $get_display_data_service = "CB_Property:get_display_data";
        $get_display_data_return = GeneralFunc::CB_SendReceive_Service_Request($get_display_data_service,json_encode($base_filter_struct));

        $get_display_data_return_array = json_decode($get_display_data_return, true);
        
        // @todo - require better error handing
        $query_data_array = $get_display_data_return_array["data"]["query_data"];
        
        // --------------------------
        // Decode data
        $filter_property_type = array();
        $country_state_first_conv = array();
        foreach ($query_data_array as $single_query_data)
        {
            // property_category_type_list
            $property_category = $single_query_data["property_category"];
            $property_type = $single_query_data["property_type"];
            if(! array_key_exists($property_category, $filter_property_type)) $filter_property_type[$property_category] = array("All Type");
            if(! in_array($property_type, $filter_property_type[$property_category])) array_push($filter_property_type[$property_category], $property_type);
            
            // Country and state
            $state = $single_query_data["state"];
            $country = $single_query_data["country"];
            if(! array_key_exists($country, $country_state_first_conv)) $country_state_first_conv[$country] = array();
            if(! in_array($state, $country_state_first_conv[$country])) array_push($country_state_first_conv[$country], $state);
        }
                
        // insert initial data for property list
        $database_list["property_category_type_list"] = $filter_property_type;
        $database_list["property_category_type_list"]["All Category"] = array("All Type");

        // --------------------------
        // Retrieve country and state
        $database_list["location_list"] = $country_state_first_conv;
        
        /*
        // file dump -- for develop purpose -- Start --
        $current = "\n------------------------------\n";
        $current .= "initial data -- \n".json_encode($database_list)."\n";
        $current .= "filter data -- \n".json_encode($filter_property_type)."\n";
        $current .= "\n";
        error_log($current, 3, "D:/webdev/resphere_test_dump.txt");
        // file dump -- for develop purpose -- End --*/
        
        // ----------------------
        // Pass data out
        echo json_encode( $database_list);
    }
    
    /*
     * Obtain currencies list
     */
    function obtain_currencies_list ()
    {
        $get_country_state = "CB_Property:get_country_state";
        $get_country_state_return = GeneralFunc::CB_SendReceive_Service_Request($get_country_state,NULL);

        $get_country_state_return_array = json_decode($get_country_state_return, true);
        $country_raw_array = $get_country_state_return_array["data"]["currency"];
        
        // Arrange data nicely
        $currency_array = array();
        
        foreach ($country_raw_array as $single_detail_data)
        {
            $single_list = array();
            $single_list["currency_code"] = $single_detail_data["currency_code"];
            $single_list["currency_name"] = $single_detail_data["currency_name"];
            
            array_push($currency_array, $single_list);
        }
        
        echo json_encode($currency_array);
    }
    
    /*
     * Retrieved highlight prorperty
     *  @check - will be disable for stage 1
     */
    function obtain_highlight_result ()
    {
        // Obtain data from session, preload in page load php
        $page_category  = $this->session->userdata('action');
        
        // Obtain data from pass in
        
        // Pump data
        $highlight_result = [
            [
                "name" => $page_category,
                "price" => "RM 1,000,000.00",
                "sqft" =>"1000sqft",
                "image" =>"http://www.ressphere.com/assets/images/property_listing/example_pic.jpg"
                ],
            [
                "name" => "Highlight 2",
                "price" => "RM 2,000,000.00",
                "sqft" => "2000sqft",
                "image" => "http://www.ressphere.com/assets/images/property_listing/example_pic.jpg"
                ],
            [
                "name" => "Highlight 3",
                "price" =>"RM 3,000,000.00",
                "sqft" =>"3000sqft",
                "image" => "http://www.ressphere.com/assets/images/property_listing/example_pic.jpg"
                ],
            [
                "name" => "Highlight 4",
                "price" => "RM 4,000,000.00",
                "sqft" => "4000sqft",
                "image"=>"http://www.ressphere.com/assets/images/property_listing/example_pic.jpg"
                ],
            [
                "name" => "Highlight 5",
                "price" => "RM 5,000,000.00",
                "sqft" => "5000sqft",
                "image" => "http://www.ressphere.com/assets/images/property_listing/example_pic.jpg"
                ]
            ];
        
        echo json_encode( $highlight_result );
    }
    
    /*
     * contruct the max min range base on currency
     */
    function construct_currency_range($max, $min, $from, $to)
    {
        $price_range = array();
        if($min !== NULL)
        {
            array_push($price_range, $this->currency_converter_to_any($min, $from, $to));
        }
        else
        {
            array_push($price_range, $min);
        }
        if($max !== NULL)
        {
            array_push($price_range, $this->currency_converter_to_any($max, $from, $to));
        }
        else
        {
            array_push($price_range, $max);
        }
        return $price_range;
    }
    
    function construct_width_range($max, $min, $from, $to)
    {
        
        try
        {
            $width_range = array();

            if($min !== NULL)
            {
                array_push($width_range, $this->size_unit_converter_to_any($min, $from, MeasurementFactory::get_measurement_type_enum($to)));
            }
            else
            {
                array_push($width_range, $min);
            }
            if($max !== NULL)
            {
                 array_push($width_range, $this->size_unit_converter_to_any($max, $from, MeasurementFactory::get_measurement_type_enum($to)));
            }
            else
            {
                array_push($width_range, $max);
            }
            return $width_range;
        }
        catch(Exception $e)
        {
            $this->set_error($e);
        }
   
        
    }
    function convert_search_result_to_data($query_data)
    {
        $data = array();
        // Name process, restrict to 15 width
        $name = substr($query_data["property_name"], 0, 15);
        if(strlen($name) != strlen($query_data["property_name"]))
        {
            $name = $name."...";
        }

        $data["name"] = $name;

        $data["ref_tag"] = $query_data["ref_tag"];

        $data["price"] = $query_data["price"];
        $data["sqft"] = $query_data["buildup"];
        $data["measurement_type"] = $query_data["size_measurement_code"];
        $data["furnished_type"] = $query_data["furnished_type"];

        $timestamp = strtotime($query_data["activate_time"]);
        $data["date"] = date('d/m/Y', $timestamp);

        $data["room"] = $query_data["bedrooms"];
        $data["currency"] = $query_data["currency"];
        $data["wc"] = $query_data["bathrooms"];

        //@todo - need to settel parking, which current data don't have
        $data["parking"] = "--";

        // Image process
        $image_array = $this->_get_array_value($query_data, "property_photo");
        if(!empty($image_array))
        {
            // Always take the first one as display
            $data["image"] = $image_array[0]["path"];
        }
        return $data;

    }
    public function convert_currency_from_enum_to_string($currency_in_enum)
    {
        $argument = json_encode(array(
                "currency"=>$currency_in_enum
            ));
        $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Currency:get_currency_type_string", 
                $argument);
        return json_decode($val_return, TRUE)["data"]["result"];
    }
    public function get_currency_list()
    {
        
        $val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Currency:get_currency_list", NULL);
           
        return json_decode($val_return, TRUE)['data']['result'];
    }
    /*
     * Retrieved search result
     */
    function obtain_search_result ()
    {
        // display per page
        
        $limit = 9;//
        
        $search_result["nav_total_page"] = 0;
        $search_result["total_result"] = 0;
        $search_result["search_result"] = array();
        $ref_tag_list = array();
        
        // Special handle for property_type_selection
        $property_category_selection = $this->_get_array_value($_GET,"property_category_selection");
        
        if($property_category_selection === "All Category")
        {
            $property_category_selection = NULL;
        }
        
        $property_type_selection = $this->_get_array_value($_GET,"property_type_selection");
        if($property_type_selection === "All Type")
        {
            $property_type_selection = NULL;
        }
        
        // Process page nav if no pass in
        $page_nav_num = $this->_get_array_value($_GET,"nav_page");
        if ($page_nav_num == NULL || $page_nav_num <= 0 ) {$page_nav_num = 1;}
        
        $origin_max = $this->_get_array_value($_GET,"max_price");
        $origin_min = $this->_get_array_value($_GET,"min_price");
        $origin_currency = $this->_get_array_value($_GET,"currency");
        
        $measurement_max = $this->_get_array_value($_GET,"max_sqft");
        $measurement_min = $this->_get_array_value($_GET,"min_sqft");
        $origin_measurement_type = $this->_get_array_value($_GET, "measurement_type");
        
        //$supported_currency = $this->get_currency_list();
        //$val_return = GeneralFunc::CB_SendReceive_Service_Request("CB_Currency:get_currency_list", NULL);
        $supported_currency = $this->get_currency_list();
        
        //$supported_currency = json_decode($val_return, TRUE)['data']['result'];
        for($i = 0; $i < count($supported_currency); $i++)
        {
            $currency_enum_to_string = $this->convert_currency_from_enum_to_string($i);
            
            for($j = 0; $j < measurement_type::__len; $j++)
            {
                $price_range = $this->construct_currency_range($origin_max, $origin_min, 
                        $origin_currency, $i);
                
                $width_range =  $this->construct_width_range($measurement_max, $measurement_min, 
                        $origin_measurement_type, MeasurementFactory::get_measurement_type_string($j));
                
                $filter_array = array(
                    "limit" => $limit,
                    "offset" => ($limit*($page_nav_num-1)),
                    "filter" => array(
                        // Only obtain those still active
                        "activate" => 1,

                        // Obtain data from session, preload in page load php
                        "service_type" => $this->session->userdata('action'),
                        //"service_type" => $this->_get_array_value($_GET,"search_property_type"),

                        // data filter
                        "state" => $this->_get_array_value($_GET,"selected_state"),
                        "country" => $this->_get_array_value($_GET,"selected_country"),
                        "property_category" => $property_category_selection,
                        "property_type" => $property_type_selection,
                        "unit_name" => $this->_get_array_value($_GET,"place_name"),
                        //"bedrooms" => $this->_get_array_value($_GET,"bedroom"),

                        "price <=" => ($price_range[1] === "" || $price_range[1] === "0.00")? NULL:$price_range[1],
                        "price >=" => $price_range[0],
                        // CK say should be build up
                        "buildup <=" => ($width_range[1] === "" || $width_range[1] === "0.00")? NULL:$width_range[1],
                        "buildup >=" => $width_range[0],
                        		
                        "currency" => $currency_enum_to_string,
                        "size_measurement_code" =>  MeasurementFactory::get_measurement_type_string($j)
                    ),
                );

                // Invoke webservice to retrieve filter data
                $service = "CB_Property:filter_listing";
                $val_return = GeneralFunc::CB_SendReceive_Service_Request($service,json_encode($filter_array));
                
                if($val_return === NULL)
                {
                    continue;
                }
                $val_return_json_array = json_decode($val_return, true);

                // @todo - require better error handing
                $val_return_array = $val_return_json_array["data"];

                // Align the data with output requirement
                
                foreach ($val_return_array["listing"] as $query_data)
                {
                    if (in_array($query_data["ref_tag"], $ref_tag_list)) {
                        $val_return_array["count"] = $val_return_array["count"] - 1;
                    }
                    else
                    {
                        $data = $this->convert_search_result_to_data($query_data);
                        array_push($search_result["search_result"], $data);
                        array_push($ref_tag_list, $data["ref_tag"]);
                    }
                    
                }
                
                $search_result["nav_total_page"] += ceil($val_return_array["count"]/$limit);
                $search_result["total_result"] += $val_return_array["count"];
            }
        
        }   
        
        echo json_encode( $search_result );
    }
    
    /*
     * Return Value if key exist in Array, else NULL
     * 
     * @Param   Array   Array that will be search
     * @Param   String  Keys value that wish to perform check
     * @Return  Value   NULL or value if key hit  
     */
    protected function _get_array_value($array, $key)
    {
        if(array_key_exists($key, $array))
        {
            return $array[$key];
        }
        return NULL;
    }
    
    // @Todo - 
    //  1. number put nicely for prie and filtering, with ',' 
    //  3. Cut the filter character number, incase ppl bypass html check
    //     a place name character (100 character)
    //     b price number (10 decimal, 2 floating)
    //     c sqft (int, 32 bit, 10 character
    
}

?>
