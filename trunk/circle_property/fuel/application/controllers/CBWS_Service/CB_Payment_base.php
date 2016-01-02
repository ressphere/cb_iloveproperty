<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'CBWS_Service_Base.php';
require_once 'CB_Product.php';


/*
 * @Todo - there is some improvement for the CBWS_Servic Base
 *         All implementation should be revisit
 */



/**
 * Payment Base Class, contain all basic function like retrieve
 *  product, user id and etc
 * 
 */
class CB_Payment_base extends CBWS_Service_Base{

    public $cb_product;
    
    /**
     * Build necessary settings
     */
    public function __construct()
    {
        parent::__construct();
        $this->cb_product = new CB_Product();
    }
    
    /*
     * Check array contain to see the key contain value or not
     *  return "--" if no key or value found 
     * 
     * @Param Array array that be check and value return
     * @Param String key that use for checking
     * 
     * @Return String value of key in array if found, else return "--"
     */
    public function check_array_value($array, $key)
    {
       if(array_key_exists($key, $array)) 
       {
           return $array[$key];
       }
       else
       {
           return "--";
       }
    }
    
    /*
     * API to obtain product information, 
     *  which include price, name and description
     * 
     * @Param Array product_code, handle_fix, handle_percent, handle_fee_enable
     *      product_code - Product code name in database
     *      handle_fee_enable - Set to TRUE if handle fee is required
     *      handle_fix - Handling fee that is at fix rate
     *      handle_percent - Handling fee at decimate format, e.g. 4.4% have to input 0.044
     * 
     * @Return hash product detail (total_price, handle_fee, product_price, point[<type>]=value, desc_short, name, desc_long) and status
     */
    public function get_product_detail($request_info)
    {
        $this->cb_product->get_product_detail($request_info);
        $return_hash = $this->cb_product->get_return_data_set();
        
        return $return_hash;
    }
    
    
    /*
     * API that generate NVP string base on array input
     * NVP string is urlencoded
     * 
     * @Param Array Any string array that ready for conversion
     * @Return String Contain urlencoded NVP string
     */
    private function generateNVPString($array_input)
    {
            $output_nvp_str = '';

            foreach($array_input as $key => $value)
            {
                    $output_nvp_str .= '&'.urlencode($key).'='.urlencode($value);
            }
            return $output_nvp_str;
    }
    
    /** This function will take NVPString and convert it to an Associative Array and it will decode the response.
      * It is usefull to search for a particular key and displaying arrays.
      * @Param nvpstr is NVPString.
      * @Return nvpArray is an Associative Array.
      */
    private function deformatNVP($nvpstr)
    {
        $intial=0;
        $nvpArray = array();

        while(strlen($nvpstr))
        {
                //postion of Key
                $keypos= strpos($nvpstr,'=');
                //position of value
                $valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

                /*getting the Key and Value values and storing in a Associative Array*/
                $keyval=substr($nvpstr,$intial,$keypos);
                $valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
                //decoding the respose
                $nvpArray[urldecode($keyval)] =urldecode( $valval);
                $nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
        }

        return $nvpArray;
    }
}

?>
