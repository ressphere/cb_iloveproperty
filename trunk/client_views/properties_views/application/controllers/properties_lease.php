<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'properties_sell.php';
class properties_lease extends properties_sell {
    function __construct()
   {
       // Preload necessary
        parent::__construct();
        $this->set_action("rent");
        // Set web related info fro Search Engine
        $this->SEO_Tags("Ressphere Real Estate (Property) Home Page To Let");
        $this->set_title("Ressphere Properties - Lease");
        
   }
   
   public function index()
   {
       // Preload Header and Footer
       parent::index();$this->session->set_userdata('secure','1');
   }
}
?>
