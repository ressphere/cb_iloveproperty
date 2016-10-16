<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'properties_search.php';
class properties_rent extends properties_search {
   function __construct()
   {
       // Preload necessary
        parent::__construct();
        $this->content = "Ressphere Properties Home Page";
        $this->title = "Ressphere Properties";
        $this->set_action("rent");
        // Set web related info fro Search Engine
        $this->SEO_Tags("Ressphere Real Estate (Property) Home Page For Rent");
        $this->set_title("Ressphere Properties - Rent");
   }
   
   public function index()
   {
       // Preload Header and Footer
       parent::index();
       $this->session->set_userdata("action", $this->get_action());
   }
   
}
?>
