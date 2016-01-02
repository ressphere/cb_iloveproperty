<?php
require_once 'unit_test_main.php';

/*
 * This is the main trigger point for all unit test
 * Please add all unit test into this file
 */
class unit_test extends unit_test_main {
    
    /*
     * Unit test list
     */
    function unit_test_list()
    {
        $unit_test_list = [
            "gateway_unit_test",
            //"model_unit_test",
            "CB_Info_unit_test",
            "CB_Payment_unit_test",
            "CB_Product_unit_test",
            "CB_Property_unit_test",
            "CB_Member_unit_test"
            
        ];
        
        return $unit_test_list;
    }
    
    /*
     * Direct start the unit test
     */
    function index()
    {
        // To address "Cannot modify header information" warning
        ob_start();
        
        $this->benchmark_dump_file("\n----------------------------------------");
        
        echo "<div><p>All Unit Test Run</p>";
        
        /*
        $exe_test = "CB_Property_unit_test";
        include_once $exe_test.'.php';
        $ddd = new $exe_test;
        if (method_exists($exe_test, '_unit_test_feature'))
        {
            $exe_test::_unit_test_feature();
        }
        */
        
        $test_list = $this->unit_test_list();
        foreach ($test_list as $exe_test)
        {
            include_once $exe_test.'.php';
            echo "<br><br><p>".$exe_test."</p>";
            
            // Invoke feature test if function exist
            /*
            if (method_exists($exe_test, '_unit_test_feature'))
            {
                $exe_test::_unit_test_feature();
            }
            */
            
            // Invoke each unit test through new object
            $test_obj = new $exe_test;
            $test_obj->test_list();
            
        }
        
        echo "</div>";
    }
    
}

?>
