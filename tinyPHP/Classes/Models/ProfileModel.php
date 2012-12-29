<?php namespace tinyPHP\Classes\Models;
/**
 *
 * Profile Model
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

class ProfileModel {
	
	private $_db;
	private $_auth;
	private $_cache;
	
	public function __construct() {
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
		$this->_db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->_db->conn();
		
		$this->_cache = new \tinyPHP\Classes\Libraries\Cache('',BASE_PATH.'tmp/cache/','');
	}
	
	public function index() {}
	
	public function profile() {
		$sql = $this->_db->select( TP."users", "*", "username = '".$this->_auth->getUserField('username')."'" );
		if($sql->num_rows > 0) {
			while($row = $sql->fetch_assoc()) {
				$array[] = $row;
			}
			return $array;
		}
	}
	
	public function save($data) {
		if(empty($data['email'])) {
			redirect(BASE_URL . 'error/profile');
		} else {
			$first = $this->_db->escape($data['first_name']);
			$last = $this->_db->escape($data['last_name']);
			$email = $this->_db->escape($data['email']);
			$facebook = $this->_db->escape($data['facebook']);
			$twitter = $this->_db->escape($data['twitter']);
			$googleplus = $this->_db->escape($data['googleplus']);
			$linkedin = $this->_db->escape($data['linkedin']);
			$pass = $this->_db->escape(tf_hash_password($data['password']));
			
			$this->_db->update( TP."users", array(
													'first_name' => $first,
													'last_name' => $last,
													'email' => $email,
													'facebook' => $facebook,
													'twitter' => $twitter,
													'googleplus' => $googleplus,
													'linkedin' => $linkedin
												),
										   array('username',$this->_auth->getUserField('username'))
							);
			$this->_cache->purge();
		
			if(!empty($data['password'])) {
				$this->_db->update( TP."users", array('password' => $pass), array('username',$this->_auth->getUserField('username')));
			}
			redirect(BASE_URL . 'profile/success');
		}
	}

}