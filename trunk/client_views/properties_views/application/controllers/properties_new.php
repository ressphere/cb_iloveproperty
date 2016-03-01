<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'properties_buy.php';
class properties_new extends properties_base {
    
    function __construct()
   {
       // Preload necessary
        parent::__construct();
        $this->set_action("new");
        
        
   }
   
   public function index()
   {
       // Preload Header and Footer
       parent::index();$this->session->set_userdata('secure','1');
       $this->session->set_userdata("action", $this->get_action());
       $this->extemplate->render();
   }
}
?>
