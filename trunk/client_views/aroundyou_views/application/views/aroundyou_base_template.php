<!DOCTYPE html>
<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<html lang="en" ng-app="aroundyou_base_apps" >

<!-- -------------------------------------------------------
    This is the base template structure, which the content should build from
      each controller and varies through views/_usercontrols
------------------------------------------------------------ -->

    <head>
        <meta charset="utf-8">
        <title>
            <?php echo $title; ?>
        </title>

        <!-- For facebook/twitter/google+ usage -->
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

        <!-- Print js through $this->extemplate->add_js() function -->
        <?php echo $_scripts; ?>

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
        <div class="aroundyou_wrapper">
            <!-- This forming the header -->
            <div id="aroundyou_main_content" class="content row clearfix">
                <div class="col-md-12 column">
                    <nav class="navbar navbar-default" role="navigation">
                        <?php echo $header;?>
                    </nav>
                </div>
            </div>
            <div id="content-top" class="push row clearfix"></div>

            <!-- This forming the contain -->
            <div class="content row clearfix">
                <div class="col-md-12 column">
                    <?php echo $contents;?>
                </div>
            </div>
            <div class="push row clearfix"></div>

            <!-- This forming the footer -->
             <div id="bottom_footer" class="content row clearfix">
                <div class="col-md-12 column">
                    <?php echo $footer;?>
                 </div>
            </div>
        </div>

        <!-- This forming the popup -->
        <?php echo $pop_up_content;?>
      
    </body>

</html>