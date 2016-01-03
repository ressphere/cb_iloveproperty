<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(dirname(__FILE__)).'/properties_base.php';
class properties_upload extends properties_base 
{
    private $tempDir = NULL;
    function __construct() {
        parent::__construct();
        $this->load->helper("url"); 
        $this->load->library("extemplate");
        $this->load->library("session");
        
        $user_id = $this->session->userdata('user_id');
        if($user_id !== FALSE)
        {
            $this->tempDir = dirname(dirname(dirname(dirname(dirname(__DIR__))))) .
                        DIRECTORY_SEPARATOR . 'temp' . 
                        DIRECTORY_SEPARATOR . 'images' . 
                    DIRECTORY_SEPARATOR . $user_id;
        }
    }
    private function deleteDirectory($dir) {
            if (!file_exists($dir)) {
                    return true;
            }

            if (!is_dir($dir)) {
                    return unlink($dir);
            }

            foreach (scandir($dir) as $item) {
                    if ($item == '.' || $item == '..') {
                            continue;
                    }

                    if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                            return false;
                    }

            }

            return rmdir($dir);
	}
    /**
     * 
     * @author Tan Chun Mun
     * This function allow to upload photo to the root images
     */
    public function images()
    {
        $reference = $this->session->userdata('Reference');
        $status = TRUE;
        if($reference !== FALSE && $this->tempDir !== NULL)
        {
            $flowTotalSize = isset($_FILES['file']) ? $_FILES['file']['size'] : $_GET['flowTotalSize'];
            $flowRelativePath = isset($_FILES['file']) ? $_FILES['file']['tmp_name'] : $_GET['flowRelativePath'];
            //create user id folder if not created
       
            if (!is_dir($this->tempDir)) {
                try
                {
                    mkdir($this->tempDir);
                }
                catch (Exception $e) {
                    $this->set_error($e->getMessage());
                }
            }
            //Create reference type folder if not created
            $this->tempDir =  $this->tempDir . DIRECTORY_SEPARATOR . $reference;
            if (!is_dir($this->tempDir)) {
                try
                {
                    mkdir($this->tempDir);
                   
                }
                catch (Exception $e) {
                    $this->set_error($e->getMessage());
                }
            }
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $chunkDir = $this->tempDir . DIRECTORY_SEPARATOR . $_GET['flowIdentifier'];
                    $chunkFile = $chunkDir.'/chunk.part'.$_GET['flowChunkNumber'];
                    if (file_exists($chunkFile)) {
                            header("HTTP/1.0 200 Ok");
                    } else {
                            header("HTTP/1.0 404 Not Found");
                    }
            }

            try {
                    // You should also check filesize here. 
                    if ($flowTotalSize > 5000000) {
                        throw new RuntimeException('Exceeded filesize limit.');
                    }
                    if(getimagesize($flowRelativePath) === FALSE)
                    {
                        throw new RuntimeException('Uploaded file is not an image: ' . $flowRelativePath);
                    }
                    $ext = pathinfo($flowRelativePath, PATHINFO_EXTENSION);
                    $file_name = rtrim(basename($flowRelativePath, $ext), ".");
                    if($ext === "")
                    {
                        $ext = "tmp";
                        $file_with_extesion = array($file_name, $ext);
                        if(isset($_FILES['file']))
                            $_FILES['file']['tmp_name'] = implode (".", $file_with_extesion); 
                        else
                            $_GET['flowRelativePath'] = implode (".", $file_with_extesion);
                    }
                    if (move_uploaded_file(
                        $flowRelativePath,
                        sprintf($this->tempDir. DIRECTORY_SEPARATOR . '%s.%s',
                            //sha1($flowRelativePath),
                            $file_name,
                            $ext
                        )
                    )) {
                        //Begin watermark successful loaded photo
                        $img_url = $this->tempDir. DIRECTORY_SEPARATOR . $file_name . "." . $ext;
                        if($this->set_watermark($img_url) === FALSE)
                            unlink ($img_url);//remove photo that cannot been watermark
                    }
                    else
                    {
                        throw new RuntimeException('Failed to move uploaded file: '+ $file_name + 'ext: ' + $ext);
                    }

            } 
            catch (RuntimeException $e) {
                
              if($e->getMessage() !== "Exceeded filesize limit.")
              {
                $this->set_error($e->getMessage());
              }
              $status=FALSE;

            }
        }
        $result = [
                'temp dir'=>$this->tempDir,
                'success' => $status,
                'files' => $_FILES,
                'get' => $_GET,
                'post' => $_POST
            ];
       $this->_print(json_encode($result));
    }
    /**
     * 
     * @author Tan Chun Mun
     * This function is to create reference folder in asset
     */
    private function create_references($reference, &$returned_targeted_image_directory)
    {
        $asset_path = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . "assets";
        $returned_targeted_image_directory = $asset_path . 
                DIRECTORY_SEPARATOR . 'images' . 
                DIRECTORY_SEPARATOR . 'properties' .
                DIRECTORY_SEPARATOR . $reference;
        try
        {
            if (!is_dir($returned_targeted_image_directory))
                mkdir($returned_targeted_image_directory);
            return TRUE;
        }
        catch (Exception $ex)
        {
             $this->set_error($ex->getMessage());
        }
        return FALSE;
    }
     /**
     * 
     * @author Tan Chun Mun
     * @TODO copy the image base on reference to the destinated folder
     * This function allow to upload photo to the root images
     * 
     */
    
    public function commit_images_and_validation()
    {
        //Get the json from the client
         $image_list_json = $this->_get_posted_value('image_list');
         $listing = $this->_get_posted_value("listing_information");
         $reference = $this->session->userdata('Reference');
         $targeted_image_path = NULL;
         $internal_error = NULL;
         
         $result = array("status"=>"error", "data"=>"", "info"=>"");
         $validation = $this->validation(json_decode($listing), $result);
         
         if($reference && $image_list_json && $this->tempDir !== NULL && 
                $validation == TRUE)
         {
             $image_list = json_decode($image_list_json, true);
             //var_dump($image_list);
             //create the folder base on the session reference number
             $uploaded_files = array();
             $asset_dir_created = FALSE;
             if(count($image_list) > 0)
             {
                $asset_dir_created = $this->create_references($reference, $targeted_image_path);
             }
             else
             {
                //set this status to fail if photo is mandatory
                $result["status"] = "success";
                $result["data"] = array();
                $this->_print(json_encode($result));
                if(is_dir($this->tempDir . DIRECTORY_SEPARATOR . $reference))
                {
                    $this->deleteDirectory($this->tempDir . DIRECTORY_SEPARATOR . $reference);
                }
                
                return;
             }
             if($asset_dir_created === TRUE)
             {
                foreach ($image_list as $image)
                {
                   foreach($image['tmp_files'] as $tmp_image )
                   {
                       $full_tmp_image = $this->tempDir . DIRECTORY_SEPARATOR . $reference .
                               DIRECTORY_SEPARATOR . $tmp_image;
                       if(file_exists($full_tmp_image))
                       {
                            //$ext = pathinfo($image['name'], PATHINFO_EXTENSION);
                            $new_filename = $targeted_image_path . DIRECTORY_SEPARATOR . 
                                    $tmp_image;
                            $new_filename_url = base_url() . "assets/images/properties/" . 
                                    $reference ."/".$tmp_image;
                            rename($full_tmp_image, $new_filename);
                            array_push($uploaded_files, array("path"=>$new_filename_url, "description"=>$image['desc']));
                       }
                       else
                       {
                           $this->set_error($full_tmp_image . " does not exists!!!!");
                       }
                   }
                }
                $result["status"] = "success";
                $result["data"] = $uploaded_files;
                
                if(is_dir($this->tempDir . DIRECTORY_SEPARATOR . $reference))
                {
                    $this->deleteDirectory($this->tempDir . DIRECTORY_SEPARATOR . $reference);
                }
             }
             else
             {
                $this->set_error("Fail to create reference directory");
             }
         }
         else
         {
             if($image_list_json)
             {
                 $result["status"] = "success";
                 $result["info"] = "Empty Image";
                 $result["data"] = "";
             }
             else
             {
                if($validation === TRUE)
                {
                    $internal_error = "reference:" .$reference." image list json:" . $image_list_json;
                }
             }
         }
         if($internal_error !== NULL)
         {
            $this->set_error($internal_error);
         }
         else
         {
            $this->_print(json_encode($result));
         }
         
    }
    
    public function upload_listing()
    {
        $listing = $this->_get_posted_value("listing_information");
        $reference = $this->session->userdata('Reference');
        $user_id = $this->session->userdata('user_id');
        $internal_error = NULL;
        $result = array("status"=>"", "data"=>"", "info"=>"");
        $validation = $this->validation(json_decode($listing), $result);
        if($listing && $reference && $user_id && $validation == TRUE)
        {
            $listing_obj = json_decode($listing);
            $listing_obj->{'user_id'} = $user_id;
            if($listing_obj->{'buildup'} === FALSE || $listing_obj->{'landarea'} === FALSE)
            {
                $val_return_array["status"] = "error";
                $val_return_array["status_information"] = "Incorrect measurement type";
            }
            else
            {
                $service = "CB_Property:upload_listing";
                $val_return = GeneralFunc::CB_SendReceive_Service_Request($service,json_encode($listing_obj));
            
                $val_return_array = json_decode($val_return, true);
            }
            if(strtolower ($val_return_array["status"]) === "complete")
            {
               $reference = $val_return_array["data"]["ref_tag"];
               $result["status"] = "success";
               $result["info"] = "Your property information is uploaded<BR>Your reference is<BR><B>". $reference . "</B>";
               
            }
            else {
               //Ugly way of writing need to pack to a dictionary 
               $error_string = "<B>Sorry</B> <BR>Your listing cannot been uploaded: <BR>";
               $error_string = $error_string . $val_return_array["status"] . "<BR>";
               $error_string = $error_string . $val_return_array["status_information"]. "<BR>";
               $result["status"] = "error";
               $result["info"] = $error_string;
            }
                 //clean up reference id since is no longer needed
            $this->session->unset_userdata('Reference');
             
            
        }
        else
        {
            if($validation === TRUE)
            {
               $internal_error = "invalid data passing: (" . $listing ."," . $reference . ",". $user_id .")";
            }
        }
        if($internal_error !== NULL)
        {
            $this->set_error($internal_error);
        }
        else
        {
            $this->_print(json_encode($result));
        }
        
    }
    private function convert_size_unit_to_sqft($unit_value, $unit_type)
    {
        return $this->size_unit_converter_to_sqft($unit_value, $unit_type);
    }
    public function validation($listing, &$result)
    {
        $status = TRUE;
        $required_fields = array('unit_name', 'state', 'area', 'postcode', 'street', 'country', 'location');
        $error_fields = array();
        
        foreach($required_fields as $required_field)
        {
            if($listing->{$required_field} === "" || $listing->{$required_field} === NULL)
            {
                array_push($error_fields, $required_field);
            }
            elseif($required_field === 'postcode' &&  is_numeric($listing->{$required_field}) === FALSE)
            {
                array_push($error_fields, $required_field);
            }
        }
        if(count($error_fields) > 0)
        {
            $result["status"] = "error";
            $result["data"] = $error_fields;
            $status = FALSE;
        }
        
        
       /*
        * 'unit_name' : $('#unit_name').val(),
                    'state': $('#state').val(),
                    'area': $('#area').val(),
                    'postcode':$('#postcode').val(),
                    'street':$('#street').val(),
                    'country':$.trim($('#country').val()),
                    'location':$scope.country_state.location,
        */
        return $status;
    }
    /*Get number of listing to disallow more than expected listing can be uploaded*/
    public function get_number_of_listings()
       {           
           $user_id = $this->session->userdata('user_id');
           
           if($user_id)
           {              
                //setup the listing filter by user id
                $filter_struct["filter"]["user_id"] = $user_id;

                //get the filtered listing details
                $val_return_listing = GeneralFunc::CB_SendReceive_Service_Request("CB_Property:filter_listing",
                        json_encode($filter_struct));

                $listings = json_decode($val_return_listing, TRUE)["data"]["listing"];

                return sizeof($listings);
                               
           }
           else
           {
               $this->set_error("function:get_number_of_listings failed with invalid user id: (" . $user_id .")");
           }
       }
}

?>