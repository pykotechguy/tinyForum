<?php namespace tinyPHP\Classes\Models;
/**
 *
 * Register Model
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

class RegisterModel {
		
	private $_db;
	private $_cache;
	private $_val;
	
	public function __construct() {
		$this->_db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->_db->conn();
		
		$this->_cache = new \tinyPHP\Classes\Libraries\Cache('',BASE_PATH.'tmp/cache/','');
		$this->_val = new \tinyPHP\Classes\Core\Val();
	}
	
	public function save($data) {
		if(empty($data['username']) || 
			$this->_val->is_valid_email(($data['email'])) != true || 
			empty($data['password'])) :
			redirect(BASE_URL . 'error/register');
		else:
			$user = $this->_db->escape(strtolower($data['username']));
			$pass = tf_hash_password($data['password']);
			$email = $this->_db->escape($data['email']);
			
			$this->_db->insert( TP."users",
								array(
										$user,
										$pass,
										$email,
										"1"
									 ),
									 	"username,
									 	password,
									 	email,
									 	active"
									);
			$this->_cache->purge();
			redirect(BASE_URL . 'register/success');
		endif;
	}

}