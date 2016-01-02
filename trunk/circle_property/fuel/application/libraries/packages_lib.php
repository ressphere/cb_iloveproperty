<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * packages_lib
 *
 * Packages library for web service
 */
class packages_lib
{
	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->model('packages');

	}
        
        
        /**
	 * Get the package via package code
	 * @return	array
	 */
        function get_packages($packages_code)
        {
            return $this->ci->packages->get_packages_full($packages_code);
        }
        
        
        /**
	 * Get the package price via package code
	 * @return	decimal(10,2)
	 */
        function get_packages_price($packages_code)
        {
            $package = $this->ci->packages->get_packages_full($packages_code);
            return $package['price'];
        }
        
        
        /**
	 * Get the feature price via type
	 * @return	decimal(10,2)
	 */
        function get_features_price($type)
        {
            $package = $this->ci->packages->get_features_by_type($type);
            return $package['price'];
        }
        
        
        /**
	 * insert a package(int, char, bool)
	 * @return	bool
	 */
        function insert_packages($code, $promotion, $active)
        {
            $packages['code']=$code;
            $packages['promotion']=$promotion;
            $packages['active']=$active;
            
            return $this->ci->packages->set_packages(json_encode($packages));
        }
        
        
        /**
	 * insert a package(int, char, bool)
	 * @return	bool
	 */
        function remove_packages($code)
        {
            return $this->ci->packages->remove_packages_by_code($code);
        }
}