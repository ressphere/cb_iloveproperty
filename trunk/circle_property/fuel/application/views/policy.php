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

  <link rel="shortcut icon" href="assets/images/favicon.ico">
</head>

<body>
        <?php echo $contents;
        ?><br>
</body>
</html>
