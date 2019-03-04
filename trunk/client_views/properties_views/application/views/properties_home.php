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
  <meta property="og:url" content="<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?=$og_title?>" />
  <meta property="og:image" content="<?=$og_image?>" />
  <meta property="og:description" content="<?=$og_desc?>" />
  <meta name="generator" content="<?=$generator?>"/>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  
  
  <!-- Print CSS through $this->extemplate->add_css() function -->
  <?php echo $_styles; ?>
  
  
  <!-- google plus needed-->
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="assets/images/favicon.ico">
</head>

<body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.3";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <div class="wrapper">
        <div id="main_content" class="row clearfix">
			<div class="col-md-12 column">
					<?php echo $header?>
			</div>
		</div>
        <div id="content-top" class="push row clearfix"></div>
        <div class="unfixed_content content row clearfix" style="background-color: white; ">
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
        <div id="popup_login" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
        <div id="popup_property_info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <center>
                <div id="property_info" class="modal-dialog modal-sm popup">
                    <div class="modal-header">
                        <button class="property_info close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <img class="logo" src="images/ressphere-white.png" alt="">
                    </div>
                    <div class="modal-body">
                        <div id="property_info_content"></div>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button class="property_info btn" data-dismiss="modal" type="button">Close</button>
                            
                            <br>
                        </center>
                    </div>
                </div>
            </center>
        </div>
        <div id="popup_property_preview" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <center>
                <div id="property_preview" class="modal-dialog modal-lg popup">
                      <div class="modal-header">
                        <button class="property_info close" data-dismiss="modal" type="button">
                            <span aria-hidden="true" style="font-size:50px;">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        
                    </div>
                    <div class="modal-body">
                        <div id="property_preview_content">
                            <iframe id="property_preview_content_iframe" frameborder="0" seamless 
                                    width="100%" height="100%"></iframe>
                        </div>
                    </div>
                </div>
            </center>
        </div>
        <div id="popup_currency_change"
             class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" 
             aria-hidden="true">
            <center>
                <div id="property_currency" class="modal-dialog modal-lg popup">
                    <div class="modal-header">
                        <button class="property_info close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>

                    </div>
                <div class="modal-body">
                    <div id="property_currency_content">
                        <select id="select_currency">
                            <option
                                    value="MYR">Ringgit Malaysia
                            </option>
                            <option
                                    value="SGD">Singapore Dollar
                            </option>
                            <option
                                    value="USD">US dollar
                            </option>
                        </select>

                    </div>
                </div>
                <div class="modal-footer">
                    <center>
                        <button id="btnChangeCurrency" class="btn btn-default" data-dismiss="modal" type="button">OK</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn" data-dismiss="modal" type="button">Cancel</button>

                        <br>
                    </center>
                </div>
            </div>
        </center>
    </div>
	<!-- Print js through $this->extemplate->add_js() function -->
  <?php echo $_scripts; ?>
 
</body>

</html>