<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base.php';
require_once '_utils/GeneralFunc.php';
class cb_home extends base {
   function __construct()
   {
       //overwrite base function before construct
        parent::__construct(TRUE);
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        
   }
   private function _get_news()
   {
       $news = array();
       
       $val_return = GeneralFunc::CB_Receive_Service_Request("CB_Ressphere_Home:get_home_video");
       $news_list = json_decode($val_return, TRUE);
       foreach ($news_list['data']['result'] as $value) {
            array_push($news, array($value['type'], $value['content_display_path'], $value['content_path']));
       }
       return $news;
   }

    private function _get_about_us()
   {     
       $val_return = GeneralFunc::CB_Receive_Service_Request("CB_Ressphere_Home:get_about_us");
       $about_us = json_decode($val_return, TRUE);
       
        $text = "<strong>Ressphere</strong> is founded on 17th of March, 2014.<BR> 
           Ressphere's vision is to create a platform that joins people from different background, different location, having different interest, mastering different expertise together to communicate and collaborate. 
           <br> 
           Its name is derived from “Resonance/Resolution” and “Sphere” which symbolizes a society that contains people from all around the world where they can work together to achieve consensus that bring the best solution to each other.
           <br><br> 
           <B>We strike to achieve 4 missions that is aligned with our vision</B><br>
           <ol><li>Affiliate join forces by creating a boundaryless environment</li>
               <li>Communicate - prepare an effective and efficient communication channel via internet</li>
               <li>Enhance - build an online society that complement daily life</li>
               <li>Secure - create a safe and trustworthy virtual online platform</li>
            </ol><br>
            <B>We aim to complete our A.C.E.S missions with </B><br>
            <ul>
            <li>Superior competency</li>
            <li>Passionate attitude</li>
            <li>Intelligent solution</li>
            <li>Contemporary style</li>
            <li>Endless creativity</li>
            </ul><br>
            The company now offers a circle binding platform, property circle and service circle. <br>
            In the future, where there will be more circles that touch on different parts of our life to be launched.";
       if(count($about_us["data"]["result"]) > 0)
       {
           $text = html_entity_decode($about_us["data"]["result"][0]['content']);
           $text = html_entity_decode($text);
           
       }
       $news = array();
       array_push($news, array('text', $text));
       return $news;
   }
   
   public function send_contact_msg()
   {
        
        $msg = "Internal Error";
        $name = $this->_get_posted_value('contact_user_info_0');
        $email = $this->_get_posted_value('contact_user_info_1');
        $comment = $this->_get_posted_value('contact_us_msg');
        $contact_number = $this->_get_posted_value('contact_number');
        
        if ( is_null($name) || $name == "")
        {
            $msg = "<span class='error'>Please provide us your name.</span>";
        }
        elseif (is_null($email) || $email == "" || !$this->_validate_email($email)) 
        {
            $msg = "<span class='error'>Please provide us your email.</span>";
        }
        elseif(is_null($comment) || $comment == "")
        {
            $msg = "<span class='error'>Message cannot be empty.</span>";
        }
        elseif(is_null($contact_number) || $contact_number == "")
        {
            $msg = "<span class='error'>Phone number cannot be empty.</span>";
        }
        else
        {
            //Send mail here
            $data['name'] = $name . " (".$contact_number.")";
            $data['serial'] = uniqid('CASE_');
            $data['email'] = $email;
            $data['content'] = $comment;

            $this->_send_email('request', $this->config->item('enquire_email', 'tank_auth'), $data);
            $msg = "Thank you for contacting us, we will reply you soon";
        }
        $this->_print($msg);
   }
   
   private function set_contact_us_html_ui($contact_list, $msg = '')
   {
       $this->extemplate->write_view('contact_us', '_usercontrols/cb_contact_us',
                    array('title'=> base_url() . 'images/contact.png',
                        'title_bar_bg' => base_url() . 'images/contact_us_title.png',
                        'title_description'=> 'contact ressphere now',
                        'contact_list' => $contact_list,
                        'message' => $msg,
                        'post_link' => base_url()),
                        TRUE);
       //$this->extemplate->write('contents', 'contact us');
       //$this->extemplate->render();
   }
   public function is_page_secure()
   {
       if($this->_is_secure_page())
       {
           $this->_print("1");
       }
       else
       {
           $this->_print("0");
       }
   }
   public function check_login_status()
   {
        if($this->_get_user_id() === FALSE)
        {
            $this->_print("0");
        }
        else
        {
            if($this->is_user_banned())
            {
                $this->_begin_logout();
                 $this->_print("0");
            }
            else
            {
                $this->_print("1"); 
            }
        }
        
   }
   public function index()
   {
       parent::index();
       $contact_list = array(
           array(
               'Name',
               'Your name',
               'text'
           ),
            array(
               'Email',
               'Your email',
               'email'
           ),
           array(
               'Phone',
               'Your phone number',
               'phone'
           ),
            array(
               'Message',
               'We always listen to you',
               'textarea'
           )
        );
       
       $content = "ressphere home search";
       $title = "Welcome to ressphere";
       $this->SEO_Tags($content);
       $this->set_title($title);
       
       
       $this->extemplate->add_js('js/jquery.easing.min.js');
       $this->extemplate->add_js('js/_exscrolling_nav/classie.js');
       $this->extemplate->add_js('js/_exscrolling_nav/cbpAnimatedHeader.min.js');
       $this->extemplate->add_js('js/_exscrolling_nav/jqBootstrapValidation.js');
        
       $this->extemplate->add_js('js/cb_home.js');
      
       $this->extemplate->add_css('css/home.css');
       $this->extemplate->add_css('css/about_us.css');
       $this->extemplate->add_css('css/contact_us.css');
       //$this->extemplate->add_css('css/demo.css');
       //$this->extemplate->add_css('css/flexslider.css');
       
       $this->extemplate->write_view('contents', '_usercontrols/cb_services',array('feature_list'=>$this->_get_features()) ,TRUE);
       
       $this->extemplate->write_view('about_us', '_usercontrols/cb_about_us_content',
               array('news'=>$this->_get_about_us()) ,TRUE);
       $this->set_contact_us_html_ui($contact_list);

       
       $this->extemplate->render();
      
   }
   
  
}
?>
