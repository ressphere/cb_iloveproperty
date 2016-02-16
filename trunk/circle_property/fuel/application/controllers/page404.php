<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base.php';
require_once '_utils/GeneralFunc.php';
class page404 extends base {
    function __construct() {
       parent::__construct();
       $this->load->helper("url"); 
       $this->load->library("extemplate");
       $this->load->library("session");
       $this->load->library("email");
       $this->load->config('tank_auth', TRUE);
       
    }
    function index()
    {
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
           'homepage'=>$wsdl,
           'contactus'=>$wsdl.'#contact'
       ) ,TRUE);
       
       $this->extemplate->render();
    }
}
?>
