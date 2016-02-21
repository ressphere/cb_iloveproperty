<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <title>
            <?php
                echo $title;
            ?>
  </title>
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <base href="<?=base_url();?>" target="_blank">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
      
        <?=$_styles?>

  </head>
  <body>

    <div class="container-fluid">
	<div class="row">
		<div class="col-md-12 contend">
                     <?php echo $content;?>
		</div>
        
	</div>
    </div>
    
  
  <script type='text/javascript' src='<?=base_url() . "js/jquery.min.js"?>'></script>
  <script type='text/javascript' src='<?=base_url() . "js/jstorage.min.js"?>'></script>
  
  <?=$_scripts?>
  </body>

</html>
