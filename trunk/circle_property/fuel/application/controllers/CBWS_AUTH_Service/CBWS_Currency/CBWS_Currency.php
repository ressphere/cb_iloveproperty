<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CBWS_Currency {
    private $CI = NULL;
    private $CurrencyFactoryObj = NULL;
    function __construct() {
        $this->CI =& get_instance();
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $this->CI->load->library('currency_convertor');
        $this->CurrencyFactoryObj = new currency_convertor();
    }

    public function get_supported_currency()
    {
        
        return $this->CurrencyFactoryObj->get_supported_currency();
    }
     
    private function currency_converter_to_any($value ,$from, $to)
    {
        $CurrencyFactoryObj = $this->CurrencyFactoryObj->build($from);
        try
        {
            return $CurrencyFactoryObj->get_result($to, $value);
        }
        catch (Exception $e) {
            $this->set_error("Invalid unit type: " . $from);
            $this->set_error($e);
            return FALSE;
        }
    }
    
    public function get_converted_currency_value($currency_conversion)
    {
        $currency_conversion_obj = json_decode($currency_conversion, TRUE);
        $currency_value = $currency_conversion_obj['currency_value'];
        $from_currency = $currency_conversion_obj['from_currency'];
        $to_currency = $currency_conversion_obj['to_currency'];
        if($currency_value && $from_currency && $to_currency)
        { 
            $to_currency_type_enum =  $this->CurrencyFactoryObj->get_currency_type_enum($to_currency);
            
            
            $converted_currency_value = $this->currency_converter_to_any($currency_value, $from_currency, $to_currency_type_enum);
            if(is_numeric($converted_currency_value))
            {
                 return $converted_currency_value;
            }
            else
            {
                 return "--";
            }
        }
        else
        {
            return "--";
        }
    }
    
   
}


?>
