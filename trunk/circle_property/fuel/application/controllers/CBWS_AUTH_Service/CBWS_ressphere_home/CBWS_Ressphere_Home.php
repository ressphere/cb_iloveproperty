<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CBWS_Ressphere_Home {
    private $CI = NULL;
    function __construct() {
        
        $this->CI =& get_instance();
    }
    
    public function get_features()
    {
       $this->CI->load->model('cb_manage_home_category');
       $where['select'] = 'category, category_path, category_icon, category_mo_icon';
       return $this->CI->cb_manage_home_category->get_home_category($where);
    }
    
    public function get_content()
    {
       $this->CI->load->model('cb_manage_about_us');
       $where['select'] = 'content';
       $data = $this->CI->cb_manage_about_us->get_home_about_us($where);
       for ($i = 0; $i< count($data); $i++) {
           if(array_key_exists('content', $data[$i]))
           {
               $data[$i]['content'] = str_replace(PHP_EOL, '', $data[$i]['content']);
               $data[$i]['content'] = str_replace("\r", '', $data[$i]['content']);
               $data[$i]['content'] = str_replace("\r\n", '', $data[$i]['content']);
               $data[$i]['content'] = htmlentities($data[$i]['content']);
           }        
       }
       return $data;
    }
    
    public function get_home_video()
    {
       $this->CI->load->model('cb_manage_home_video');
       $where['select'] = 'type, content_path, content_display_path';
       return $this->CI->cb_manage_home_video->get_home_video($where);
    }
    //TODO Add function to read from database
    //use the this->CI to call controller
    
}


?>
