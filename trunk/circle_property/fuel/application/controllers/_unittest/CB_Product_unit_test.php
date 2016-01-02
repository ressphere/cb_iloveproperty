<?php
require_once dirname(dirname(__FILE__)).'/CBWS_Service/CB_Product.php';
require_once 'unit_test_main.php';

class CB_Product_unit_test extends unit_test_main
{
    function __construct() {
        parent::__construct();
        
        $current_file_name = pathinfo(__FILE__, PATHINFO_FILENAME);
        $this->benchmark_dump_file("\n".$current_file_name);
        
    }
    
    ###########################unit test region####################################
    public function _unit_test_feature() {
        
       // Test on get_price_point
       $request_info = array(
           "product_code" => "AF-188-2",
           "handle_fix" => 2,
           "handle_percent" => 0.044,
           "handle_fee_enable" => true
       );
       
       $value = $this->direct_service_func_invoke("CB_Product","get_product_detail",$request_info);
       $val_return = json_encode($value);
       
       $golden = array(
           "status" => "Complete",
           "status_information" => "Info: Obtained product detail for CB_Product",
           "data" => array(
               "product_price" => "188",
               "point" => array(
                    "p_point" => "188",
                    "f_point" => "2"
                ),
                "desc_short" => "Basic one year agent fee",
                "desc_long" => "Basic one year agent fee with one feature point",
                "name" => "Basic Agent Fee",
                "handle_fee" => 11,
                "total_price" => 199
            )
       );

       $val_golden = json_encode($golden);
       $note = "Return value -- $val_return <br>";
       $note = $note."Golden value -- $val_golden";
       
       $this->unit->run($val_return, $val_golden, "Test CB_Product retrive point and price function", $note);
       
   }
   
   
   public function test_list()
   {
       $this->_unit_test_feature();
       //$this->_unit_test_CBWS_CB_Product();
       echo $this->unit->report();
   }

}

?>
