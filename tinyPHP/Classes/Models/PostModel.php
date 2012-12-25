<?php namespace tinyPHP\Classes\Models;
/**
 *
 * Post Model
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

class PostModel {
	
	private $_db;
	private $_cache;
	private $_auth;
	
	public function __construct() {
		$this->_db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->_db->conn();
		
		$this->_cache = new \tinyPHP\Classes\Libraries\Cache('',BASE_PATH.'tmp/cache/','');
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
	}
	
	public function index() {}
	
	public function editSave($data) {
		if(empty($data['content']) || empty($data['pid']) || empty($data['tid'])) {
			redirect(BASE_URL . 'error/post');
		} else {
			$content = $this->_db->escape($data['content']);
			$pID = $this->_db->escape((int)$data['pid']);
			$tID = $this->_db->escape((int)$data['tid']);
			
			$this->_db->query( "UPDATE ".TP."posts SET post_content='$content' WHERE post_id = '$pID' AND post_topic = '$tID'" );
			
			$this->_cache->purge();
			redirect(BASE_URL . 'index/topic/' . $data['tid']);
		}
	}
	
	public function delete($data) {
		$id = $this->_db->escape((int)$data['post_id']);
		$this->_db->query( "DELETE FROM ".TP."posts WHERE post_id = '$id' AND post_by = '".$this->_auth->getUserField('user_id')."'" );
		
		$this->_cache->purge();
	}
	
	public function __destruct() {
		$this->_db->disconnect();
	}

}