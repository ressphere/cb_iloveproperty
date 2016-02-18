<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$extemplate['active_extemplate'] = 'default';
$extemplate['default']['extemplate'] = 'properties_home';
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
   'forgotpassView'
    
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
   'forgotpassView'
    
);
$extemplate['old_default']['parser'] = 'parser';
$extemplate['old_default']['parser_method'] = 'parse';
$extemplate['old_default']['parse_template'] = TRUE;

$extemplate['page404_home']['extemplate'] = 'page404_home';
$extemplate['page404_home']['regions'] = array(
'title',
'content'
);
$extemplate['page404_home']['parser'] = 'parser';
$extemplate['page404_home']['parser_method'] = 'parse';
$extemplate['page404_home']['parse_template'] = TRUE;

$extemplate['page403_home']['extemplate'] = 'page404_home';
$extemplate['page403_home']['regions'] = array(
'title',
'content'
);
$extemplate['page403_home']['parser'] = 'parser';
$extemplate['page403_home']['parser_method'] = 'parse';
$extemplate['page403_home']['parse_template'] = TRUE;
$config = array();
?>