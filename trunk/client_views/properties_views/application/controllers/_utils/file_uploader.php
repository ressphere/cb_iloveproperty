<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class file_uploader extends CI_Controller {
    
   function index()
   {
        $max_size = 10240*20000;
        $extensions = array('jpeg', 'jpg', 'png');
        $dir = ltrim(assets_server_path('property_listing/', 'images'), '/');
        $count = 0;
      
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['files']))
        {
          // loop all files
          foreach ( $_FILES['files']['name'] as $i => $name )
          {
            // if file not uploaded then skip it
            if ( !is_uploaded_file($_FILES['files']['tmp_name'][$i]) ){
                die ("file is not uploaded");
            }
              

              // skip large files
            if ( $_FILES['files']['size'][$i] >= $max_size ) {
                die ("file size is too big");
            }

            // skip unprotected files
            if( !in_array(pathinfo($name, PATHINFO_EXTENSION), $extensions) ) {
                die ("invalid image file type");
            }
              

            // now we can move uploaded files
              if( move_uploaded_file($_FILES["files"]["tmp_name"][$i], $dir . $name) )
                $count++;
          }

          echo json_encode(array('count' => $count));

        }
        else
        {
          echo "missing files!!!";
        }
   }

}