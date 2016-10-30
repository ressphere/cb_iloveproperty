<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'properties_rent.php';
class properties_buy extends properties_search {
    function __construct()
   {
       // Preload necessary
        parent::__construct();
        $this->set_action("buy");
        $this->SEO_Tags("Ressphere Real Estate (Property) Home Page To Purchase");
        $this->set_title("Ressphere Properties - Buy");
   }
   
   public function index()
   {
       // Preload Header and Footer
       parent::index();
       $this->session->set_userdata("action", $this->get_action());
   }
}
?>

