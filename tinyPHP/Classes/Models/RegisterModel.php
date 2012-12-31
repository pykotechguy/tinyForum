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
	private $_email;
	
	public function __construct() {
		$this->_db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->_db->conn();
		
		$this->_cache = new \tinyPHP\Classes\Libraries\Cache('',BASE_PATH.'tmp/cache/','');
		$this->_val = new \tinyPHP\Classes\Core\Val();
		$this->_email = new \tinyPHP\Classes\Libraries\Email();
	}
	
	public function save($data) {		
		if(empty($data['username']) || 
			$this->_val->is_valid_email(($data['email'])) != true || 
			empty($data['password'])) :
			redirect(BASE_URL . 'error/register');
		else:
			$md5 = $data['md5'];
			$user = $this->_db->escape(strtolower($data['username']));
			$pass = tf_hash_password($data['password']);
			$email = $this->_db->escape($data['email']);
			$code = (int)$data['activation_code'];
			$date = $data['regdate'];
			
			$q = $this->_db->insert( TP."users",
				array(
						$md5,
						$user,
						$pass,
						$email,
						$code,
						$date
					 ),
					 	"md5_id,
					 	username,
					 	password,
					 	email,
					 	activation_code,
					 	regdate"
					);
			if($q) {
				$this->_cache->purge();
				$this->_email->tf_register_email($user,$email,$data['password'],BASE_URL."register/activate/".$code,$_SERVER['HTTP_HOST']);
				redirect(BASE_URL . 'register/success');
			} else {
				redirect(BASE_URL.'error/register');
			}
		endif;
	}
	
	public function activate($id) {
		$q1 = $this->_db->query( "SELECT * FROM ".TP."users WHERE activation_code = '$id'" );
		$r = $q1->fetch_object();
		$q2 = $this->_db->query( "UPDATE ".TP."users SET active='1' WHERE activation_code='$id'");
		
		if($q1->num_rows > 0 && $r->active == 1) {
			redirect(BASE_URL.'register/active');
		} elseif($q1->num_rows <= 0) {
			redirect(BASE_URL.'error/activate');
		} elseif($q2) {
			$this->_cache->purge();
			redirect(BASE_URL.'register/confirm');
		} else {
			redirect(BASE_URL.'error/activate');
		}
	}

}