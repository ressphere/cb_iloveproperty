<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
class users_model extends Base_module_model {
    
    public function __construct()
    {
        parent::__construct('users');
    }
}

class users_model_record extends Base_module_record {
 
}


?>
