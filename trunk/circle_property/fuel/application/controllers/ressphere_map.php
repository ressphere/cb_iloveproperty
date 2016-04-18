<?php
/**
 * This class will accept latitude and longitude and display the map with ponter
 *
 * @author Tan Chun Mun
 */
require_once 'base.php';
require_once '_utils/GeneralFunc.php';
class ressphere_map extends base {
    function __construct()
    {
        parent::__construct();
        $this->load->library("extemplate");
        $this->load->library("session");
	
	
    }
    private function load_css()
    {
        $this->extemplate->add_css('css/ressphereMap.css');
    }
    private function load_js()
    {
        $this->wsdl = $this->_get_wsdl_base_url();
        $this->session->set_userdata('wsdl_base_url', $this->wsdl);
        $this->extemplate->add_js('js/jquery.min.js');
        $this->extemplate->add_js('js/bootstrap-mit.min.js');
        $this->extemplate->add_js('js/typeahead.min.js');
        $this->extemplate->add_js('js/angular.min.js');
        $this->extemplate->add_js($this->wsdl . 'js/lodash.compat.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/bluebird.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js('https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/angular-google-maps.min.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js($this->wsdl . 'js/angularjs-google-places.js', 'import', FALSE, FALSE);
        
        $this->extemplate->add_js( $this->wsdl . 'js/ngAutocomplete.js', 'import', FALSE, FALSE);
        $this->extemplate->add_js( $this->wsdl . 'js/google_map.js', 'import', FALSE, FALSE);
        
        
        $this->extemplate->add_js( $this->wsdl . 'js/ressphere_map.js', 'import', FALSE, FALSE);
    }
    public function index()
    {
        
    }
    public function map()
    {
        $this->extemplate->set_extemplate('ressphere_map');
        $this->load_js();
        $this->load_css();
        $content = "ressphere map search";
        $title = "Welcome to ressphere";
        $this->SEO_Tags($content);
        $this->set_title($title);
        
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if(array_key_exists("lgt", $_GET) && array_key_exists("lat", $_GET))
        {
            $this->extemplate->write_view('content', '_usercontrols/ressphere_map',
                    array(
                            'lat'=>$_GET["lat"],
                            'lgt'=>$_GET["lgt"]
                        ) ,TRUE);
            
            $this->extemplate->render();
        }
        else
        {
            show_404();
        }
    }
}

?>
