<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'CB_Payment_base.php';

/*
 * @Todo - there is some improvement for the CBWS_Servic Base
 *         All implementation should be revisit
 */

/**
 * Paypal Payment main object
 * 
 */
class CB_Payment_Paypal extends CB_Payment_base{
    
    // To Determine is currently using sandbox testing
    private $is_sandbox = True;
    private $is_make_payment = False;
    
    // Paypal related settings
    public $config; // Paypal invoke and calling configuration
    public $exp_payment_set; // Express checkout payment settings
    
    /**
     * Build necessary settings
     */
    public function __construct()
    {
        // Invoke costructor for CB_Payment_base
        parent::__construct();
        
        // Invoke necessary setup for paypal
        $this->paypal_config_setup();
	$this->payment_init_setup();
    }
    
    /*
     * Specified AUTH support service
     * 
     * @Return Array list of auth servie
     */
    private function auth_service_list()
    {
        $auth_service = [
            'start_payment' => TRUE,
            'complete_payment' => TRUE
        ];
        return $auth_service;
    }
    
    
    /*
     * API to setup all payapl require settings
     * Use in 
     *      1. hash_call API for paypal configuration
     *      2. SetExpressCheckout API to provide paypal url
     *      3. get_product_detail for Handling fee settings
     * 
     */
    private function paypal_config_setup()
    {
        // Paypal NVP version
	$this->config['version'] = "112";
		
        // Setting for the paypal
        if($this->is_sandbox === True)
        {
            // Paypal Sandbox API, signature, password and URL
            $this->config['api_username'] = "ressphere-facilitator_api1.gmail.com";
            $this->config['api_password'] = "1395561710";
            $this->config['api_signature'] = "AopyXf.WtQk7Bzcf8JjRF4pF5MLtABT7mIJim1Pf.HafdmnM4EOQxOdi";
            $this->config['API_ENDPOINT'] = 'https://api-3t.sandbox.paypal.com/nvp';
            $this->config['PAYPAL_URL'] = 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';
            
            // Paypal sandbox doesn't support MYR
            $this->exp_payment_set["PAYMENTREQUEST_0_CURRENCYCODE"] = 'USD';
            
            // Handling fee calculation for US
            $this->config['handle_fee_enable'] = TRUE;
            $this->config['handle_fix'] = 0.3;
            $this->config['handle_percent'] = 2.9;
        }
        else
        {
            // Paypal API, signature, password and URL (if lost please refer to paypal account)
            $this->config['api_username'] = "ressphere_api1.gmail.com";
            $this->config['api_password'] = "Z8WR8VY7247FK864";
            $this->config['api_signature'] = "AExqMtM.Qc1xCr8ZPimAUbr-xhNeAo5X3vb7xdVHx.mLYSABFTzPc.j8";
            $this->config['API_ENDPOINT'] = 'https://api-3t.paypal.com/nvp';
            $this->config['PAYPAL_URL'] = 'https://www.paypal.com/webscr&cmd=_express-checkout&token=';
            
            // Specified currency
            $this->exp_payment_set["PAYMENTREQUEST_0_CURRENCYCODE"] = 'MYR';
            
            // Handling fee calculation for Malaysia
            $this->config['handle_fee_enable'] = TRUE;
            $this->config['handle_fix'] = 2;
            $this->config['handle_percent'] = 4.4;
        }
        
        // Not using proxy host
	$this->config['use_proxy'] = FALSE;
	$this->config['proxy_host'] = "http://www.ressphere.com";
	$this->config['proxy_port'] = "0";
    }
    
    
    /*
     * Paypal payment interface and initial settings
     */
    private function payment_init_setup()
    {	
        // Specified calling and cancel URL
	$this->exp_payment_set['RETURNURL'] = "http://www.ressphere.com/cb_sandbox/sandbox/index.php/payment_tester/detail_checkout";
	$this->exp_payment_set['CANCELURL'] = "http://www.ressphere.com/cb_sandbox/sandbox/index.php/payment_tester/cancle_page";
        
        // Specified payment type
	$this->exp_payment_set["PAYMENTREQUEST_0_PAYMENTACTION"] = 'Sale';
		
	// Mark all produc as digital until there is shippment invlove, thus disable shipping address and confirmation
	$this->exp_payment_set["L_PAYMENTREQUEST_0_ITEMCATEGORY0"] = 'Digital';
	$this->exp_payment_set["NOSHIPPING"] = "1";
	$this->exp_payment_set["REQCONFIRMSHIPPING"] = "0";
	
        // Paypal page customize
	//$payment_settings["HDRIMG"] = ""; //URL for the image you want to appear at the top left of the payment page. The image has a maximum size of 750 pixels wide by 90 pixels high. 
	//$payment_settings["PAYFLOWCOLOR"] = ""; //Sets the background color for the payment page. By default, the color is white.
	//$payment_settings["PAYFLOWCOLOR"] = ""; //A URL to your logo image. Use a valid graphics format, such as .gif, .jpg, or .png. Limit the image to 190 pixels wide by 60 pixels high. PayPal crops images that are larger. PayPal places your logo image at the top of the cart review area.
	//$payment_settings["BRANDNAME"] = ""; //A label that overrides the business name in the PayPal account on the PayPal hosted checkout pages.
		
	// Display Credit card payment by default
	$payment_settings["LANDINGPAGE"] = "Billing";
	$payment_settings["USERSELECTEDFUNDINGSOURCE"] = "CreditCard";
        
        // @Todo - To see any billing agreement necesary or can include 
        //$payment_settings["L_BILLINGTYPE0"] = "MerchantInitiatedBillingSingleAgreement";
	//$payment_settings["L_BILLINGAGREEMENTDESCRIPTION0"] = "something to be included";
    }
    
    /*
     * To build the array for product call
     * 
     * @Param String product code
     * @Return Array Contain all information to retrieve product 
     */
    private function build_product_request_info($product_code)
    {
        // Prepare setting to retrieve information
        $request_info = array(
           "product_code" => $product_code,
           "handle_fix" => 2,
           "handle_percent" => 0.044,
           "handle_fee_enable" => false
        );
        
        return $request_info;
    }
    
    
    /*
     * API to obtain product information, which include price, name and description
     *  thus perfrom mapping to Paypal related array name
     * Use for SetExpressCheckout at start_payment API
     * 
     * @Param string product code
     * @Return hash product detail (total_price, handle_fee, product_price, point[<type>]=value, )
     */
    public function get_product_info($product_code)
    {
        $return_hash = array();
        
        // Check the existance of product_code
        if($product_code === NULL)
        {
            $this->set_error("PM-PC-1", "Please contact admin for further information", "Missing product code value at payment");
        }
        else
        {
            // Retrieve product detail information
            $request_info = $this->build_product_request_info($product_code);
            $product_detail_package = $this->get_product_detail($request_info);
        
            if($this->check_array_value($product_detail_package,"status") === "Complete")
            {
                $product_detail = $product_detail_package['data'];
                // @ToDo temporary hardcode, need to consolidate at CB_Payment_setting
                $return_hash["PAYMENTREQUEST_0_AMT"] = $this->check_array_value($product_detail,"total_price");
                $return_hash["PAYMENTREQUEST_0_ITEMAMT"] = $this->check_array_value($product_detail,"product_price");
                //$return_hash["PAYMENTREQUEST_0_SHIPPINGAMT"] = '188'; /// Not reuqired cause is for cart amount
                $return_hash["PAYMENTREQUEST_0_HANDLINGAMT"] = $this->check_array_value($product_detail,"handle_fee"); // Paypal transaction require fee C = (B+2)/0.956
                //$return_hash["PAYMENTREQUEST_0_TAXAMT"] = '0';  // Currently exclude tax first
                $return_hash["PAYMENTREQUEST_n_DESC"] = $this->check_array_value($product_detail,"desc_short"); 

                $return_hash["L_PAYMENTREQUEST_0_NAME0"] = $this->check_array_value($product_detail,"name");
                $return_hash["L_PAYMENTREQUEST_0_DESC0"] = $this->check_array_value($product_detail,"desc_long");
                $return_hash["L_PAYMENTREQUEST_0_AMT0"] = $this->check_array_value($product_detail,"product_price");
                $return_hash["L_PAYMENTREQUEST_0_QTY0"] = '1';
                //$return_hash["L_PAYMENTREQUEST_0_TAXAMT0"] = ''; // Currently exclude tax first

                // @ToDo - generate out tag with user id and product code
                $id_tag_product = "ID_" . "01234" . "_TAG_" . $product_code;

                $return_hash["PAYMENTREQUEST_0_CUSTOM"] = $id_tag_product;
                //$return_hash["PAYMENTREQUEST_n_INVNUM"] = "";  // If custom can't use then need to have utilize invoice id d
            }
            else
            {
                $this->set_error("PM-PC-2", "Please contact admin for further information", "Fail to retrieve product info at payment");
            }
        }
        
        return $return_hash;
    }
    
    /*
     * API to start payment flow
     *  - Perform SetExpressCheckout to obtain paypal token
     *  - Thus invoke express checkout flow to divert customer to paypal page
     * 
     * @Param String product code
     */
    public function start_payment($product_code)
    {
    	// Build express checkout settings
	$payment_settings = array_merge($this->exp_payment_set, $this->get_product_info($product_code));
	
        // First checking for the data retrieve from database
        if($this->is_error === false)
        {
            // Convert array to urlencoded NVP string
            $nvpStr = $this->generateNVPString($payment_settings);
            // Peform hash call to return status and token if success
            $return_val = $this->hash_call("SetExpressCheckout", $nvpStr);
        
            // Second check for data retrieve from paypal call
            if($this->is_error === false)
            {
                // Store return token
                $token = urlencode($return_val['TOKEN']);

                // Redirect to paypal.com here
                $paypal_url = $this->config['PAYPAL_URL'].$token;
                header("Location: ".$paypal_url);
            }
            else
            {
                // @ToDo divert to error page or sorry page
                echo json_encode($return_val);
            }
        }
    }
    
    /*
     * API that use for callback inorder to complete the Express checkout flow
     *  Pre-requirement: invoke start_payment and obtain PayerID thus agree to pay
     * 
     */
    public function complete_payment()
    {
        // Obtain necessary info from url callback (a.k.a _GET)
        $token = $this->check_array_value($_GET,"token");
        $PayerID = $this->check_array_value($_GET,"PayerID");

        // Prepare data retrive
        $payment_settings["token"] = $token;
        $nvpStr = $this->generateNVPString($payment_settings);
        
        // Obtain customer detail through GetExpressCheckoutDetails
        // @Todo - retrieve product_code and user_id
        $return_val = $this->hash_call("GetExpressCheckoutDetails", $nvpStr);
        
        if(! $this->is_make_payment)
        {
            echo "--- This is get express checkout detail return --";
            echo json_encode($return_val);
        }

        // Perform DoExpressCheckoutPayment to complete the flow
        if($this->is_error === false)
        {
            // @Todo - retrieve product code from the return URL
            $product_code = "dummy";
            $product_info_array = $this->get_product_info($product_code);

            // @Todo - Direct manipulate product detail instate of call get_product_info
            // Retrieve product detail information
            //$request_info = $this->build_product_request_info($product_code);
            //$product_detail = $this->get_product_detail($request_info);


            // Build express checkout settings
            $payment_settings["PAYMENTREQUEST_0_PAYMENTACTION"] = $product_info_array["PAYMENTREQUEST_0_PAYMENTACTION"];
            $payment_settings["PAYMENTREQUEST_0_CURRENCYCODE"] = $product_info_array["PAYMENTREQUEST_0_CURRENCYCODE"];
            $payment_settings["PAYMENTREQUEST_0_AMT"] = $product_info_array["PAYMENTREQUEST_0_AMT"];
            $payment_settings["PayerID"] = $PayerID;
            $payment_settings["token"] = $token;

            $nvpStr = $this->generateNVPString($payment_settings);

            if($this->is_make_payment)
            {
                $return_val = $this->hash_call("DoExpressCheckoutPayment", $nvpStr);
                
                if($this->is_error === false)
                {
                    // @Todo - perform point update, thus divert to sucess page 
                    echo json_encode($return_val);
                }
            }
            else
            {
                echo "--- This is DoExpressCheckoutPayment value prepare --";
                echo jason_encode($payment_settings); 
            }
        }
        
        if($this->is_error === True)
        {
            // @Todo - divert to fail and sorry page
            echo json_encode($return_val);
        }
    }
    
    /*
     * hash_call: Function to perform the API call to PayPal using API signature
     * 
     * @Param String name of API method.
     * @Param String nvp string.
     * 
     * @Return Array An associtive array containing the response from the server.
    */
    private function hash_call($methodName, $nvpStr)
    {
        // TODO: Add error handling for the hash_call

        //setting the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->config['API_ENDPOINT']);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        //turning off the server and peer verification(TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        
        //if USE_PROXY constant set to true in Constants.php, then only proxy will be enabled.
        //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
        if($this->config['use_proxy'])
                curl_setopt ($ch, CURLOPT_PROXY, $this->config['proxy_host'].":".$this->config['proxy_port']); 

        //NVPRequest for submitting to server
        $nvpreq = "METHOD=".urlencode($methodName)."&VERSION=".urlencode($this->config['version'])."&PWD=".urlencode($this->config['api_password']).
                        "&USER=".urlencode($this->config['api_username'])."&SIGNATURE=".urlencode($this->config['api_signature']).$nvpStr;

        //setting the nvpreq as POST FIELD to curl
        curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);

        //getting response from server
        $response = curl_exec($ch);

        //convrting NVPResponse to an Associative Array
        $nvpResArray = $this->deformatNVP($response);
        $nvpReqArray = $this->deformatNVP($nvpreq);
        $_SESSION['nvpReqArray'] = $nvpReqArray;

        /*
        *************
        if NO SUCCESS
        *************
        */
        if (curl_errno($ch)) 
        {
            $this->set_error("PM-HC-1", "There was an error trying to contact the PayPal servers", "Error code: ".curl_errno($ch). ",  Error message: ".curl_error($ch));
            
            return false;
        } 
        /*
        *************
        if SUCCESS
        *************
        */
        else 
        {
            //closing the curl
            curl_close($ch);
        }

        return $nvpResArray;
    }

}

?>
