<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'properties_base.php';
class properties_page404 extends properties_base {
   function __construct()
   {
       // Preload necessary
        parent::__construct();
   }
   
   public function index()
   {
       // Preload Header and Footer
       parent::index();
       $content = "404 Page Not Found";
       $title = "404 Ressphere Page Not Found";
       $this->SEO_Tags($content);
       $this->set_title($title);
       $wsdl = $this->_get_wsdl_base_url();
       $this->extemplate->set_extemplate('page404_home');
       $this->extemplate->add_js($wsdl . 'js/jquery.easing.min.js', 'import', FALSE, FALSE);
       $this->extemplate->add_css($wsdl . 'css/404.css', 'link', FALSE, FALSE);
         //cb_change_profile
       $this->extemplate->write_view('content', '_usercontrols/cb_404_page',array(
           'reason'=>"Look like something wrong! The page you were looking for is not here",
           'img404'=>$wsdl.'images/404img.svg',
           'homepage'=>base_url(),
           'contactus'=>$wsdl.'#contact_us'
       ) ,TRUE);
       
       $this->extemplate->render();
   }
  
}
?>

