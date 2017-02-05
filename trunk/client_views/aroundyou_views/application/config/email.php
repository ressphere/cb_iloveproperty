<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/
$config['wordwrap'] = TRUE;
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://server92.web-hosting.com';
$config['smtp_port'] = 465;
$config['smtp_user'] = 'admin@ressphere.com';
$config['smtp_pass'] = '1234abcd*';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";

/* End of file email.php */
/* Location: ./application/config/email.php */