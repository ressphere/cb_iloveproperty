<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'properties_base.php';
require_once '_utils/GeneralFunc.php';
class properties_policy extends properties_base {
   function __construct()
   {
       //overwrite base function before construct
        parent::__construct(TRUE);        
   }
 
   public function index()
   {
       parent::index();
       
       $content = "ressphere policy";
       $title = "Ressphere Properties - Term and Conditions";
       $this->SEO_Tags($content);
       $this->set_title($title);
       
        
       $this->extemplate->add_js('js/property_main_page.js');
       
       $this->extemplate->write_view('contents', '_usercontrols/properties_policy_content','' ,TRUE);
       
       $this->extemplate->render();  
   }
}
?>
