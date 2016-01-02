<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <title>
            <?php
                echo $title;
            ?>
  </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <base href="<?=base_url();?>" target="_blank">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
        <?php
           echo $_styles;
        ?>

  </head>
  <body>

    <div class="container-fluid">
	<div class="row">
		<div class="col-md-12 contend">
                     <?php echo $content;?>
		</div>
        
	</div>
    </div>
     
     <?php echo $_scripts;?>
  </body>
</html>
