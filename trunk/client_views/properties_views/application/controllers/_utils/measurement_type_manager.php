<?php
class measurement_type {
    const __default = self::sqft;
    const __len = 2;
    const sqft = 0;
    const m2 = 1;
    //Disable in len
    const hectare=2;
    const acre=3;
}
class MeasurementFactory
{
    public static function build($from)
    {
        $class = $from . "Manager";
        if (!class_exists($class)) {
            throw new Exception('Missing format class.');
        }
        return new $class;
    }
    public static function get_measurement_type_enum($measurement_type)
    {
        switch($measurement_type)
        {
            case "sqft":
                return measurement_type::sqft;
            case "m2":
                return measurement_type::m2;
            case "acre":
                return measurement_type::acre;
            case "hectare":
                return measurement_type::hectare;
            default:
                return NULL;
        }
    }
    
    public static function get_measurement_type_string($measurement_enum)
    {
        switch($measurement_enum)
        {
            case measurement_type::sqft:
                return "sqft";
            case measurement_type::m2:
                return "m2";
            case measurement_type::acre:
                return "acre";
            case measurement_type::hectare:
                return "hectare";
            default:
                return NULL;
        }
    }
    
}



interface MeasurementManager {
    function get_result($to, $value);
}

class sqftManager implements MeasurementManager{
    function get_result($to, $value)
    {
        switch($to)
        {
           case measurement_type::sqft:
               return $value;
           case measurement_type::hectare:
               return $value * 0.0000092903;
           case measurement_type::m2:
               return $value * 0.092903;
           case measurement_type::acre:
               return $value * 0.000022957;
            default:
                return NAN;
        }
    }
}
class m2Manager  implements MeasurementManager{
    function get_result($to, $value)
    {
        switch($to)
        {
           case measurement_type::sqft:
               return $value * 10.7639;
           case measurement_type::hectare:
               return $value * 0.0001;
           case measurement_type::m2:
               return $value;
           case measurement_type::acre:
               return $value * 0.000247105;
            default:
                return NAN;
        }
        
    }
}
class hectareManager implements MeasurementManager{
    function get_result($to, $value)
    {
        switch($to)
        {
           case measurement_type::sqft:
               return $value * 107639;
           case measurement_type::hectare:
               return $value;
           case measurement_type::m2:
               return $value * 10000;
           case measurement_type::acre:
               return $value * 2.47105;
            default:
                return NAN;
        }
        
    }
    
}
class acreManager implements MeasurementManager {
    function get_result($to, $value)
    {
        switch($to)
        {
           case measurement_type::sqft:
               return $value * 43560;
           case measurement_type::hectare:
               return $value * 0.404686;
           case measurement_type::m2:
               return $value * 4046.86;
           case measurement_type::acre:
               return $value;
            default:
                return NAN;
        }
        
    }
}


?>
