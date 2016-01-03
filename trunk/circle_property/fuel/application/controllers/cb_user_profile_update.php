<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base.php';
require_once '_utils/GeneralFunc.php';
class cb_user_profile_update extends base {
   function __construct()
   {
       //overwrite base function before construct
        parent::__construct();
         $this->load->helper("url"); 
        $this->load->library("extemplate");
        $this->load->library("session");
	$this->load->library("email");
	$this->load->config('tank_auth', TRUE);
   }
   private function get_specific_data()
   {
       $profile_list = array(
           array(
               'name'=>'Property Profile',
               'id'=>'Property_Profile',
               'active'=>'listing',
               'information'=>array(
                   array(
                    'name'=>'home',
                    'url'=>'_usercontrols/cb_user_profile_home',
                    'agent_name'=>'Katy Tang',
                    'agent_photo'=>'../../images/profile-agent-pic.png',
                     'company_name' =>'Sim Housing Sdn. Bhd.',
                     'company_logo'=>'', 
                     'description'=>"Hi, I am Katy Tang, I specialize in Malaysian properties.<br>
If you’re looking to buy, sell or rent properties in this area or are looking for a responsive and responsible real estate negotiator to help you,<br>
 you've come to the right place as I am the person you are looking for.<br>
Please browse my website for more of my listings.<br>This user-friendly website has been specially designed to help you property hunt."
                  ),
                  array(
                    'name'=>'inbox',
                    'url'=>''
                  ),
                 array(
                    'name'=>'buy_credit',
                    'url'=>''
                  ),
                   array(
                    'name'=>'history',
                    'url'=>''
                  ),
                   array(
                    'name'=>'request',
                    'url'=>''
                  ),
                  array(
                    'name'=>'listing',
                    'url'=>''
                  ),
                   
               )
           )
       );
       return $profile_list;
   }
   private function get_user_profile_tabs()
   {
       //This will construct the get specific data to tab
       $profile_list = array();
       $each_profile_type = $this->get_specific_data();
       foreach($each_profile_type as $each_profile)
       {
           $data = array();
           foreach($each_profile as $key=>$value)
           {
               if ($key != 'information')
               {
                    $data[$key] = $value;
               }
               else 
               {
                    $tab_contents = array();
                    $this->extemplate->set_extemplate('profile');
                    foreach($value as $tab)
                    {
                        $tab_info = '';
                        if($tab['url'] !== '')
                        {
                            $this->extemplate->write_view('content', 
                             $tab['url'],
                             array('information'=>$tab),
                             TRUE);
                            $tab_info = $this->extemplate->render('',TRUE);
                        }
                      
                        $my_data = array(
                            'tab_name'=>$tab['name'],
                            'content'=>$tab_info
                        );
                        array_push($tab_contents, $my_data);
                    }
                    $data['information'] = $tab_contents;
                    //content
               }
           }
           array_push($profile_list, $data);
           
       }
       return $profile_list; 
   }
   private function get_generic_data()
   {
       $generic_data = array(
            'email' => 'chunmuntan@yahoo.com',
            'country' => 'Malaysia',
            'phone' => '012-2825725'
       );
       return $generic_data;
   }
   public function my_profile()
   {
       $user_id =  $this->session->userdata('user_id');
       if ($user_id !== FALSE)
       {
           $tab_content_list = $this->get_user_profile_tabs();
           parent::index();
           $content = "ressphere home search";
           $title = "Welcome to ressphere";
           $this->SEO_Tags($content);
           $this->set_title($title);
           //$this->load->module_model('home_category_model');
           $this->extemplate->add_js('js/jquery.bxslider.min.js');
           $this->extemplate->add_js('js/_usercontrols/change_password.js');
           $this->extemplate->add_js('js/jquery.fitvids.min.js');
           $this->extemplate->add_js('js/_scrolling_nav/scrolling-nav.js');
           $this->extemplate->add_js('js/cb_home.js');
           $this->extemplate->add_js('js/jquery.easing.min.js');
           $this->extemplate->add_js('js/cb_update_profile.js');
           $this->extemplate->add_css('css/jquery.bxslider.css');
           $this->extemplate->add_css('css/home.css');
           $this->extemplate->add_css('css/user_profile.css');
           $this->extemplate->add_css('css/_sidebar/simple-sidebar.css');
           $this->extemplate->add_css('css/cb_user_profile_update.css');
           $this->extemplate->add_css('css/_scrolling_nav/scrolling-nav.css');

           //cb_change_profile
           $this->extemplate->write_view('contents', '_usercontrols/cb_my_profile',array(
               'general'=>$this->get_generic_data(),
               'tab_content_list'=> $tab_content_list
           ) ,TRUE);

           $this->extemplate->render();
          
           
       }
       else
       {
            //TODO: Temporary use 404 with 403
           show_error($this->get_page403("This page is for registered member",  $this->session->userdata('client_base_url')),403, "");
       }
       
   }
}
?>