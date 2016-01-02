<!DOCTYPE html>
<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>
            <?php echo $title; ?>
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
  <!-- Print CSS through $this->extemplate->add_css() function -->
  <?php echo $_styles; ?>
  

  
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="assets/images/favicon.png">
</head>

<body>
    <div class="wrapper">
        <div id="main_content" class="content row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default" role="navigation">
				<?php echo $header?>
			</nav>
			
		</div>
                
	</div>
        <div id="content-top" class="push row clearfix"></div>
	<div class="content row clearfix">
            <div class="col-md-12 column">
		<?php 
                         echo $contents;
                ?>
            </div>
        
	</div>
        <div class="push row clearfix"></div>
         <div id="bottom_footer" class="content row clearfix">
            <div class="col-md-12 column">
		<?php echo $footer?>
             </div>
        </div>
    </div>
        <!-- Standard place for all popup -->
        <!-- Load it at back, as it is hidden at first, so is ok-->
        <div id="popup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>
        <div id="register" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>
        <div id="popup_logout" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>
        <div id="forgot_password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
        <div id="popup_advertisement_info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <center>
                <div id="advertisement_info" class="modal-dialog modal-sm popup">
                    <div class="modal-header">
                        <button class="advertisement_info close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <img class="logo" src="images/ressphere-white.png" alt="">
                    </div>
                    <div class="modal-body">
                        <div id="advertisement_info_content"></div>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button class="advertisement_info btn" data-dismiss="modal" type="button">Close</button>
                            
                            <br>
                        </center>
                    </div>
                </div>
            </center>
        </div>
    <div id="popup_advertisement_preview" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <center>
                <div id="advertisement_preview" class="modal-dialog modal-lg popup">
                      <div class="modal-header">
                        <button class="advertisement_info close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        
                    </div>
                    <div class="modal-body">
                        <div id="advertisement_preview_content">
                            <iframe id="advertisement_preview_content_iframe" frameborder="0" seamless 
                                    width="100%" height="100%"></iframe>
                        </div>
                    </div>
                </div>
            </center>
        </div>
  <!-- Print js through $this->extemplate->add_js() function -->
  <?php echo $_scripts; ?>
	</body>

</html>