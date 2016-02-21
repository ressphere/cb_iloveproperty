<!DOCTYPE html>
<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>
            <?php
                echo $title;
            ?>
  </title>
  <base href="<?=base_url();?>" target="_blank">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="<?=$author?>">
  <meta name="description" content="<?=$metadesc?>"/>
  <meta name="keywords" content="<?=$metakey?>"/>
  <meta name="generator" content="<?=$generator?>"/>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta property="og:title" content="<?=$og_title?>" />
  <meta property="og:image" content="<?=$og_image?>" />
  <meta property="og:description" content="<?=$og_desc?>" />
        <?php
           echo $_styles;
        ?>


  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="assets/images/favicon.ico">
</head>

<body data-spy="scroll" data-target=".navbar-fixed-top" data-offset="85">
<?php echo $background?>
    <div id="wrapper" class="wrapper">
	<div id="main_content" class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                            <div class="container-fluid">
				<?php echo $header?>
                            </div>
			</nav>
			
		</div>
                
	</div>
        <?php echo $contents;?><br><br><br>
        <hr>
        <?php echo $about_us;?><br><br><br><br><br>
        <?php echo $contact_us;?>
        <div class="push row clearfix"></div>
         <div id="bottom_footer" class="content row clearfix">
            <div class="col-md-12 column">
		<?php echo $footer?>
             </div>
        </div>
        
    </div>
   	<?php echo $_scripts;?>
    <!-- Standard place for all popup -->
    <div id="popup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $login_view?>
    </div>
    <div id="register" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $register_view?>
    </div>
    <div id="popup_logout" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $logout_view?>
        
    </div>
     <div id="forgot_password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $forgotpass_view?>
    </div>
    <div id="change_password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $changepass_view?>
    </div>

    <div id="popup_general_info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <center>
                <div id="general_info" class="modal-dialog modal-sm popup">
                    <div class="modal-header">
                        <button class="general_info close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <img class="logo" src="images/ressphere-white.png" alt="">
                    </div>
                    <div class="modal-body">
                        <div id="general_info_content"></div>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button class="general_info btn" data-dismiss="modal" type="button">Close</button>
                            
                            <br>
                        </center>
                    </div>
                </div>
            </center>
        </div>

</body>
</html>
