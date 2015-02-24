<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include "configuration.php";

/*
|--------------------------------------------------------------------------
| Instagram
|--------------------------------------------------------------------------
|
| Instagram client details
|
*/

$config['instagram_client_name']	= $cfg['instagram_client_name'];
$config['instagram_client_id']		= $cfg['instagram_client_id'];
$config['instagram_client_secret']	= $cfg['instagram_client_secret'];
$config['instagram_callback_url']	= $cfg['instagram_callback_url'];
$config['instagram_website']		= $cfg['instagram_website'];
$config['instagram_description']	= $cfg['instagram_description'];

// There was issues with some servers not being able to retrieve the data through https
// If you have this problem set the following to FALSE 
// See https://github.com/ianckc/CodeIgniter-Instagram-Library/issues/5 for a discussion on this
//$config['instagram_ssl_verify']		= TRUE;