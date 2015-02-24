<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include "configuration.php"
/*
	Mail model using PHPMailer
*/
class Mod_mail extends CI_Model{	
	
	protected $smtp_host = $cfg['smtp_host'];
	protected $smtp_username = $cfg['smtp_username'];
	protected $smtp_password = $cfg['smtp_password'];
	/* protected $from_mail = '';
	protected $from_name = '';
	protected $to_mail = null;
	protected $to_name = null;
	protected $subject = null;
	protected $body = null; */
	protected $comp = array();
	
	function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
	
	function send($comp){
		require 'lib/phpmailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $smtp_host;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $smtp_username;                 // SMTP username
		$mail->Password = $smtp_password;                           // SMTP password

		$mail->From = $comp['from_email'];
		$mail->FromName = $comp['from_name'];
		$mail->addAddress($comp['to_mail'], $comp['to_name']);

		$mail->WordWrap = 50;
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = $comp['subject'];
		$mail->Body    = $comp['body'];

		if(!$mail->send()) {
			return $mail->ErrorInfo; 
		} else {
			return 'success';
		}
	}
}
?>	