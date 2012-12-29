<?php namespace tinyPHP\Classes\Models;
/**
 *
 * Settings Model
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

class SettingsModel {
	
	private $_db;
	private $_hook;
	private $_cache;
	
	public function __construct() {
		$this->_db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->_db->conn();
		$this->_hook = new \tinyPHP\Classes\Libraries\Hooks();
		$this->_cache = new \tinyPHP\Classes\Libraries\Cache('',BASE_PATH.'tmp/cache/','');
	}
	
	public function index() {}
	
	public function save($options) {
		if(empty($_POST['admin_email'])) {
			redirect(BASE_URL . 'error/settings');
		} else {
			foreach ( $options as $option_name ) {
				if ( ! isset($_POST[$option_name]) )
					continue;
				$value = $this->_db->escape( $_POST[$option_name] );
				$this->_hook->update_option( $option_name, $value );
			}
			// Update more options here
			$this->_hook->do_action( 'update_options' );
			
			$this->_cache->purge();
			redirect(BASE_URL . 'settings/success');
		}
	}
	
	public function __destruct() {
		$this->_db->disconnect();
	}

	
}