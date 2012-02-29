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

$config['protocol'] = 'sendmail';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = '\r\n';

$config['smtp_host'] = 'http://smtp.webfaction.com';
$config['smtp_user'] = 'USERNAME';
$config['smtp_pass'] = 'PASSWORD';
$config['smtp_port'] = '465';

/* End of file email.php */
/* Location: ./application/config/email.php */
