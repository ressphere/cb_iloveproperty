<?php

class cb_manage_users extends CI_Model
{
    public $users_data = NULL;
     function __construct()
    {
        // Call the Model constructor
        $this->users_data = new users_data;
        parent::__construct();
    }
    // --------------------------------------------------------------------
	
	/**
	 * This method takes an associative array with the key values to query the users available in db.
	 * 
	 * For more advanced, use CI Active Record. Below are the key values you can pass:
	<ul>
		<li><strong>select</strong></li>
		<li><strong>from</strong></li>
		<li><strong>join</strong></li>
		<li><strong>where</strong></li>
		<li><strong>or_where</strong></li>
		<li><strong>where_in</strong></li>
		<li><strong>or_where_in</strong></li>
		<li><strong>where_not_in</strong></li>
		<li><strong>or_where_not_in</strong></li>
		<li><strong>like</strong></li>
		<li><strong>or_like</strong></li>
		<li><strong>not_like</strong></li>
		<li><strong>or_not_like</strong></li>
		<li><strong>group_by</strong></li>
		<li><strong>order_by</strong></li>
		<li><strong>limit</strong></li>
		<li><strong>offset</strong></li>
	</ul>
	
	 *
	 <code>
	$details['select'] = 'id, value, published';
	$details['where'] = array('published' => 'yes');
	$details['order_by'] = 'name asc';
	$details['limit'] = 10;

	$results = $this->cb_manage_users->get_users($details); 
	
	</code>
	 *
	 * @access	public
	 * @param	array	an array of parameters to create a query (optional)
	 * @return	json contains the return result in array of hash
	 */
    function get_users($details = NULL)
    {
        $this->load->module_model('users', 'users_model');
        
        $details = $this->users_model->query($details);
        
        return json_encode($details->result());
    }
    
    
    // --------------------------------------------------------------------
	
	/**
	 * This method takes an associative array with the key values that map to CodeIgniter active record methods and returns a query result object.
	 * 
	 * For more advanced, use CI Active Record. Below are the key values you can pass
	          
        $users_data['username'] = 'username';
        $users_data['password'] = 'password';
        $users_data['name'] = 'name';
        $users_data['phone'] = 'phone';
        $users_data['email'] = 'email';
        $users_data['activated'] = 'activated';
        $users_data['banned'] = 'banned';
        $users_data['ban_reason'] = 'ban_reason';
        $users_data['new_password_key'] = 'new_password_key';
        $users_data['new_password_requested'] = 'new_password_requested';
        $users_data['new_email'] = 'new_email';
        $users_data['new_email_key'] = 'new_email_key';
        $users_data['last_ip'] = 'last_ip';
        $users_data['last_login'] = 'last_login';
        $users_data['created'] = 'created';
        $users_data['modified'] = 'modified';
        $users_data['gold_value_id'] = 'gold_value_id';
        $users_data['property_value_id'] = 'property_value_id'; 
	
	$results = $this->cb_manage_users->set_users($users_data); 
	
	</code>
	 *
	 * @access	public
	 * @param	json data(required)
	 * @return	boolean	determines whether successfully set the property info
	 */
    function set_users($users_data)
    {
        $users_data = json_decode($users_data);
        $this->load->module_model('users', 'users_model');
        
        $obj = new ReflectionObject($users_data);
        
        if($obj->hasProperty("username")){
            $users['username'] = $users_data->{"username"};
        }
        
        if($obj->hasProperty("password")){
            $users['password'] = $users_data->{"password"};
        }
        
        if($obj->hasProperty("name")){
            $users['name'] = $users_data->{"name"};
        }
        
        if($obj->hasProperty("phone")){
            $users['phone'] = $users_data->{"phone"};
        }
        
        if($obj->hasProperty("email")){
            $users['email'] = $users_data->{"email"};
        }
        
        if($obj->hasProperty("activated")){
            $users['activated'] = $users_data->{"activated"};
        }
        
        if($obj->hasProperty("banned")){
            $users['banned'] = $users_data->{"banned"};
        }
        
        if($obj->hasProperty("ban_reason")){
            $users['ban_reason'] = $users_data->{"ban_reason"};
        }
        
        if($obj->hasProperty("new_password_key")){
            $users['new_password_key'] = $users_data->{"new_password_key"};
        }
        
        if($obj->hasProperty("new_password_requested")){
            $users['new_password_requested'] = $users_data->{"new_password_requested"};
        }
         
        if($obj->hasProperty("new_email")){
            $users['new_email'] = $users_data->{"new_email"};
        }
         
        if($obj->hasProperty("new_email_key")){
            $users['new_email_key'] = $users_data->{"new_email_key"};
        }
        
        if($obj->hasProperty("last_ip")){
            $users['last_ip'] = $users_data->{"last_ip"};
        }
        
        if($obj->hasProperty("last_login")){
            $users['last_login'] = $users_data->{"last_login"};
        }
         
        if($obj->hasProperty("created")){
            $users['created'] = $users_data->{"created"};
        }
        
        if($obj->hasProperty("modified")){
            $users['modified'] = $users_data->{"modified"};
        }
        
        if($obj->hasProperty("gold_value_id")){
            $users['gold_value_id'] = $users_data->{"gold_value_id"};
        }
         
        if($obj->hasProperty("property_value_id")){
            $users['property_value_id'] = $users_data->{"property_value_id"};
        }
         
        $success = $this->users_model->insert($users);
        return $success;
    }
    // --------------------------------------------------------------------
	
	/**
	 * This method remove the users base on name.
	 * 
	 * For more advanced, use CI Active Record. Below are the key values you can pass
	$name_id
	

	$results = $this->cb_manage_property_group->remove_property_group($name_id); 
	
	</code>
	 *
	 * @access	public
	 * @param	int id(required)
	 * @return	boolean	determines whether successfully removed the property info
	 */
     function remove_users($name)
    {
        //$service_category_data = json_decode($service_category_data);
        $this->load->module_model('users', 'users_model');
        //$CB_Service_category['category'] = $service_category_data->{"category"};
        //$CB_Service_category['description'] = $service_category_data->{"description"};
        $success = $this->users_model->delete($name);
        return $success;
    }
    
    
    // --------------------------------------------------------------------
	
	/**
	 * This method select user from db via username and update a particular user details.
	 * 
	 * 

	$results = $this->cb_manage_users->update_users($username, $field, $update); 
	
	</code>
	 *
	 * @access	public
	 * @param	usernaeme, field(which one to update), update(what to update) 
	 * @return	boolean	determines whether successfully removed the property info
	 */
    function update_users($username, $field, $update)
    {
        $this->load->module_model('users', 'users_model');
        $where['username'] = $username;
        $value[$field] = $update;
        $success = $this->users_model->update($value, $where);
        return $success;
    }
    
}
class users_data
{
    public $username;
    public $password;
    public $phone;
    public $email;
    public $activated;
    public $banned;
    public $ban_reason;
    public $new_password_key;
    public $new_password_requested;
    public $new_email;
    public $new_email_key;
    public $last_ip;
    public $last_login;
    public $created;
    public $modified;
    public $gold_value_id;
    public $property_value_id;
}
?>
