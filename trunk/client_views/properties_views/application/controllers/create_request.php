<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base.php';
require_once '_utils/GeneralFunc.php';

class create_request extends base {
    
   function index()
   {
       $html_syntext = $_POST['html_syntext'];
       //echo $html_syntext;
       $property_info = json_decode($html_syntext, TRUE); 
       
       $position = mb_strrpos($property_info[3], "\\");
       $filename = mb_substr($property_info[3], ($position+1));
       $filelocation = base_url() .'assets/images/property_listing/'.$filename;
       
       //$this->load->model('cb_manage_property');
       $property_info['Name'] = $property_info[1];
       $property_info['Price'] = $property_info[2];
       //$property_info['Property_info_image'] = $property_info[3];
       $property_info['Property_info_image'] = $filelocation;
       
       //$this->cb_manage_property->set_property_info(json_encode($property_info));
       $gen_func = new GeneralFunc();
       $val_return = $gen_func->CB_Send_Service_Request("CB_Property:create_request",json_encode($property_info));
       
       //echo $return;
       
   }

}