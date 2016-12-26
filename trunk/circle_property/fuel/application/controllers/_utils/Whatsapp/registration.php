<?php
require_once 'ChatAPI/Registration.php';

$username = "60177002929";
$debug = true;
$code = '922948';
// Create a instance of Registration class.
$r = new Registration($username, $debug);
//$r->checkCredentials();
$r->codeRequest('sms'); // could be 'voice' too

//$r->codeRegister($code);