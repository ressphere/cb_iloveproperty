<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * This file contain all API which categories as general.
 * In which these API doesn't related or direct link to specific page/service/object
 */

/*
 * This Class contain all common function for basic manipulation
 * 
 * API list
 *  - get_posted_value
 *  - get_array_value
 *  - echo_js_html
 *  - get_image_resource_by_type
 *  - dump_error_log
 *  - is_dir_empty
 * 
 */
class aroundyou_utils__GeneralFunc__Basic
{
    /*
     * Obtain specific value from _POST
     * 
     * @Param   String  Key that hope to retrieve from _POST
     * @Return  Value   NULL if not found, else reutrn value
     */
    static function get_posted_value($key)
    {
        if(isset($_POST[$key]))
        {
            return $_POST[$key];
        }
        else
        {
            return NULL;
        }
    }
    
    /*
     * Return Value if key exist in Array, else NULL
     * 
     * @Param   Array   Array that will be search
     * @Param   String  Keys value that wish to perform check
     * @Return  Value   NULL or value if key hit  
     */
    static function get_array_value($array, $key)
    {
        if(array_key_exists($key, $array))
        {
            return $array[$key];
        }
        return NULL;
    }
    
    /*
      * API for cross browser to perform "echo" function
      * 
      * @Param String/json Message that which to display
      * @Return None
      */
    static function echo_js_html ($msg) 
    {
        $headers = headers_list();
        if(array_search('Access-Control-Allow-Origin: *', $headers) === FALSE)
        {
            header('Access-Control-Allow-Origin: *');
        }
        if(array_search('Access-Control-Allow-Methods: GET, POST', $headers)  === FALSE)
        {
            header('Access-Control-Allow-Methods: GET, POST');
        }
        if(is_string ( $msg ) == FALSE)
        {
            echo json_encode($msg);
        }
        else 
        {
            echo $msg;
        }
    }
    
    /*
     * Obtain the imange indentifier
     * 
     * @Param String Imange type
     * @Param obj Imange indentified if sucess, else error string
     */
    static function get_image_resource_by_type($type, $filename)
    {
        switch($type)
        {
            case IMAGETYPE_GIF:
                return imagecreatefromgif($filename);
            case IMAGETYPE_JPEG:
            case IMAGETYPE_JPEG2000:
                return imagecreatefromjpeg($filename);
            case IMAGETYPE_PNG:
                return imagecreatefrompng($filename);
            case IMAGETYPE_BMP:
                return imagecreatefromwbmp($filename);
            default:
                return NULL;
        }
    }
    
    /*
     * Dump error to error log
     * 
     * @Param String Error message to be dump
     * 
     */
    static function dump_error_log($error_string)
    {
        // Turn on output buffering, no output is sent from the script and store in internal buffer
        ob_start();
        
        // Dumps information about a variable
        var_dump($error_string);
        
        // Get current buffer contents and delete/release current output buffer
        $output = ob_get_clean();
        
        // Build fine error string, specified log location and dump log
        $error_string = date("H:i:s") . " : " . $output;
        $log_location = dirname(dirname(dirname(__FILE__))) . 
                                  DIRECTORY_SEPARATOR . "logs".
                                  DIRECTORY_SEPARATOR . date("Ymd"). ".log";
        
        error_log($error_string ."\n", 3, $log_location);
        
    }
    
    /*
     * Check whether the directory is empty
     * 
     * @Param String Directory name to be check
     * @Return Bool True when the directory is empty
     */
    static function is_dir_empty($dir) {
        if (!is_readable($dir))
        {
            return NULL;
        }
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) 
        {
            if ($entry != "." && $entry != "..") 
            {
                return FALSE;
            }
        }
        return TRUE;
    }
}

/*
 * This class contain necessary API for Water Mark implementation
 * The entry point will be following function
 *     - set_watermark
 * 
 * @MY - This have not tested, might be broken.... lol 
 */
class aroundyou_utils__GeneralFunc_WaterMark
{
    /*
     * Add water mark to the original imange, main entry
     * 
     * @Param Integer Current session User ID
     * @Param String Current session user name
     * @Param String Path for the img which going to be modified
     * @Param String Determine watermark pattern
     */
    static function set_watermark($user_id, $name, $img_path, $type="user")
    {
        $watermark_path = NULL; // Determine the water mark type
        
        if($type == "user")
        {
            // Take user name and phone as water mark
            
            // ------------- Determine File and path 
            // Assign a temporary directory for the water mark image file
            $tempDir = dirname(dirname(dirname(dirname(__DIR__)))) .
                          DIRECTORY_SEPARATOR . 'temp' . 
                          DIRECTORY_SEPARATOR . 'images' . 
                          DIRECTORY_SEPARATOR . $user_id;

            // Obtain phone number from service
            $user["user_id"] = $user_id;
            $phone_return_val = aroundyou_utils__DataServer__Service::SendReceive_Service_Request("CB_Member:get_user_phone_number",
                            json_encode($user));
            $phone = json_decode($phone_return_val, TRUE)["data"]["result"];
            
            // create unique file name with encrypted information, which include date time
            $current_time = date('H:i:s', time());
            $watermark_file_name = sha1($name . $phone . $current_time);
            
            // construct the water mark imange path
            $ext = "png";
            $watermark_path = $tempDir. DIRECTORY_SEPARATOR . $watermark_file_name . "." . $ext;

            // ------------- Water mark image generation
            // Create a empty image indentifer 
            $im = imagecreatetruecolor(800, 200);

            // Fill background with transparent 
            $trans_colour = imagecolorallocatealpha($im, 0, 0, 0, 127);
            imagefill($im, 0, 0, $trans_colour);
            imagesavealpha($im, TRUE);

            // Prefix color code
            $grey = imagecolorallocatealpha($im, 128, 128, 128, 50);//imagecolorallocate($im, 128, 128, 128);
            //$black = imagecolorallocatealpha($im, 0, 0, 0, 60);//imagecolorallocate($im, 0, 0, 0);
            $white = imagecolorallocatealpha($im, 255, 255, 255, 60);

            // Locate the TrueType file location
            $fontStyle = dirname(dirname(dirname(dirname(__DIR__)))) . 
                            DIRECTORY_SEPARATOR . "fonts" . 
                            DIRECTORY_SEPARATOR . "GOTHIC.TTF";
            
            // Insert phone and name
            aroundyou_utils__GeneralFunc_WaterMark::setWatermarkPositionToCenter($im, 20, 0, 20, $white, $grey, $fontStyle, $name);
            aroundyou_utils__GeneralFunc_WaterMark::setWatermarkPositionToCenter($im, 18, 0, 50, $white, $grey, $fontStyle, $phone);

            // Dump outcome into PNG file and free memory
            // Using imagepng() results in clearer text compared with imagejpeg()
            imagepng($im, $watermark_path);
            imagedestroy($im);
        }
        elseif ($type == "ressphere")
        {
            // Take company logo as water mark
            $watermark_path = dirname(dirname(dirname(__FILE__))) . 
                DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR .
                'ressphere_aroundyou_logo.png';
        }
        else
        {
            aroundyou_utils__GeneralFunc__Basic::dump_error_log("Water mark type not regconized, type=".$type);
            return FALSE;
        }
        
        // Combine the water mark and original imange
        aroundyou_utils__GeneralFunc_WaterMark::combine_img_watermark($img_path, $watermark_path);
        
        // Post processing
        if($type == "user")
        {
            // Remove the water mark file as contain user information
            unlink($watermark_path);
        }
    }
    
    /*
     * Adjust water mark icon to center
     * 
     * @Param Object Imange idendifier
     * @Param Integer Font size
     * @Param Integer Angle in degree in which text will be measure
     * @Param Integer Base point for the Y axis of the frrst character
     * @Param Integer Color index for the text
     * @Param Integer Color index for the text border
     * @Param String Path to the TrueType font
     * @Param String Text to be converted into image
     * 
     */
    static function setWatermarkPositionToCenter($im, $fontSize, $degree, $y, $color, $strokecolor, $font, $txt)
    {
        // Detect the overall string location
        $bbox = imagettfbbox($fontSize, $degree, $font, $txt);
        //Obtain the first character x location, so that the string can be place at the center point
        $centerX = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
        // Add some shadow to the name
        aroundyou_utils__GeneralFunc_WaterMark::imagettfstroketext($im, $fontSize, $degree, $centerX, $y, $color, $strokecolor, $font, $txt, 2);
    }
    
    /*
     * Convert text into image using TrueType font
     * 
     * @Param Obj Imange indentifier (return value)
     * @Param Integer Font size
     * @Param Integer Angle in degree. Higher values represent a counter-clockwise rotation. For example, a value of 90 would result in bottom-to-top reading text.
     * @Param Integer Base point for the X axis of the first character
     * @Param Integer Base point for the Y axis of the frrst character
     * @Param Integer Color index for the text
     * @Param Integer Color index for the text border
     * @Param String Path to the TrueType font
     * @Param String Text to be converted into image
     * @Param Integer Boarder width, will be double
     *  
     */
    static function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) 
    {
        // Create border for the text
        for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
            for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
                imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);

        // Convert text accordingly
        return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
    }
    
    /*
     * Merge image with water mark, Must work with aroundyou_base class
     * 
     * @Param String Path to the original image
     * @Param String Path to the new imange which cotain water mark
     * 
     */
    static function combine_img_watermark($img_path, $watermark_path)
    {
        // Exit if water mark or original image not found, error and exit
        if (!file_exists($watermark_path)) { 
            aroundyou_utils__GeneralFunc__Basic::dump_error_log("[NOT FOUND]Watermark image: " .  $watermark_path);
            return FALSE;
        }
        elseif(!file_exists($img_path))
        {
            aroundyou_utils__GeneralFunc__Basic::dump_error_log("[NOT FOUND]Targeted image: " .  $img_path);
            return FALSE;
        }

        // Obtain water mark indentifier
        list($stamp_width, $stamp_height, $stamp_type, $stamp_attr) = getimagesize($watermark_path);
        $stamp = aroundyou_utils__GeneralFunc__Basic::get_image_resource_by_type($stamp_type, $watermark_path);

        // Obtain original image indentifier
        list($im_width, $im_height, $im_type, $im_attr) = getimagesize($img_path);
        $im = aroundyou_utils__GeneralFunc__Basic::get_image_resource_by_type($im_type, $img_path);
            
        // Exit if the indentifier fail to create
        if ($im === NULL || $stamp === NULL)
        {
            aroundyou_utils__GeneralFunc__Basic::dump_error_log("None image file detected");
            return FALSE;
        }
        
        // Set the margins for the stamp and get the height/width of the stamp image
        $left = ($im_width - $stamp_width)/2;
        $top =  ($im_height - $stamp_height)/2;
        
        // Copy the stamp image onto our photo using the margin offsets and the photo 
        // width to calculate positioning of the stamp. 
        try{
            imagealphablending($stamp, true);
            imagesavealpha($stamp, true);

            imagealphablending($im, true);
            imagesavealpha($im, true);
            if(!imagecopy($im, $stamp, $left, $top, 0, 0, imagesx($stamp), imagesy($stamp)))
            {
                aroundyou_utils__GeneralFunc__Basic::dump_error_log("[FAIL] Fail to insert Watermark image");
                return FALSE;
            }
        }
        catch (Exception $e) {  
              aroundyou_utils__GeneralFunc__Basic::dump_error_log($e->getMessage());
              return FALSE;
        }

        imagealphablending($im, false);
        imagesavealpha($im, true);
        
        // Output and free memory
        imagepng($im, $img_path, 9);
        imagedestroy($im);
        imagedestroy($stamp);

        return TRUE;
    }
}
?>