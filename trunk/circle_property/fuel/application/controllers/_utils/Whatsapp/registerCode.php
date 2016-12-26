<?php
require_once 'ChatAPI/Registration.php';

$username = "60177002929";
$debug = true;
$code = '348891';
// Create a instance of Registration class.
$r = new Registration($username, $debug);
$r->codeRegister($code);

?>
