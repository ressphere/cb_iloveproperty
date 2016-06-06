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
    
    public function get_currency_type_enum($currency_type)
    {
        return CurrencyFactory::get_currency_type_enum(json_decode($currency_type, TRUE)['currency']);
    }
    
    public function get_currency_type_string($currency_type)
    {
        return CurrencyFactory::get_currency_type_string(json_decode($currency_type, TRUE)['currency']);
    }
    
    public function currency_converter_to_any($currency)
    {
        $currency_info = json_decode($currency, TRUE);
        $value = $currency_info['value'];
        $from = $currency_info['from'];
        $to = $currency_info['to'];
        
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
            $to_currency_type_enum = $to_currency;
            if(!is_numeric($to_currency))
            {
                $to_currency_type_enum =  $this->CurrencyFactoryObj->get_currency_type_enum($to_currency);
            }
            $currency_info = array(
              'value'=>  $currency_value,
              'from'=> $from_currency,
              'to'=> $to_currency_type_enum
            );
            
            
            
            $converted_currency_value = $this->currency_converter_to_any(json_encode($currency_info));
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
