<?php
require_once 'AuthHeader.php';

class GeneralFunc
{
    public static function filterSoapMessage($data)
    {
        $return_pos = strpos($data, '<return');
         $start_pos = strpos($data, '>', $return_pos);
         if($start_pos != FALSE)
         {
             $end_pos = strpos($data, '</return>');
             $data = substr($data, $start_pos + 1, $end_pos - $start_pos);
             $data = str_replace('\\', '', $data);
             $data = trim($data, '<');
             $data = trim($data, '"');
         }
         return $data;
    }
    
    public static function CB_Send_Service_Request($service, $send_data)
    {
        //$service_obj = new ServiceRequest;
        $service_obj = new REST_ServiceRequest;
        $return_data = $service_obj->service_request($service,$send_data,"send");
        return $return_data;
    }
    public static function CB_Receive_Service_Request($service)
    {
        //$service_obj = new ServiceRequest;
        $service_obj = new REST_ServiceRequest;
        $return_data = $service_obj->service_request($service, null,"receive");
        return $return_data;
    }
    public static function CB_SendReceive_Service_Request($service, $send_data)
    {
        //$service_obj = new ServiceRequest;
        $service_obj = new REST_ServiceRequest;
        $return_data = $service_obj->service_request($service,$send_data,"sendreceive");
        return $return_data;
    }
    public static function CB_Test_Gateway()
    {
        //$service_obj = new ServiceRequest;
        //$return_data = $service_obj->test_gateway();
        
        $service_obj = new REST_ServiceRequest;
        $return_data = $service_obj->service_request(null,"ss&bb","test");
        
        return $return_data;

    }
}

/*
 * REST Gateway
 */
class REST_ServiceRequest extends CI_Controller
{  
    // REST API End point
    private $api_url = "http://localhost/cb_iloveproperty/trunk/circle_property/RestAPI/";
    
    // Auth purpose
    private $user = "root";
    private $password = "1234abcd*";
    
    public function __construct()
    {
        parent::__construct();
        
        // Encryption for AUTH purpose
        $this->load->library('encrypt');
    }
    
    public function service_request($service,$send_data,$type_request)
    {
        $command_array["service"] = $service;
        $command_array["send_data"] = $send_data;
        $command_array["user"] = $this->user;
        $command_array["password"] = $this->password;
        
                
        // file dump -- for testing purpose -- Start --
        /*
        $file = 'D:/resphere_test_dump.txt';
        $current = file_get_contents($file);
        $current .= "\n------------------------------\n";
        $current .= "GeneralFunc  -- service_request";
        $current .= json_encode($command_array);
        file_put_contents($file, $current);
        */
        // file dump -- for testing purpose -- End --
        
        $api_function = "NULL";
        
        switch ($type_request)
        {
            case "send":
                $api_function = "Service_Send";
                break;
            case "receive":
                $api_function = "Service_Receive";
                break;
            case "sendreceive":
                $api_function = "Service_SendReceive";
                break;
            case "test":
                $api_function = "CB_Test_Gateway";
                break;
            default:
                break;
        }
        
        $api_endpoint = $this->api_url.$api_function;
        
        return $this->_hash_call($api_endpoint, $command_array);
    }
    
    /*
     * Encrypt the givent string
     */
    private function _encrypt_string($clear_string)
    {
        $encrypted_string = $this->encrypt->encode($clear_string);
        return $encrypted_string;
    }
    
    /*
     * Perform curl call and retrieve data
     */
    private function _hash_call($api_endpoint, $command_array)
    {
        // Build url string
        $url = $api_endpoint."?"."AUTH=true&data=";
        $url = $url . urlencode($this->_encrypt_string(json_encode($command_array)));
       
        //setting the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        //curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));

        //turning off the server and peer verification(TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 0);
        
        //getting response from server
        return curl_exec($ch);
    }
}

/*
 * SOAP Gateway 
 */
class ServiceRequest extends CI_Controller 
{
    private $client;
       
        public function __construct()
        {
            //$this->load->helper("url");
            //$data_layer = new data_layer();
             parent::__construct();
             ini_set('soap.wsdl_cache_enabled', '0');
             $this->client = new SoapClient("http://localhost/cb_iloveproperty/trunk/circle_property/index.php/main?wsdl",
                     array('trace'=>1,'exceptions'=> 0, 'style'=> SOAP_DOCUMENT, 'use' => SOAP_LITERAL,
                         'soap_version'=> SOAP_1_2,
                         'encoding'=> 'UTF-8'
                     ));
             $AuthHeader = new AuthHeader();
             $AuthHeader->username = 'root';
           
             $AuthHeader->password = hash('md5','1234abcd*');
             $Headers[] = new SoapHeader('http://localhost/cb_iloveproperty/trunk/circle_property/index.php/main?wsdl', 'AuthHeader', $AuthHeader);
             $this->client->__setSoapHeaders($Headers);
                
        }
        
        public function service_request($service,$send_data,$type_request)
	{
            
           $command_array["service"] = $service;
           $command_array["send_data"] = $send_data;
           
           switch ($type_request)
           {
               case "send":
                   $this->client->__soapCall("_CB_Service_Send", array($command_array));
                   break;
               case "receive":
                   $this->client->__soapCall("_CB_Service_Receive", array($command_array));
                   break;
               case "sendreceive":
                   $this->client->__soapCall("_CB_Service_SendReceive", array($command_array));
                   break;
               case "test":
                   $this->client->__soapCall("_CB_Test_Gateway", array($command_array));
                   break;
               default:
                   break;
           }
           
           $basic_component_set = GeneralFunc::filterSoapMessage($this->client->__getLastResponse());
           
           return $basic_component_set;
           
	}
        
        public function test_gateway()
        {
            $command_array = array();
            $this->client->__soapCall("_CB_Test_Gateway", array($command_array));
            $basic_component_set = GeneralFunc::filterSoapMessage($this->client->__getLastResponse());
            
            return json_encode($basic_component_set);
        }
}

?>