<?php

/*
 * This class provide all necessary generic function for model.
 * 
 * Provide following capability:
 *  1. validate_and_convert_id - validate thus convert value to ID
 *      a. Require column_list API
 *      b. Require model_id_list API
 *  2. Information handle
 *      a. Error handler
 *      b. Return data handler
 * 
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');

class cb_base_module_model extends Base_module_model {
    //--------------------- Global Variable ----------------------
    // Error message
    public $is_error = FALSE;
    private $dev_error_msg = "";
    private $usr_error_msg = "";
    private $error_code = "";
    
    // For unit test purpose
    private $status_information = "Info: Constructor invoke only";

    // Return data
    private $return_data = "";
    
    // Model name for database query and error message
    public $model_name = "none_and_is_error";
    public $model_code = "MBE-NON";
    
    //--------------------- Setup Function -------------------------------------
    /*
     * Constructor 
     */
    public function __construct($table_name)
    {
        // Main entries table
        parent::__construct($table_name);
        
        // Align record model name
        // Define the record class name, rather for it to when crazy
        $this->record_class = $table_name."_record";
        
        // 1. For benchmark (profiler) to keep track total execute time
        //    Able to disable through "application/config/MY_config.php"
        // 2. For Error switching purpose
        //$this->CI =& get_instance();
        //$this->CI->config->load("MY_config");
        $this->config->load("MY_config");
    }
    
    /*
     * Contain all support column list, which contain following information
     *  1. name         - Name of the column
     *  2. must_have    - Column that must exist
     * 
     * @return Array List of the column name and settings
     */
    public function column_list()
    {
        $this->set_error("MBE-".$this->model_code."-CL-1", 
                "Internal error, please contact admin", 
                "Missing column_list API for this model ".$this->model_name);
        
        $column_list = array();
        /*
        $column_list = array (
            array("name" => "dummy", "must_have" => true),
        );
        */
        return $column_list;
    }
    
    /*
     * Contain relationship between data name, related model and column
     *  1. table        - table that require to refer
     *  2. editable     - Should insert data if not found or not
     *  3. id_column      - Column name for current table
     *  4. data_column  - data and reference column in the model
     * 
     * @return Array List of model and data relationship
     */
    public function model_id_list()
    {
        $this->set_error("MBE-".$this->model_code."-MIL-1", 
                "Internal error, please contact admin", 
                "Missing model_id_list API for this model ".$this->model_name);
        $model_id_list = array();
        /*
        $model_id_list = array (
            array(
                "table" => "dummy_table", 
                "editable" => false,
                "id_column" => "dummy_id",
                "data_column" => array(
                    array("data" => "dummy_name", "column" => "dummy_column"),
                ),
             ),
        );
        */
        return $model_id_list;
    }
    
    /*
     * Call back API to perform task before data being save and before ID convert 
     *   & key check
     * 
     * @param Array Listing data to be modified
     * @return Array Listing data after modified
     */
    public function insert_data_callback($dataset)
    {
        // Direct feeding as there is no additional task
        return $dataset;
    }
    
    //---------- Error and Return Data Handler Function ------------------------
    /*
     * API to handle error message
     * 
     * @param String Error code to know the location better (e.g. p-1 is property first error)
     * @param String Error string that display to customer 
     * @param String Detai error string that display for development purpose
     */
    protected function set_error($error_code, $usr_err_msg, $dev_err_msg)
    {
        $this->is_error = TRUE;
        $this->dev_error_msg = $dev_err_msg;
        $this->usr_error_msg = $usr_err_msg;
        $this->error_code = $error_code;
    }
    
    /*
     * API to set the return data and status information
     * 
     * @param String Status information
     * @param Jason data that will pass back to caller
     */
    protected function set_data($status_info, $data)
    {
        $this->status_information = $status_info;
        $this->return_data  = $data;
    }
    
    /*
     * API to set current obj error when the previous obj execution hit error
     * The validate object must have the same error handler
     * 
     * @param String Status information
     */
    protected function validate_return_data($data_obj)
    {
        // Transfer the error message when previous object execution fail
        if($data_obj->is_error === true)
        {
            $status_data = $data_obj->get_return_data_set();
            $this->set_error(
                    $status_data["status"], 
                    $status_data["status_information"],
                    $status_data["status_information"]
                    );
        }               
    }
    
    /*
     * API to retrieve service execution result
     * 
     * @return Array Service message 
     *      ["status"] Indicate the status of service run (Error, complete or etc). 
     *      ["status_information"] Message return for display purpose. 
     *      ["data"] Output data from the service
     */
    public function get_return_data_set()
    {
        $data_set = NULL;
        
        // Select between valid condition and return result accordingly
        if ($this->is_error === TRUE)
        {
            $data_set["status"] = $this->error_code;
            
            if ($this->config->item('display_user_error')  === True)
            {
                $data_set["status_information"] = $this->usr_error_msg;
            }
            else
            {
                $data_set["status_information"] = $this->dev_error_msg;
            }
            
            $data_set["data"] = "";
        }
        else
        {
            $data_set["status"] = "Complete";
            $data_set["status_information"] = $this->status_information;
            
            if ($this->return_data === NULL)
            {
                $data_set["data"] = "";
            }
            else
            {
                $data_set["data"] = $this->return_data;
            }
        }
        
        return $data_set;
    }
    
    
    //--------------------- Generic Function -----------------------------------
    /*
     * This API perform following action
     *  1. Convert data name to id name
     *  2. Allow only the accept column name
     *  
     * @return Array Array which contain status, info and array data
     */
    public function validate_and_convert_id($insert_data)
    {
        // Perform type cast to ensure it is array
        //$insert_data = (array) $insert_data;
        
        if($this->is_error === true){return;}
        
        // Convert name to id name
        $insert_data = $this->_convert_id($insert_data);
        
        $new_dataset = array();
        $data_hit = false;
            
        if($this->is_error === true){return;}

        // Validate the column and transfer data
        foreach ($this->column_list() as $checker)
        {
            $column = $checker["name"];

            // @todo - strict check, as currently as the key exist it allow it to be pass
            if(array_key_exists($column, $insert_data))
            {
                $new_dataset[$column] = $insert_data[$column];
                $data_hit = true;
            }
            elseif ($checker["must_have"] === true)
            {
                $display_list = json_encode($insert_data);
                $this->set_error(
                        "MBE-".$this->model_code."-VACI-1", 
                        "Internal error, please contact admin", 
                        "Missing $column in $display_list for model ".$this->model_name);
            }
        }
        
        return $new_dataset;
    }
    
    /*
     * Overlay API, functionality is define in own model
     * This API perform following action
     *  1. Validate the column name check to ensure
     *  2. Perform call back before data insert
     *  3. Insert data
     */
    public function insert_data($insert_data_json,$search_condition=array())
    {
        
        // Incase this API no longer the first trigger point
        if($this->is_error === true){return;}
        
        // Convert to array from jason
        $insert_data = json_decode($insert_data_json, true);

        // Callback API to manipulate insert data, 
        $dataset = $this->insert_data_callback($insert_data);

        if($this->is_error === true){return;}
        
        // Validate and filter data, thus convert data into writable id if have any
        $dataset = $this->validate_and_convert_id($dataset);
        
        if($this->is_error === true){return;}

        // Build up model name for easy use
        $model = $this->model_name.'_model';

        // Calling itself to allow data insert
        $this->load->model($model); 

        if($search_condition === array())
        {
            // Insert data into database
            $inserted_data_id = $this->$model->save($dataset);
        }
        else
        {
            $model_obj = new $this->$model;
            
            // Extract update list
            $modi_array = array();
            foreach ($dataset as $key => $value)
            {
                $modi_array[$key] = $value;
            }
            
            $update_condition = $this->$model->update($modi_array, $search_condition);
            
            if ($update_condition === true)
            {
                $listing_array = $model_obj->find_one($search_condition,"","array");
                $inserted_data_id = $listing_array["id"];
            }
            
            // file dump -- for testing purpose -- Start --
            /*$current = "\n------------------------------\n";
            $current .= "base libraries  -- insert_data -- test on edit\n";
            $current .= json_encode($search_condition)."\n";
            $current .= json_encode($modi_array)."\n";
            $current .= json_encode($inserted_data_id)."\n";
            $current .= json_encode($listing_array)."\n";
            error_log($current, 3, "D:/webdev/resphere_test_dump.txt");
            // file dump -- for testing purpose -- End --*/
        }

        if ($inserted_data_id !== false)
        {
            // Obtain id and return
            $data_output["id"] = $inserted_data_id;
            $this->set_data("Info: Completed insert data", $data_output);
        }
        else
        {
            $model_error = $this->$model->get_errors();
            $this->set_error(
                    "MBE-".$this->model_code."-ID-1",
                    "Internal error, please contact admin",
                    "Fail with ".json_encode($model_error)." . Data insert to model ".$this->model_name." with data - ".json_encode($dataset));
        }
        
        // file dump -- for testing purpose -- Start --
        /*$current = "\n------------------------------\n";
        $current .= "base libraries  -- insert_data -- end execute\n";
        $current .= json_encode($insert_data_json)."\n";
        $current .= json_encode($search_condition);
        error_log($current, 3, "D:/webdev/resphere_test_dump.txt");
        // file dump -- for testing purpose -- End --*/
    }
    
    /*
     * To setup all join table through travel
     */
    public function basic_join_setup()
    {
        
    }
    
    /*
     * To change the query string to corresponding table name
     * 
     * @param	mixed	an array or string containg the where paramters of a query
     * @return	array   converted data according to coressponding name
     */
    public function process_filter_data_query($filter_data = array())
    {
        if($this->is_error === true){return;}
        
        // Peform lower module/table query statement
        foreach ($this->model_id_list() as $convert_condition)
        {
            // Use to store the extracted data
            $data_record = array();
            
            // Loop through data to obtain all value
            foreach ($convert_condition["data_column"] as $data)
            {
                $data_name = $data["data"];
                $data_key = $data["column"];
                
                // Need to process each data
                foreach($filter_data as $f_key => $f_data)
                {
                    // Peform string serach to cater for "=", ">" and "<" symbol
                    if(strpos($f_key,$data_name) !== false)
                    {
                        // Perform string replace
                        $new_key = str_replace($data_name, $data_key, $f_key);
                        $data_record[$new_key] = $filter_data[$f_key];
                        unset($filter_data[$f_key]);
                    }
                }
            }

            if($data_record !== array())
            {
                $mode = $convert_condition["table"]."_model";
                $this->load->model($mode); // Invoke necessary model
                
                // Throw to sub model to process
                $data_record = $this->$mode->process_filter_data_query($data_record);
                
                // Check any name that is not tie to model
                foreach ($data_record as $r_key => $d_key)
                {
                    if(strpos($r_key, ".") === false)
                    {
                        // Map those with current sub model
                        $new_key = $convert_condition["table"].".".$r_key;
                        $data_record[$new_key] = $data_record[$r_key];
                        unset($data_record[$r_key]);
                    }
                }
                
                $filter_data = array_merge($filter_data, $data_record);
            }

            // Merge back the data to filter data

            // @todo - careful about the range search and pattern, might not require as
            //          currently as the column need range is at top level 
            //$keys = array_keys($array);    
            //$search_count (int) preg_grep("/c$/",$keys);
        }
        
        return $filter_data;
    }
    
    /*
     * This API return the join and select statment to join all table up and 
     *   allow easy query. Do aware that the select statment doesn't contain
     *   display detail
     * 
     * @return Array Query string for join and select statment
     *                  join - for table joining
     *                      table - table name to join
     *                      id_mapping - table id mapping
     *                      direction - table joining direction
     *                  select - for name replace
     *                      map - name mapping
     *                      escape - true/false
     *                  name - for all name display
     */
    public function _obtain_table_query_string($is_first = false)
    {
        // For statment return
        $statement_return["join"] = array();
        $statement_return["select"] = array();
        $statement_return["name"] = array();
        
        if($this->is_error === true){return;}
        
        // Handle current data name for first level
        if ($is_first)
        {
            foreach ($this->column_list() as $column)
            {
                if($column["is_id"] === false)
                {
                    // Push in the select for name replace
                        $array_select["map"] = $column["name"];
                        $array_select["escape"] = FALSE;
                        array_push($statement_return["select"], $array_select);

                        // push in the name
                        $name_string = $column["name"];
                        array_push($statement_return["name"],$name_string);
                }
            }
        }
        // Loop through all model to obtain query statment
        foreach ($this->model_id_list() as $model_info)
        {
            // To extract next model query data
            $mode = $model_info["table"]."_model";
            // Invoke necessary model
            $this->load->model($mode);

            // To extract current model statment and join the previous model statment
            $array_join["table"] = $model_info["table"];
            $array_join["id_mapping"] = $this->model_name.".".$model_info["id_column"]." = ".$model_info["table"].".id";
            $array_join["direction"] = "LEFT";
            array_push($statement_return["join"], $array_join);

            // Extract list and only add if it is query table not id element
            $next_table_column_list = $this->$mode->column_list();

            // map name
            foreach($model_info["data_column"] as $naming)
            {
                // @todo - refector code to be lighter as two foreach take time
                foreach($next_table_column_list as $table_info)
                {
                    if($naming["column"] === $table_info["name"])
                    {
                        // Push in the select for name replace
                        $array_select["map"] = $model_info["table"].".".$naming["column"]." as ".$naming["data"];
                        $array_select["escape"] = FALSE;
                        array_push($statement_return["select"], $array_select);

                        // push in the name
                        $name_string = $model_info["table"].".".$naming["column"];
                        array_push($statement_return["name"],$name_string);
                    }
                }
            }

            // Validate and convert data to id if necessary
            $statment_query = $this->$mode->_obtain_table_query_string();

            if (count($statment_query) > 0)
            {
                $statement_return["join"] = array_merge($statement_return["join"], $statment_query["join"]);
                $statement_return["select"] = array_merge($statement_return["select"], $statment_query["select"]);
                $statement_return["name"] = array_merge($statement_return["name"], $statment_query["name"]);
            }

        }
        
        return $statement_return;
    }
    
    /*
     * Prepare for data query by:
     *    1. setup all join table
     *    2. clean up the alias name
     * 
     * @param String Specified display data (currently only support top level model)
     * @return Array query result
     */
    public function query_detail_data_setup($statment = [], $is_distinct=false)
    {
        // Obtain all necessary data
        $query_setup = $this->_obtain_table_query_string(true);
        
        // Setup for all table by joining them
        foreach($query_setup["join"] as $join_info)
        {
             $this->db->join($join_info["table"],$join_info["id_mapping"],$join_info["direction"]);
        }
        
        // Workaround for properties_listing
        if ($this->model_name == "properties_listing" && $is_distinct == false)
        {
            // Must have id for most of the process
            $this->db->select('properties_listing.id', FALSE);
            $this->db->select('properties_listing.user_id', FALSE);
        }
        
        // Workaround for aroundyou_users_model
        if ($this->model_name == "aroundyou_users" && $is_distinct == false)
        {
            // Must have id for most of the process
            $this->db->select('aroundyou_users.id', FALSE);
            $this->db->select('aroundyou_users.users_id', FALSE);
        }
        
        if($is_distinct == true)
        {
            // To get only unique data
            $this->db->distinct();
        }
        
        // If have dedicated display, else display all
        if (array_key_exists("select",$statment))
        {
            foreach ($statment as $select_statement)
            {
                $this->db->select($select_statement,FALSE);
            }
        }
        else
        {
            // Peform name mapping
            foreach($query_setup["select"] as $select_info)
            {
                 $this->db->select($select_info["map"],$select_info["escape"]);
            }
        }
    }
    
    /*
     * Handle the array for edit
     *    1. Query back the original data from model
     *    2. search and replace edit value
     *    3. Remove the id
     *    4. Special handle for aroundyou.location__company_map
     * 
     * @param Model Model to perform search
     * @param Array Filter list for data query
     * @param Array Value to be replace
     * 
     * @return Array Modified full model array data
     */
    public function model_input_array_prehadle($model_search, $filter_array, $replace_array)
    {
        $model_search->query_detail_data_setup();
        $model_return_info_array = $model_search->find_one($filter_array,"","array");
        
        foreach ($model_return_info_array as $key => $value)
        {
            // Special handle aroundyou.location__company_map
            if ($key == "location__company_map")
            {
                $model_return_info_array[$key] = json_decode($model_return_info_array[$key]);
            }
            
            // This handle second level 
            if (gettype($model_return_info_array[$key]) == "array")
            {
                foreach ($model_return_info_array[$key] as $key_sub => $value_sub)
                {
                    $model_return_info_array[$key] = $this->_replace_array_value($model_return_info_array[$key],$replace_array[$key],$key_sub);
                }
            }
            else
            {
                $model_return_info_array = $this->_replace_array_value($model_return_info_array,$replace_array,$key);
            }
        }
        
        return $model_return_info_array;
    }
    
    //--------------------- Internal Function ----------------------------------
    /*
     * This to perfrom check and replace array, which also handle \" in key issue
     */
    private function _replace_array_value($ori_array, $replace_array, $key)
    {
        // Workaround for key that contain \", which will break the update
        if (strpos($key, '"') !== false)
        {
            $key_tmp = $key;
            $key = str_replace(array('"'), '',$key);
            $ori_array[$key] = $ori_array[$key_tmp];
        }
        
        if (array_key_exists($key, $replace_array)) 
        { 
            $ori_array[$key] = $replace_array[$key]; 
        }
        
        return $ori_array;
    }
    
    /*
     * API to detect current list id, match with model_list info and convert the
     *    name to id. This include allow to invoke data store if allow to do so. 
     */
    private function _convert_id($insert_data)
    {
        if($this->is_error === true){return;}

        // Convert data to id name
        foreach ($this->model_id_list() as $convert_condition)
        {
            // Use to store the extracted data
            $data_record = array();
            // To identified all data must exist if found
            $first_data = true;
            $data_found = false;

            // Loop through data to obtain all value
            foreach ($convert_condition["data_column"] as $data)
            {
                $data_name = $data["data"];
                $data_key = $data["column"];
                
                // Extract and remove data
                if(array_key_exists($data_name, $insert_data))
                {
                    // Perform check, error if not all data found
                    if($first_data === false && $data_found === false)
                    {
                        $this->set_error(
                            "MBE-".$this->model_code."-CI-1", 
                            "Internal error, please contact admin",
                            "Found $data_name but not previous data for the dataset pass in for ".$this->model_name);
                    }
                    $data_record[$data_key] = $insert_data[$data_name];
                    unset($insert_data[$data_name]);
                    $data_found = true;
                    $first_data = false;
                }
            }
            
            if($this->is_error === true){return;}
            
            if($data_found === true)
            {
                $mode = $convert_condition["table"]."_model";
                // Invoke necessary model
                $this->load->model($mode);

                // Validate and convert data to id if necessary
                $data_record = $this->$mode->validate_and_convert_id($data_record);

                $this->validate_return_data($this->$mode);
                
                if($this->is_error === true){return;}

                // Search data form the model
                $data = $this->$mode->find_one($data_record,'','array');


                // when allow, Insert data if not found
                if (!array_key_exists("id", $data) && $convert_condition["editable"] === true)
                {
                    $this->$mode->insert_data(json_encode($data_record));

                    $this->validate_return_data($this->$mode);
                        
                    if($this->is_error === true){return;}

                    // extract id
                    $return_data = $return_data = $this->$mode->get_return_data_set();
                    $data["id"] = $return_data["data"]["id"];
                }
                
                if($this->is_error === true){return;}
                
                // Set the id name and value to the dataset
                if(array_key_exists("id", $data))
                {

                    $insert_data[$convert_condition["id_column"]] = $data['id'];
                }
            }
        }
        
        return $insert_data;
    }

}

?>
