<?php namespace tinyPHP\Classes\Libraries;
/**
 *
 * Cookies Class
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

class Cookies {
	
	private $_db;
	private $_hook;
	
	public function __construct() {
		$this->_hook = new \tinyPHP\Classes\Libraries\Hooks();
		$this->_db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->_db->conn();
	}
	
	/**
	 * Cookie Name
	 *
	 * @since 1.0
	 * @return bool Returns true if set
	 * 
	 */ 
	function getCookieName() {
		if(isset($_COOKIE['cookname'])) {
			return $_COOKIE['cookname'];
		}
	}
	
	/**
	 * Cookie ID
	 *
	 * @since 1.0
	 * @return bool Returns true if set
	 * 
	 */ 
	function getCookieID() {
		if(isset($_COOKIE['cookid'])) {
			return $_COOKIE['cookid'];
		}
	}
	
	/**
	 * Retrieve user data
	 *
	 * @since 1.0
	 * @param string (required) $field User data to print from database.
	 * @return mixed
	 * 
	 */ 
	function getUserField($field) {
		$vars = array();
		parse_str($this->getCookieName(), $vars);
		
		if(!isset($vars['data'])) {
			return NULL;
		}
		
		$sql = $this->_db->query( "SELECT " . $field . " FROM " . TP . "users WHERE username = '".$vars['data']."'" );
		$r = $sql->fetch_array();
		if($sql->num_rows > 0) {
			return $r[$field];
		}
	}
	
	/**
	 * Verify Auth Token
	 *
	 * @since 1.1
	 * @return bool Returns true if an auth_token in the database matches the user's cookie.
	 * 
	 */
	function verifyAuth() {
		$vars = array();
		parse_str($this->getCookieName(), $vars);
		
		if(!isset($vars['data'])) {
			return NULL;
		}
		
		$sql = $this->_db->query( "SELECT * FROM " . TP . "users WHERE username = '".$vars['data']."'" );
		$r = $sql->fetch_array();
		
		if($r['auth_token'] == $this->getCookieName()) {
			return true;
		}
	}
	
	/**
	 * Checkes if user is logged in.
	 *
	 * @since 1.0
	 * @return mixed Returns true if cookie hashes exist.
	 * 
	 */ 
	function isUserLoggedIn() {
		if($this->verifyAuth() && $this->getCookieID()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Returns cookie domain
	 *
	 * @since 1.0
	 * @return mixed
	 * 
	 */ 
	function cookieDomain() {
		/* Use to set cookie session for domain. */
        $cookiedomain = $_SERVER['SERVER_NAME']; 
        $cookiedomain = str_replace('www.', '', $cookiedomain);
		return $cookiedomain;
	}

	/**
	 * Logs the user out and unsets cookie and database auth_token
	 *
	 * @since 1.0
	 * @return bool True if called
	 * 
	 */
	public function logout() {
		setcookie("cookname", '', time()-$this->_hook->get_option('cookieexpire'), $this->_hook->get_option('cookiepath'), $this->cookieDomain());
      	setcookie("cookid", '', time()-$this->_hook->get_option('cookieexpire'), $this->_hook->get_option('cookiepath'), $this->cookieDomain());
		
      	$username = $this->getUserField('username');
      	
		$this->_db->query( "UPDATE " . TP . "users SET auth_token = 'NULL' WHERE username = '$username'" );
		redirect(BASE_URL);
	}

}
