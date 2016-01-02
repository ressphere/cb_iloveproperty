<?php

class cb_manage_home_category extends CI_Model
{
    public $home_category_data = NULL;
     function __construct()
    {
        // Call the Model constructor
        $this->home_category_data = new home_category_data;
        parent::__construct();
    }
    // --------------------------------------------------------------------
	
	/**
	 * This method takes an associative array with the key values to query the category available in db.
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
	$home_category['select'] = 'id, value, published';
	$home_category['where'] = array('published' => 'yes');
	$home_category['order_by'] = 'name asc';
	$home_category['limit'] = 10;

	$results = $this->cb_manage_home_category->get_home_category($home_category); 
	
	</code>
	 *
	 * @access	public
	 * @param	array	an array of parameters to create a query (optional)
	 * @return	json contains the return result in array of hash
	 */
    function get_home_category($home_category = NULL)
    {
        $this->load->module_model('cb_home_category', 'home_category_model');
        
        $home_category_details = $this->home_category_model->query($home_category);
        
        return $home_category_details->result();
    }
    
    
    // --------------------------------------------------------------------
	
	/**
	 * This method takes an associative array with the key values that map to CodeIgniter active record methods and returns a query result object.
	 * 
	 * For more advanced, use CI Active Record. Below are the key values you can pass
	$home_category_data['home_category_code'] = 'home_category_code';
	$home_category_data['home_category_name'] = 'home_category_name';
                    .
                    .
                    .
	

	$results = $this->cb_manage_home_category->set_home_category($home_category); 
	
	</code>
	 *
	 * @access	public
	 * @param	json data(required)
	 * @return	boolean	determines whether successfully set the property info
	 */
    function set_home_category($home_category_data)
    {
        $home_category_data = json_decode($home_category_data);
        $this->load->module_model('cb_home_category', 'home_category_model');
        $cb_home_category['category'] = $home_category_data->{"category"};
        $cb_home_category['category_path'] = $home_category_data->{"category_path"};
        $cb_home_category['category_icon'] = $home_category_data->{"category_icon"};
        $cb_home_category['category_mo_icon'] = $home_category_data->{"category_mo_icon"};
        $success = $this->home_category_model->insert($cb_home_category);
        return $success;
    }
    // --------------------------------------------------------------------
	
	/**
	 * This method remove the home_category base on id.
	 * 
	 * For more advanced, use CI Active Record. Below are the key values you can pass
	$name_id
	

	$results = $this->cb_manage_home_category->remove_home_category($home_category_id); 
	
	</code>
	 *
	 * @access	public
	 * @param	int id(required)
	 * @return	boolean	determines whether successfully removed the property info
	 */
     function remove_home_category($category)
    {
        //$service_category_data = json_decode($service_category_data);
        $this->load->module_model('cb_home_category', 'home_category_model');
        //$CB_Service_category['category'] = $service_category_data->{"category"};
        //$CB_Service_category['description'] = $service_category_data->{"description"};
        $success = $this->home_category_model->delete($category);
        return $success;
    }
    

}
class home_category_data
{
    public $category;
    public $category_path;
    public $category_icon;
    public $category_mo_icon;    
}
?>
