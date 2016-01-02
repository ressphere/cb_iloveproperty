<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'CBWS_Service_Base.php';

/*
 * @Todo - there is some improvement for the CBWS_Servic Base
 *         All implementation should be revisit
 */


/**
 * Circle Product object, use for all processing related to product
 * 
 */
class CB_Product extends CBWS_Service_Base  {
    //--------------------- Global Variable ----------------------
    
    
    //--------------------- Setup Function ----------------------
    /**
     * Normal Constructor that refer to parent constructure
     * 
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
            "get_product_detail"  => TRUE
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
        // Contain all the accepted key
        // Format:
        //   True = Accepted key
        //   False = Disabled key
        $accept_key = array(
            // @Todo - cross check the correctness when data ready
            "name" => true,
            "code" => true,
            "price" => true,
            "description" => true,
            "point" => true,
            "enable" => true
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
            
        );
        
        return $array_key_change;
    }
    
    
    //--------------------- Test Function ----------------------
    /*
     * Test service
     */
    public function test_service($input_data_array)
    {
        $this->set_data("Info: Complete CB_Product:test_service Service",$input_data_array);
    }
    
    //--------------------- Service Function ----------------------
    /*
     * Obtain specific infomation base on product product
     * 
     * @Param Array product_code, handle_fix, handle_percent
     *      product_code - Product code name in database
     *      handle_fee_enable - Set to TRUE if handle fee is required
     *      handle_fix - Handling fee that is at fix rate
     *      handle_percent - Handling fee at decimate format, e.g. 4.4% have to input 0.044
     * 
     * @Return Array total_price, handle_fee, product_price, point[<type>]=value, desc_short, name, desc_long
     */
    public function get_product_detail($request_info)
    {
        $data_return_status = false;
        
        //@Todo - call database and obtain detail info base on product code 
        if($request_info["product_code"] === "AF-188-2")
        {
            $return_info = array(
                "product_price" => "188",
                "point" => array(
                    "p_point" => "188",
                    "f_point" => "2"
                ),
                "desc_short" => "Basic one year agent fee",
                "desc_long" => "Basic one year agent fee with one feature point",
                "name" => "Basic Agent Fee"
            );
            $data_return_status = true;
        }
        
        // No product file
        if ($data_return_status === false)
        {
            $this->set_error("SBPd-gpd-1",
                            "No product found, please contact Admin",
                            "Fail to retrieve product information");
            return NULL;
        }

        // Obtain handling fee
        $cal_info["price"] = (int)$return_info["product_price"];
        $cal_info["fix"] = (float)$request_info["handle_fix"];
        $cal_info["percent"] = (float)$request_info["handle_percent"];

        if($request_info["handle_fee_enable"] === TRUE)
        {
            $return_info["handle_fee"] = $this->_cal_handle_fee($cal_info);
        }
        else
        {
            $return_info["handle_fee"] = 0;
        }

        // Get total fee
        $return_info["total_price"] = $cal_info["price"] + $return_info["handle_fee"];
        
        $status_information = "Info: Obtained product detail for CB_Product";
        $this->set_data($status_information,$return_info);
    }
    
    // Normal model communicate function
    // @todo - get product
    // @todo - Search product
    // @todo - remove product
    // @todo - return all product
    // @todo - return product categories list
    
    //--------------------- Public Function ----------------------
    
    
    
    //--------------------- Internal Function ----------------------
    
    // @Todo - Product regconition from code name and model selection
    
    
    /*
     * Use for calculate handling fee, the amout will round up to first decimate
     *  e.g. 10.64 = 11, 10.01 = 11 to cover up the transaction discrepancy
     * 
     *  Formula is handle_fee = (price*percent + Fix) / (1 - precent)
     * 
     * @param Array price, handle_fix, handle_precent
     *      price - Orignal given price
     *      fix - Handling fee that is at fix rate
     *      percent - Handling fee at decimate format, e.g. 4.4% have to input 0.044
     *  
     * @Return int handling fee
     */
    private function _cal_handle_fee($raw_data)
    {
        $handling_fee = ($raw_data["price"] * $raw_data["percent"] + $raw_data["fix"]) / (1 - $raw_data["percent"]);
        
        return ceil($handling_fee);
    }
    
    /**
     * Insert product data
     * 
     * @param Array $data_array Data that contain all product information using key and value
     */
    private function insert_product_data($input_data_array)
    {
        $this->product_info =  $this->data_key_init($input_data_array, true);
    }  
}


?>
