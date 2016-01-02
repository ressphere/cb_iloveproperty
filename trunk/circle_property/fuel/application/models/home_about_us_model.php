<?php
//CB_Home_about_us
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
class home_about_us_model extends Base_module_model {
    public function __construct()
    {
        parent::__construct('CB_Home_about_us');
    }
    
    function form_fields($values = array()) 
    {
        $fields = parent::form_fields();
        $fields['content']=array(
            'required'=>TRUE,
            'type' => 'textarea',
            'cols'=>40,
            'rows'=>5,
            'class'=>'wysiwyg');
        return $fields;
    }
}
class home_about_us_model_record extends Base_module_record
{
}
?>
