<?php namespace tinyPHP\Classes\Libraries;
/**
 *
 * Email Class
 *  
 * PHP 5
 *
 * tinyForum(tm) : Simple & Lightweight Forum (http://tinyforum.us/site/index)
 * Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 * @link http://tinyforum.us/site/index tinyForum(tm) Project
 * @since tinyForum(tm) v 0.1
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class Email {
	
	private $_hook;
	private $_mailer;
	
	public function __construct() {
		$this->_hook = new \tinyPHP\Classes\Libraries\Hooks();
		$this->_mailer = new \tinyPHP\Classes\Libraries\PHPMailer(true);
	}
	
	 /**
	  * Borrowed from WordPress
	  *
	  * Send mail, similar to PHP's mail
	  * A true return value does not automatically mean that the user received the
	  * email successfully. It just only means that the method used was able to
	  * process the request without any errors.
	  */
	 public function tf_mail( $to, $subject, $message, $headers = '' ) {
		$charset = 'UTF-8';
		
		// From email and name
		// If we don't have a name from the input headers
		if ( !isset( $from_name ) )
			$from_name = 'tinyForum';
		
		if ( !isset( $from_email ) ) {
			// Get the site domain and get rid of www.
			$sitename = strtolower( $_SERVER['SERVER_NAME'] );
			if ( substr( $sitename, 0, 4 ) == 'www.' ) {
				$sitename = substr( $sitename, 4 );
			}

			$from_email = 'tinyForum@' . $sitename;
		}
		
		// Plugin authors can override the default mailer
		$this->_mailer->From     = $this->_hook->apply_filter( 'tf_mail_from'     , $from_email );
		$this->_mailer->FromName = $this->_hook->apply_filter( 'tf_mail_from_name', $from_name  );
		
		// Set destination addresses
		if ( !is_array( $to ) )
			$to = explode( ',', $to );

		foreach ( (array) $to as $recipient ) {
			try {
				// Break $recipient into name and address parts if in the format "Foo <bar@baz.com>"
				$recipient_name = '';
				if( preg_match( '/(.*)<(.+)>/', $recipient, $matches ) ) {
					if ( count( $matches ) == 3 ) {
						$recipient_name = $matches[1];
						$recipient = $matches[2];
					}
				}
				$this->_mailer->AddAddress( $recipient, $recipient_name);
			} catch ( phpmailerException $e ) {
				continue;
			}
		}

		// Set mail's subject and body
		$this->_mailer->Subject = $subject;
		$this->_mailer->Body    = $message;
		
		// Set to use PHP's mail()
		$this->_mailer->IsMail();

		// Set Content-Type and charset
		// If we don't have a content-type from the input headers
		if ( !isset( $content_type ) )
			$content_type = 'text/plain';

			$content_type = $this->_hook->apply_filter( 'tf_mail_content_type', $content_type );

			$this->_mailer->ContentType = $content_type;

		// Set whether it's plaintext, depending on $content_type
		if ( 'text/html' == $content_type )
			$this->_mailer->IsHTML( true );

			// Set the content-type and charset
			$this->_mailer->CharSet = $this->_hook->apply_filter( 'tf_mail_charset', $charset );

		// Set custom headers
		if ( !empty( $headers ) ) {
			foreach( (array) $headers as $name => $content ) {
				$this->_mailer->AddCustomHeader( sprintf( '%1$s: %2$s', $name, $content ) );
			}

			if ( false !== stripos( $content_type, 'multipart' ) && ! empty($boundary) )
				$this->_mailer->AddCustomHeader( sprintf( "Content-Type: %s;\n\t boundary=\"%s\"", $content_type, $boundary ) );
		}
		
		if ( !empty( $attachments ) ) {
			foreach ( $attachments as $attachment ) {
				try {
					$this->_mailer->AddAttachment($attachment);
				} catch ( phpmailerException $e ) {
					continue;
				}
			}
		}
		
		$this->_hook->do_action_array( 'tfMailer_init', array( &$this->_mailer ) );
		
		// Send!
		try {
			$this->_mailer->Send();
		} catch ( phpmailerException $e ) {
			return false;
		}

			return true;
	 }

	public function tf_register_email($username, $email, $pass, $alink, $host) {
		$message = 
		"Hello $username,\n
		Thank you for registering with us. Here are your login details...\n
		
		User ID: $username
		Email: $email
		Password: $pass \n
		
		Click the link to activate your account: $alink
		
		Thank You
		
		Administrator
		$host
		______________________________________________________
		THIS IS AN AUTOMATED RESPONSE. 
		***DO NOT RESPOND TO THIS EMAIL****
		";
		
		$headers  = "From: \"tinyForum Member Registration\" <auto-reply@$host>\r\n";
		$headers .= "X-Mailer: PHP/" . phpversion();
		
		$this->tf_mail($email,"Login Details",$message,$headers);
		
		return $this->_hook->apply_filter('register_email',$message,$headers);
	}
	
	public function tf_reset_pass($email, $pass, $host) {
		$message = 
		"Below is the new password you requested ...\n
		
		Password: $pass \n
		
		Thank You
		
		Administrator
		$host
		______________________________________________________
		THIS IS AN AUTOMATED RESPONSE. 
		***DO NOT RESPOND TO THIS EMAIL****
		";

		$headers  = "From: \"tinyForum Reset Password\" <auto-reply@$host>\r\n";
		$headers .= "X-Mailer: PHP/" . phpversion();
	
		$this->tf_mail($email,"Reset Password",$message,$headers);
		return $this->_hook->apply_filter('reset_pass',$message,$headers);
	}
  
}