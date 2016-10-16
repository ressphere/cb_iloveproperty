<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base.php';
require_once '_utils/GeneralFunc.php';
class policy extends base {
   function __construct()
   {
       //overwrite base function before construct
        parent::__construct(TRUE);
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        
   }
 
   public function index()
   {
       parent::index();
       
       $content = "ressphere policy";
       $title = "Resspshere - Term and Conditions";
       $this->SEO_Tags($content);
       $this->set_title($title);
       
        
       $this->extemplate->add_js('js/cb_home.js');
      
       $this->extemplate->add_css('css/home.css');
       
       $this->extemplate->write_view('contents', '_usercontrols/policy_content','' ,TRUE);
       
       $this->extemplate->render();  
   }
}
?>
