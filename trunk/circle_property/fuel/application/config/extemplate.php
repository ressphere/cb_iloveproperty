<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$extemplate['active_extemplate'] = 'default';
$extemplate['default']['extemplate'] = 'cb_home';
$extemplate['default']['regions'] = array(
   'title',
   'header',
   'metadesc',
   'metakey',
   'generator',
   'og_image',
   'og_desc',
   'og_title',
   'background',
   'author',
   'contents',
   'about_us',
   'contact_us',
   'footer',
   'login_view',
   'register_view',
   'logout_view',
   'forgotpass_view',
   'changepass_view'
    
);
$extemplate['default']['parser'] = 'parser';
$extemplate['default']['parser_method'] = 'parse';
$extemplate['default']['parse_template'] = TRUE;

$extemplate['login']['extemplate'] = 'cb_login';
$extemplate['login']['regions'] = array(
'login_dialog'
);
$extemplate['login']['parser'] = 'parser';
$extemplate['login']['parser_method'] = 'parse';
$extemplate['login']['parse_template'] = TRUE;

$extemplate['profile']['extemplate'] = 'user_profile_detail';
$extemplate['profile']['regions'] = array(
'content'
);
$extemplate['profile']['parser'] = 'parser';
$extemplate['profile']['parser_method'] = 'parse';
$extemplate['profile']['parse_template'] = TRUE;

$extemplate['page404_home']['extemplate'] = 'page404_home';
$extemplate['page404_home']['regions'] = array(
'title',
'content'
);
$extemplate['page404_home']['parser'] = 'parser';
$extemplate['page404_home']['parser_method'] = 'parse';
$extemplate['page404_home']['parse_template'] = TRUE;

$extemplate['ressphere_map']['extemplate'] = 'ressphere_map';
$extemplate['ressphere_map']['regions'] = array(
   'title',
   'header',
   'metadesc',
   'metakey',
   'generator',
   'og_image',
   'og_desc',
   'og_title',
   'content'
);
$extemplate['ressphere_map']['parser'] = 'parser';
$extemplate['ressphere_map']['parser_method'] = 'parse';
$extemplate['ressphere_map']['parse_template'] = TRUE;

$config = array();
?>