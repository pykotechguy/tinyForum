<?php namespace tinyPHP\Classes\Models;
/**
 *
 * Login Model
 *  
 * PHP 5
 *
 * tinyPHP(tm) : Simple & Lightweight MVC Framework (http://tinyphp.us/)
 * Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 * @link http://tinyphp.us/ tinyPHP(tm) Project
 * @since tinyPHP(tm) v 0.1
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class LoginModel {
	
	private $_db;
	private $_salt;
	private $_enc;
	private $_hook;
	private $_auth;
	private $_val;
	
	public function __construct() {
		$this->_hook = new \tinyPHP\Classes\Libraries\Hooks();
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
		$this->_db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->_val = new \tinyPHP\Classes\Core\Val();
		
		$this->_db->conn();
		$this->_enc = time()+999999*(1000000*time());
		$this->_salt = substr(hash('sha512',$this->_enc),0,22);
	}
	
	public function index() {}
	
	public function run($data) {
		if(empty($data['username']) || empty($data['password']) || 
		$this->_val->is_valid_username($data['username']) == false) {
			redirect(BASE_URL . 'error/login');
		} else {
			$user = $this->_db->escape( $data['username'] );
			$pass = $this->_db->escape( $data['password'] );
			
			$cookie = sprintf("data=%s&auth=%s", urlencode($user), urlencode(tf_hash_cookie($user.$pass)));
			$mac = hash_hmac("sha512", $cookie, $this->_enc);
			$auth = $cookie . '&digest=' . urlencode($mac);
			
			$this->_db->query("UPDATE " . TP . "users SET auth_token = '" . $auth . "' WHERE username = '$user' AND active = '1'");
			
			$query = $this->_db->query( "SELECT * FROM " . TP . "users WHERE username = '$user'" );
			$results = $query->fetch_object();
			
			if(tf_check_password( $pass, $results->password, $results->user_id )) {
				if($data['remember']) {				
					/* Now we can set login our cookies. */
					setcookie("cookname", $results->auth_token, time()+$this->_hook->get_option('cookieexpire'), $this->_hook->get_option('cookiepath'), $this->_auth->cookieDomain());
	      			setcookie("cookid", tf_hash_cookie($results->user_id), time()+$this->_hook->get_option('cookieexpire'), $this->_hook->get_option('cookiepath'), $this->_auth->cookieDomain());
	   			} else {				
	   				/* Now we can set login our cookies. */
	   				setcookie("cookname", $results->auth_token, time()+86400, $this->_hook->get_option('cookiepath'), $this->_auth->cookieDomain());
	      			setcookie("cookid", tf_hash_cookie($results->user_id), time()+86400, $this->_hook->get_option('cookiepath'), $this->_auth->cookieDomain());
	   			}
				redirect(BASE_URL . 'login/success');
			} else {
				redirect(BASE_URL . 'error/login');
			}
		}
	}

}