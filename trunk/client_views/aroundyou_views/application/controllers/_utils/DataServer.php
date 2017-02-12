<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * This file cotain all API which associate with backed Server.
 * Which include some comment/generic information callback
 */

// Request necessary PHP ---- Start ----
require_once 'GeneralFunc.php'; // Contain all the necassary General API
require_once 'ServiceUtils.php'; // Contain all the necassary Service API
//
// Request necessary PHP ---- End ----


/*
 * This class contain all API related to service calling
 * 
 * API list:
 *  - CB_Send_Service_Request
 *  - CB_Receive_Service_Request
 *  - CB_SendReceive_Service_Request
 *  - CB_Test_Gateway
 */
class DataServer__Service
{
    /*
     * For sending data
     * 
     * @Param String Service name to be invoke
     * @Param String Data to be send
     * @Return json  Feed back data
     *              ["service"] Name of the service perform. 
     *              ["status"] Indicate the status of service run (Error, complete or etc). 
     *              ["status_information"] Message return for display purpose.
     */
    static function CB_Send_Service_Request($service, $send_data)
    {
        //$service_obj = new ServiceRequest;
        $service_obj = new ServiceUtils__REST_ServiceRequest;
        $return_data = $service_obj->service_request($service,$send_data,"send");
        return $return_data;
    }
    
    /*
     * For information retrieve 
     * 
     * @Param String Service name to be invoke
     * @Return json  Feed back data
     *              ["service"] Name of the service perform. 
     *              ["status"] Indicate the status of service run (Error, complete or etc). 
     *              ["status_information"] Message return for display purpose. 
     *              ["data"] Output data from the service
     */
    static function CB_Receive_Service_Request($service)
    {
        //$service_obj = new ServiceRequest;
        $service_obj = new ServiceUtils__REST_ServiceRequest;
        $return_data = $service_obj->service_request($service, null,"receive");
        return $return_data;
    }
    
    /*
     * Able to send and retrieve information accordingly 
     * 
     * @Param String Service name to be invoke
     * @Param String Data to be send
     * @Return json  Feed back data
     *              ["service"] Name of the service perform. 
     *              ["status"] Indicate the status of service run (Error, complete or etc). 
     *              ["status_information"] Message return for display purpose. 
     *              ["data"] Output data from the service
     */
    static function CB_SendReceive_Service_Request($service, $send_data)
    {
        //$service_obj = new ServiceRequest;
        $service_obj = new ServiceUtils__REST_ServiceRequest;
        $return_data = $service_obj->service_request($service,$send_data,"sendreceive");
        return $return_data;
    }
    
    /*
     * Use for tseting purpose
     * 
     * @Return json  Feed back data
     *              ["service"] Name of the service perform. 
     *              ["status"] Indicate the status of service run (Error, complete or etc). 
     *              ["status_information"] Message return for display purpose. 
     *              ["data"] Output data from the service
     */
    static function CB_Test_Gateway()
    {
        //$service_obj = new ServiceUtils__REST_ServiceRequest;
        //$return_data = $service_obj->test_gateway();
        
        $service_obj = new ServiceUtils__REST_ServiceRequest;
        $return_data = $service_obj->service_request(null,"ss&bb","test");
        
        return $return_data;

    }
}

/**
 * Handle all general data which associate the circle_property
 * 
 * API list
 *  - get_wsdl_base_url
 *  - get_state_by_country
 *  - get_states
 *  - check_recaptcha
 * 
 */
class DataServer__General
{
    /*
     * Get Ressphere Web service url
     * 
     * @Return  String  Ressphere WSDL base url
     */
    static function get_wsdl_base_url()
    {
        $val_return = DataServer__Service::CB_Receive_Service_Request("CB_Info:base_url");
        $wsdl_base_url = json_decode($val_return, TRUE)["data"]["result"];
        
        return $wsdl_base_url;
    }
    
    /*
     * Obtain list of state from country name
     * 
     * @Param List State for the country (output)
     * @Param String Country that use for country return
     */
    static function get_state_by_country(&$states , $country)
    {
        $filter_struct = array();
        $filter_struct["filter"]["country"] = $country; 
        $val_return_detail = 
                DataServer__Service::CB_SendReceive_Service_Request("CB_Property:get_country_state",
                        json_encode($filter_struct));
        $val_return_detail_array = json_decode($val_return_detail, true);

        foreach($val_return_detail_array["data"]["state_country"] as $state_country)
        {
            array_push($states, $state_country["state"]);
        }
    }
    
    /*
     * Echo list of state to html base on the country store in POST
     * 
     */
    static function get_states()
    {
        $listing = GeneralFunc__Basic::get_posted_value("country_name");
        $states = array();
        if($listing)
        {
            $country = json_decode($listing, TRUE);
            DataServer__General::get_state_by_country($states, $country);
        }
        GeneralFunc__Basic::echo_js_html($states);
        
    }
    
    /*
     * To perform checking on the recaptcha (filter bot/spam) input
     * 
     * @Param String Website name
     * @Param String Input/Respond from user
     * @Param String Hidden field generated by Google reCAPTCHA
     */
    static function check_recaptcha($website_name,$response_field, $challenge_field)
    {
        $captcha_code["remote_addr"] = $website_name; 
        $captcha_code["challenge_field"] = $challenge_field;
        $captcha_code["response_field"] = $response_field;

        $val_return_json = DataServer__Service::CB_SendReceive_Service_Request("CB_Member:check_recaptcha", json_encode($captcha_code));
        $val_return = json_decode($val_return_json, TRUE);
        
        return   $val_return["data"]["result"];
    }
}

/*
 * This class contain all API that handle currency
 * 
 * API List:
 *  - get_currency_type_enum
 *  - get_currency_type_string
 *  - currency_converter_to_any
 */
class DataServer__Currency
{
    /*
     * Obtain representation integer (enum) from curency short name
     * 
     * @Param String Currency short name
     * @Param Integer Currency enum
     */
    static function get_currency_type_enum($current_currency)
    {
        $argument = json_encode(array(
               "currency"=>$current_currency
           ));
        $val_return = DataServer__Service::CB_SendReceive_Service_Request("CB_Currency:get_currency_type_enum",
                $argument);
        return json_decode($val_return, TRUE)['data']['result'];
    }
    
    /*
     * Obtain currency short name from representation integer (enum
     * 
     * @Param Integer Currency enum
     * @Return String Currency short name
     */
    static function get_currency_type_string($currency_enum)
    {
        $argument = json_encode(array(
                "currency"=>$currency_enum
            ));
        $val_return = DataServer__Service::CB_SendReceive_Service_Request("CB_Currency:get_currency_type_string",
                $argument);
        return json_decode($val_return, TRUE)['data']['result'];
    }
    
    /*
     * Convert value from one currency to another currency
     * 
     * @Param Float Currency value to be converted
     * @Param String Currency to be converted from
     * @Param String Currency to be converted to
     * @Return Float Converted value
     * 
     */
    static function currency_converter_to_any($value ,$from, $to)
    {
         $argument = json_encode(array(
                "value"=>$value,
                "from"=>$from,
                "to"=>$to
            ));
        $val_return = DataServer__Service::CB_SendReceive_Service_Request("CB_Currency:currency_converter_to_any",
                $argument);
        return json_decode($val_return, TRUE)['data']['result'];
    }
}

?>
