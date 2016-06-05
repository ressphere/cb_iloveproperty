<?php
class currency_type {
    const __default = self::MYR;
    const __len = 3;
    const MYR = 0;
    const USD = 1;
    const SGD = 2;
}

class currency_string {
    public $supported_currency = array("MYR"=>"Malaysia Ringgit",
            "SGD"=>"Singapore Dollar",
            "USD"=>"US Dollar",
            "IDR"=>"Indonesian Rupiah",
            "THB"=>"Thai Baht");
}
class CurrencyFactory
{
    public $currency_string_obj = NULL;
    

    public static function CurrencyFactorySetError($error)
    {
        ob_start();
        var_dump($error);
        $output = ob_get_clean();
        $error = date("H:i:s") . " : " . $output;
        $log_location =  $log_location = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "logs".
                DIRECTORY_SEPARATOR . date("Ymd"). ".log";
        error_log($error ."\n", 3, $log_location);
    }
    public static function build($from)
    {
        $class = $from . "Manager";
        if (!class_exists($class)) {
            throw new Exception('Missing format class.');
        }
        return new $class;
    }
    public static function get_currency_type_enum($currency_type)
    {
        switch($currency_type)
        {
            case "MYR":
                return currency_type::MYR;
            case "USD":
                return currency_type::USD;
            case "SGD":
                return currency_type::SGD;
            default:
                return NULL;
        }
    }
    
    public static function get_currency_type_string($currency_type)
    {
        switch($currency_type)
        {
            case currency_type::MYR:
                return "MYR";
            case currency_type::USD:
                return "USD";
            case currency_type::SGD:
                return "SGD";
            default:
                return NULL;
        }
    }
    
    public function get_supported_currency()
    {
        return $this->currency_string_obj->supported_currency;
    }
}

class currency_convertor extends CurrencyFactory {
    function __construct()
    {
        $this->currency_string_obj = new currency_string();
    }
   
}

abstract class CurrencyManager {
    protected $CurrencyConverter_obj;
    function __construct()
    {
        $this->CurrencyConverter_obj = new CurrencyConverter();
    }
    function get_result($to, $value)
    {
        throw new Exception("get_result is not implemented");
    }
}

class MYRManager extends CurrencyManager{
    
    function get_result($to, $value)
    {
        $to_currency = "MYR";
        switch($to)
        {
           case currency_type::USD:
               $to_currency = "USD";
               break;
           case currency_type::SGD:
               $to_currency = "SGD";
               break;
           case currency_type::MYR:
               return $value;
            default:
                return NAN;
        }
        return $this->CurrencyConverter_obj->convert('MYR', $to_currency, $value, 1, 1);  
    }
}
class USDManager  extends CurrencyManager{
    
    function get_result($to, $value)
    {
        $to_currency = "USD";
        switch($to)
        {
           case currency_type::MYR:
               $to_currency = "MYR";
               break;
           case currency_type::SGD:
               $to_currency = "SGD";
               break;
           case currency_type::USD:
               return $value;
           default:
                return NAN;
        }
        return $this->CurrencyConverter_obj->convert('USD', $to_currency, $value, 1, 1);
    }
}
class SGDManager extends CurrencyManager{
    function get_result($to, $value)
    {
        $to_currency = "SGD";
        switch($to)
        {
           case currency_type::MYR:
               $to_currency = "MYR";
               break;
           case currency_type::USD:
               $to_currency = "USD";
               break;
           case currency_type::SGD:
               return $value;
            default:
                return NAN;
        }
        return $this->CurrencyConverter_obj->convert('SGD', $to_currency, $value, 1, 1);
        
    }
    
}
?>
