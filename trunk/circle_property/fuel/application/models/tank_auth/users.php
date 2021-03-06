<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users
 *
 * This model represents user authentication data. It operates the following tables:
 * - user account data,
 * - user profiles
 *
 * @package	Tank_auth
 * @author	Ilya Konyukhov (http://konyukhov.com/soft/)
 */
class Users extends CI_Model
{
	private $table_name			= 'users';			// user accounts
	private $profile_table_name	= 'user_profiles';	// user profiles
        private $countries = 'country';
        private $state_table = 'state';
        private $zone_table = 'zone_phone';

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->table_name			= $ci->config->item('db_table_prefix', 'tank_auth').$this->table_name;
		$this->profile_table_name	= $ci->config->item('db_table_prefix', 'tank_auth').$this->profile_table_name;
	}

	/**
	 * Get user record by Id
	 *
	 * @param	int
	 * @param	bool
	 * @return	object
	 */
	function get_user_by_id($user_id, $activated)
	{
		$this->db->where('id', $user_id);
		$this->db->where('activated', $activated ? 1 : 0);

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() >= 1) 
                    return $query->row();
                else
                    return $query->num_rows();
	}
        
	/**
	 * Get user record by login (username or email)
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_login($login)
	{
		$this->db->where('LOWER(username)=', strtolower($login));
		$this->db->or_where('LOWER(email)=', strtolower($login));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	/**
	 * Get user record by username
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_username($username)
	{
		$this->db->where('LOWER(username)=', strtolower($username));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

        /**
	 * Get user property listing limit
	 *
	 * @param	int
	 * @return	int
	 */
	function get_user_prop_listing_limit($user_id)
	{
		$this->db->where('id', $user_id);

		$query = $this->db->get($this->table_name);
                
		if ($query->num_rows() == 1) 
                    return $query->row()->prop_listing_limit;
                else
                    return NULL;
	}
        
        function set_prop_subscription_on_sms_count($user_id, $count)
        {
                $table_name = "listing_subscription";
            	$this->db->where('user_id', $user_id);
                $this->db->order_by('created_time','ASC');
		$query = $this->db->get($table_name);
                $rows = $query->result();
	        
                foreach($rows as $row) {
                    
                    if($row->number_of_sms >= $count)
                    {
                        $this->db->set('number_of_sms', ($row->number_of_sms - $count));
                        $this->db->where('id', $row->id);
                        $this->db->update($table_name);
                        break;
                    }
                }
        }
        
        function set_user_property_sms_limit($user_id, $count)
	{
		$this->db->where('id', $user_id);

		$query = $this->db->get($this->table_name);
                
		if ($query->num_rows() == 1)
                {
                    $sms_limit = $this->get_user_property_sms_limit($user_id);
                    if($sms_limit > 0)
                    {
                        if($sms_limit - $count >= 0)
                        {
                            $this->db->set('prop_sms_limit', ($sms_limit - $count));
                            $this->db->where('id', $user_id);
                            $this->db->update($this->table_name);
                            $this->set_prop_subscription_on_sms_count($user_id, $count);
                            return true;
                        }
                    }
                    return false;
                }
                else
                {
                    return false;
                }
	}
        
        function get_user_property_sms_limit($user_id)
	{
		$this->db->where('id', $user_id);

		$query = $this->db->get($this->table_name);
                
		if ($query->num_rows() == 1) 
                    return $query->row()->prop_sms_limit;
                else
                    return NULL;
	}
        
	/**
	 * Check if username available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_username_available($username)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(username)=', strtolower($username));

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 0;
	}
        
        /**
	 * Check if username(email) is using reserved keyword
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_special_character($username)
	{
            $result = false;
            
            if(preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}_|":<>?~\\\\]/', $username))
            {
                $result = true; 
            }
            
            return $result;
        }
        
        /**
	 * Check if username(email) is using reserved keyword
	 *
	 * @param	string
         * @param	bool
	 * @return	bool
	 */
	function is_reserved_keyword($username, $is_email)
	{
            $result = false;
            if($is_email)
            {
                $trimmed_username = explode('@', $username, 2);
                $trimmed_username_lowerCase = strtolower($trimmed_username[0]);
            }
            else
            {
                $trimmed_username = $username;
                $trimmed_username_lowerCase = strtolower($trimmed_username);
            }
            
            $reserved_keywords = array(
                "ressphere", 
                "admin",
                "owner",
                "agent",
                "ressphere_admin",
                "ressphere_property",
                "property_admin",
                "ressphere_aroundyou",
                "aroundyou_admin"
                );
            
            foreach ($reserved_keywords as $keyword)
            {
               if(strtolower($trimmed_username[0]) == $keyword)
               {
                   $result = true;
               }
                //if(strpos($trimmed_username_lowerCase,$keyword))
                //{
                //    $result = true;
                //}
            }
            return $result;
	}

	/**
	 * Check if email available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_email_available($email)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(email)=', strtolower($email));
		$this->db->or_where('LOWER(new_email)=', strtolower($email));

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 0;
	}
        /**
	 * get the available country id by name
	 *
	 * @param	string
	 * @return	bool
	 */
	function get_country_id($country)
	{
		$this->db->where('LOWER(name)=', strtolower($country));
		//$this->db->or_where('LOWER(new_email)=', strtolower($email));

		$query = $this->db->get($this->countries);
		if ($query->num_rows() == 1)
                {
                    return $query->row()->id;
                }
                return NULL;
	}
        
        function get_country_list()
        {
            $this->db->select('name');
            $query = $this->db->get($this->countries);
            return $query->result_array();
        }
        /**
	 * get the available area code by country
	 *
	 * @param	string
	 * @return	array
	 */
        function get_state_codes($country)
        {
            //SELECT zone.state_code
            $this->db->select($this->zone_table . '.state_code');    
            //FROM  `zone` 
            $this->db->from($this->zone_table);
            //INNER JOIN  `country` ON zone.country_id = country.id
            $country_id = $this->countries . '.id';
            $zone_country_id = $this->zone_table . '.country_id';
            $this->db->join($this->countries, $zone_country_id . ' = '. $country_id);
            //LEFT JOIN state ON zone.state_id = state.id
            $state_id = $this->state_table . '.id';
            $zone_state_id = $this->zone_table . '.state_id';
            $this->db->join($this->state_table, $zone_state_id . ' = ' . $state_id, 'LEFT');
            //WHERE LOWER(country.name) =  LOWER('Malaysia')
            $this->db->where('LOWER('.$this->countries . '.name) = ', strtolower($country));
            $query = $this->db->get();
            return $query->result_array();
        }
        /**
	 * Check if email available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_phone_available($phone)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(email)=', strtolower($phone));
		$this->db->or_where('LOWER(new_email)=', strtolower($phone));

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 0;
	}

        /**
	 * get country by user id
	 *
	 * @param	int
	 * @return	string
	 */
	function get_country($user_id)
	{
               $inner_join__str = sprintf('%s.id = %s.country_id',  $this->countries, $this->table_name); 
               $where_condition = sprintf('LOWER(%s.id)=', 'users');
               $select_result = sprintf("%s.name", $this->countries);
               $query = $this->db->select($select_result)->from($this->table_name)
                       ->join($this->countries, $inner_join__str, 'inner')
                       ->where($where_condition, strtolower($user_id))->get();
		if ($query->num_rows() == 1)
                {
                    return $query->row()->name;
                }
                else
                {
                    return NULL;
                }
	}
        
         /**
	 * get user phone number
	 *
	 * @param	int
	 * @return	string
	 */
	function get_phone_number($user_id)
	{

		$this->db->where('LOWER(id)=', strtolower($user_id));
		//$this->db->or_where('LOWER(new_email)=', strtolower($email));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1)
                {
                    return $query->row()->phone;
                }
                else
                {
                    return NULL;
                }
	}

	/**
	 * Create new user record
	 *
	 * @param	array
	 * @param	bool
	 * @return	array
	 */
	function create_user($data, $activated = TRUE)
	{
		$data['created'] = date('Y-m-d H:i:s');
		$data['activated'] = $activated ? 1 : 0;

		if ($this->db->insert($this->table_name, $data)) {
			$user_id = $this->db->insert_id();
			if ($activated)	$this->create_profile($user_id);
			return array('user_id' => $user_id);
		}
		return NULL;
	}

	/**
	 * Activate user if activation key is valid.
	 * Can be called for not activated users only.
	 *
	 * @param	int
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function activate_user($user_id, $activation_key, $activate_by_email)
	{
		$this->db->select('1', FALSE);
		$this->db->where('id', $user_id);
		if ($activate_by_email) {
			$this->db->where('new_email_key', $activation_key);
		} else {
			$this->db->where('new_password_key', $activation_key);
		}
		$this->db->where('activated', 0);
		$query = $this->db->get($this->table_name);

		if ($query->num_rows() == 1) {

			$this->db->set('activated', 1);
			$this->db->set('new_email_key', NULL);
			$this->db->where('id', $user_id);
			$this->db->update($this->table_name);

			$this->create_profile($user_id);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Purge table of non-activated users
	 *
	 * @param	int
	 * @return	void
	 */
	function purge_na($expire_period = 172800)
	{
		$this->db->where('activated', 0);
		$this->db->where('UNIX_TIMESTAMP(created) <', time() - $expire_period);
		$this->db->delete($this->table_name);
	}

	/**
	 * Delete user record
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_user($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->delete($this->table_name);
		if ($this->db->affected_rows() > 0) {
			$this->delete_profile($user_id);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Set new password key for user.
	 * This key can be used for authentication when resetting user's password.
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function set_password_key($user_id, $new_pass_key)
	{
		$this->db->set('new_password_key', $new_pass_key);
		$this->db->set('new_password_requested', date('Y-m-d H:i:s'));
		$this->db->where('id', $user_id);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Check if given password key is valid and user is authenticated.
	 *
	 * @param	int
	 * @param	string
	 * @param	int
	 * @return	void
	 */
	function can_reset_password($user_id, $new_pass_key, $expire_period = 900)
	{
		$this->db->select('1', FALSE);
		$this->db->where('id', $user_id);
		$this->db->where('new_password_key', $new_pass_key);
		$this->db->where('UNIX_TIMESTAMP(new_password_requested) >', time() - $expire_period);

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 1;
	}

	/**
	 * Change user password if password key is valid and user is authenticated.
	 *
	 * @param	int
	 * @param	string
	 * @param	string
	 * @param	int
	 * @return	bool
	 */
	function reset_password($user_id, $new_pass, $new_pass_key, $expire_period = 900)
	{
		$this->db->set('password', $new_pass);
		$this->db->set('new_password_key', NULL);
		$this->db->set('new_password_requested', NULL);
		$this->db->where('id', $user_id);
		$this->db->where('new_password_key', $new_pass_key);
		$this->db->where('UNIX_TIMESTAMP(new_password_requested) >=', time() - $expire_period);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Change user password
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function change_password($user_id, $new_pass)
	{
		$this->db->set('password', $new_pass);
		$this->db->where('id', $user_id);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Set new email for user (may be activated or not).
	 * The new email cannot be used for login or notification before it is activated.
	 *
	 * @param	int
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function set_new_email($user_id, $new_email, $new_email_key, $activated)
	{
		$this->db->set($activated ? 'new_email' : 'email', $new_email);
		$this->db->set('new_email_key', $new_email_key);
		$this->db->where('id', $user_id);
		$this->db->where('activated', $activated ? 1 : 0);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Activate new email (replace old email with new one) if activation key is valid.
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function activate_new_email($user_id, $new_email_key)
	{
		$this->db->set('email', 'new_email', FALSE);
		$this->db->set('new_email', NULL);
		$this->db->set('new_email_key', NULL);
		$this->db->where('id', $user_id);
		$this->db->where('new_email_key', $new_email_key);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Update user login info, such as IP-address or login time, and
	 * clear previously generated (but not activated) passwords.
	 *
	 * @param	int
	 * @param	bool
	 * @param	bool
	 * @return	void
	 */
	function update_login_info($user_id, $record_ip, $record_time)
	{
		$this->db->set('new_password_key', NULL);
		$this->db->set('new_password_requested', NULL);

		if ($record_ip)		$this->db->set('last_ip', $this->input->ip_address());
		if ($record_time)	$this->db->set('last_login', date('Y-m-d H:i:s'));

		$this->db->where('id', $user_id);
		$this->db->update($this->table_name);
	}

	/**
	 * Ban user
	 *
	 * @param	int
	 * @param	string
	 * @return	void
	 */
	function ban_user($user_id, $reason = NULL)
	{
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, array(
			'banned'		=> 1,
			'ban_reason'	=> $reason,
		));
	}

	/**
	 * Unban user
	 *
	 * @param	int
	 * @return	void
	 */
	function unban_user($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, array(
			'banned'		=> 0,
			'ban_reason'	=> NULL,
		));
	}

	/**
	 * Create an empty profile for a new user
	 *
	 * @param	int
	 * @return	bool
	 */
	private function create_profile($user_id)
	{
		$this->db->set('user_id', $user_id);
		return $this->db->insert($this->profile_table_name);
	}

	/**
	 * Delete user profile
	 *
	 * @param	int
	 * @return	void
	 */
	private function delete_profile($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete($this->profile_table_name);
	}
        
          /*
         * Check is user banned
         * 
         * @param int
         * @return TRUE if user is banned, otherwise FALSE
         */        
        function is_userbanned($user_id)
        {   
            $this->db->select('banned', FALSE);
            $this->db->where('id', $user_id);
            $this->db->where('banned', '1');

            $query = $this->db->get($this->table_name);
            return $query->num_rows() != 0;
        }
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */
