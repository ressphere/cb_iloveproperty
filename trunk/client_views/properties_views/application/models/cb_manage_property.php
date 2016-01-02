<?php

class cb_manage_property extends CI_Model
{
    public $property_info_data = NULL;
     function __construct()
    {
        // Call the Model constructor
        $this->property_info_data = new property_info_data;
        parent::__construct();
    }
    // --------------------------------------------------------------------
	
	/**
	 * This method takes an associative array with the key values to query the property info available in db.
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
	$where['select'] = 'id, name, published';
	$where['where'] = array('published' => 'yes');
	$where['order_by'] = 'name asc';
	$where['limit'] = 10;

	$results = $this->cb_manage_property->get_property_info($where); 
	
	</code>
	 *
	 * @access	public
	 * @param	array	an array of parameters to create a query (optional)
	 * @return	json contains the return result in array of hash
	 */
    function get_property_info($where = NULL)
    {
        $this->load->module_model('property_info', 'property_info_model');
        
        $properties_list = $this->property_info_model->query($where);
        
        return json_encode($properties_list->result());
    }
    
    /**
	 * This method will grab the data after performing filter
	 * 
	$where['where'] = array('Price_formequal' => '20');
        $where['limit'] = 10;
        $where['offset'] = 0;
	
        field name prefix, Need to make sure column name doesn't end with it
        1. _form : Represent greater than, >
        2. _formequal : Represent greater or equal to, >=
        3. _to : Represent smaller than, <
        4. _toequal : Represent smaller or equal to,  <=
        5. no prefix : Represent euqal, =

	$results = $this->cb_manage_property->get_property_count_id($where); 
	
	</code>
	 *
	 * @access	public
	 * @param	array Filter list to exclude unwanted row
	 * @return	int contains the return count result
	 */
    function get_filter_property($where = NULL)
    {
        // Load model
        $this->load->module_model('property_info', 'property_info_model');
        
        // Information extract
        if($where !== NULL)
        {
            $limt = array_key_exists('limit',$where) ? $where['limit'] : NULL; 
            $offset = array_key_exists('offset',$where) ? $where['offset'] : NULL;
            $filter_where_data = array_key_exists('where',$where) ? $where['where'] : NULL;
        }
        
        // Add filter
        $this->property_info_model->add_filters($filter_where_data);
        
        // Add filter join type
        $this->property_info_model->add_filter_join('Name','and');
        
        // Query information
        $query_return['list_of_properties'] = $this->property_info_model->list_items($limt,$offset,'id','asc',FALSE);
        $query_return['search_count'] = $this->property_info_model->list_items_total();

        return $query_return;
    }
    
    // --------------------------------------------------------------------
	
	/**
	 * This method takes an associative array with the key values that map to CodeIgniter active record methods and returns a query result object.
	 * 
	 * For more advanced, use CI Active Record. Below are the key values you can pass
	$property_info_data['Name'] = 'id, name, published';
	$property_info_data['Price'] = array('published' => 'yes');
	$property_info_data['Property_info_image'] = 'name asc';
	

	$results = $this->cb_manage_property->get_property_info($where); 
	
	</code>
	 *
	 * @access	public
	 * @param	json data(required)
	 * @return	boolean	determines whether successfully set the property info
	 */
    function set_property_info($property_info_data)
    {
        $property_info_data = json_decode($property_info_data);
        $this->load->module_model('property_info', 'property_info_model');
        $property_info['Name'] = $property_info_data->{"Name"};
        $property_info['Price'] = $property_info_data->{"Price"};
        $property_info['Property_info_image'] = $property_info_data->{"Property_info_image"};
        $success = $this->property_info_model->insert($property_info);
        return $success;
    }
    // --------------------------------------------------------------------
	
	/**
	 * This method the property listing base on name, price and photo.
	 * 
	 * For more advanced, use CI Active Record. Below are the key values you can pass
	$property_info_data['Name']
	$property_info_data['Price']
	$property_info_data['Property_info_image'] 
	

	$results = $this->cb_manage_property->get_property_info($where); 
	
	</code>
	 *
	 * @access	public
	 * @param	json data(required)
	 * @return	boolean	determines whether successfully removed the property info
	 */
     function remove_property_info($property_info_data)
    {
        $property_info_data = json_decode($property_info_data);
        $this->load->module_model('property_info', 'property_info_model');
        $property_info['Name'] = $property_info_data->{"Name"};
        $property_info['Price'] = $property_info_data->{"Price"};
        $property_info['Property_info_image'] = $property_info_data->{"Property_info_image"};
        $success = $this->property_info_model->delete($property_info);
        return $success;
        
    }
    

}
class property_info_data
{
    public $name;
    public $price;
    public $photo;
    

}
?>
