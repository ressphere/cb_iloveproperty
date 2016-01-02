<?php

class cb_manage_home_video extends CI_Model
{
    public $home_video_data = NULL;
     function __construct()
    {
        // Call the Model constructor
        $this->home_video_data = new home_video_data;
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
	$home_video['select'] = 'id, value, published';
	$home_video['where'] = array('published' => 'yes');
	$home_video['order_by'] = 'name asc';
	$home_video['limit'] = 10;

	$results = $this->cb_manage_home_video->get_home_video($home_video); 
	
	</code>
	 *
	 * @access	public
	 * @param	array	an array of parameters to create a query (optional)
	 * @return	json contains the return result in array of hash
	 */
    function get_home_video($home_video = NULL)
    {
        $this->load->module_model('cb_home_video', 'home_video_model');
        
        $home_video_details = $this->home_video_model->query($home_video);
        
        return $home_video_details->result();
    }
    
    
    // --------------------------------------------------------------------
	
	/**
	 * This method takes an associative array with the key values that map to CodeIgniter active record methods and returns a query result object.
	 * 
	 * For more advanced, use CI Active Record. Below are the key values you can pass
	$home_video_data['home_video_code'] = 'home_video_code';
	$home_video_data['home_video_name'] = 'home_video_name';
                    .
                    .
                    .
	

	$results = $this->cb_manage_home_video->set_home_video($home_video); 
	
	</code>
	 *
	 * @access	public
	 * @param	json data(required)
	 * @return	boolean	determines whether successfully set the property info
	 */
    function set_home_video($home_video_data)
    {
        $home_video_data = json_decode($home_video_data);
        $this->load->module_model('cb_home_video', 'home_video_model');
        //type, content_path, content_display_path
        $cb_home_video['type'] = $home_video_data->{"type"};
        $cb_home_video['content_path'] = $home_video_data->{"content_path"};
        $cb_home_video['content_display_path'] = $home_video_data->{"content_display_path"};
        $success = $this->home_video_model->insert($cb_home_video);
        return $success;
    }
    // --------------------------------------------------------------------
	
	/**
	 * This method remove the home_video base on id.
	 * 
	 * For more advanced, use CI Active Record. Below are the key values you can pass
	$name_id
	

	$results = $this->cb_manage_home_video->remove_home_video($home_video_id); 
	
	</code>
	 *
	 * @access	public
	 * @param	int id(required)
	 * @return	boolean	determines whether successfully removed the property info
	 */
     function remove_home_video($category)
    {
        $this->load->module_model('cb_home_video', 'home_video_model');
        $success = $this->home_video_model->delete($category);
        return $success;
    }
    

}
class home_video_data
{
    public $type;
    public $content_path;
    public $content_display_path;
}
?>
