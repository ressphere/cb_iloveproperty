<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$extemplate['active_extemplate'] = 'default';
$extemplate['default']['extemplate'] = 'aroundyou_base_template';
$extemplate['default']['regions'] = array(
   'title',
   'header',
   'metadesc',
   'metakey',
   'og_image',
   'og_desc',
   'og_title',
   'generator',
   'background',
   'author',
   'contents',
   'footer',
   'loginView',
   'registerView',
   'logoutView',
   'forgotpassView',
   'pop_up_content'
    
);
$extemplate['default']['parser'] = 'parser';
$extemplate['default']['parser_method'] = 'parse';
$extemplate['default']['parse_template'] = TRUE;

$extemplate['old_default']['extemplate'] = 'cb_home';
$extemplate['old_default']['regions'] = array(
   'title',
   'header',
   'metadesc',
   'metakey',
   'og_image',
   'og_desc',
   'og_title',
   'generator',
   'background',
   'author',
   'contents',
   'footer',
   'loginView',
   'registerView',
   'logoutView',
   'forgotpassView',
   'pop_up_content'
    
);
$extemplate['old_default']['parser'] = 'parser';
$extemplate['old_default']['parser_method'] = 'parse';
$extemplate['old_default']['parse_template'] = TRUE;

$extemplate['aroundyou_404_page']['extemplate'] = 'page404_home';
$extemplate['aroundyou_404_page']['regions'] = array(
'title',
'content'
);
$extemplate['aroundyou_404_page']['parser'] = 'parser';
$extemplate['aroundyou_404_page']['parser_method'] = 'parse';
$extemplate['aroundyou_404_page']['parse_template'] = TRUE;

$extemplate['aroundyou_403_page']['extemplate'] = 'page404_home';
$extemplate['aroundyou_403_page']['regions'] = array(
'title',
'content'
);
$extemplate['aroundyou_403_page']['parser'] = 'parser';
$extemplate['aroundyou_403_page']['parser_method'] = 'parse';
$extemplate['aroundyou_403_page']['parse_template'] = TRUE;

$config = array();
?>