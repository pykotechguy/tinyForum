<?php namespace tinyPHP\Classes\Models;
/**
 *
 * User Model
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

if ( ! defined('BASE_PATH')) exit('No direct script access allowed');

class IndexModel {
	
	private $_db;
	
	public function __construct() {
		$this->_db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->_db->conn();
	}
	
	public function index() {}
	
	public function getCatTopic() {
		$sql = $this->_db->query( "SELECT 
								fid,
								name,
								description,
								sort,
								COUNT(topic_id),
								MIN(topic_subject) AS topic_subject,
								MAX(topic_id) AS topic_id,
								topic_fid,
								MAX(topic_date) AS topic_date,
								topic_by 
							FROM ".
								TP."forums 
							LEFT JOIN ".
								TP."topics 
							ON
								fid = topic_fid 
							GROUP BY 
								name,description,fid 
							ORDER BY 
								sort ASC" );
		if($sql->num_rows > 0) {
			while($row = $sql->fetch_assoc()) {
				$array[] = $row;
			}
			return $array;
		}
	}
	
	/*public function category($id) {
		$sql = $this->_db->query( "SELECT * " .
						  		 "FROM ".TP."topics " . 
						  		 "WHERE topic_cat = '$id' ORDER BY topic_date DESC" );
		if($sql->num_rows > 0) {
			while($row = $sql->fetch_assoc()) {
				$array[] = $row;
			}
			return $array;
		}
	}*/
	
	public function category($id) {
		$sql = $this->_db->query( "SELECT 
									topic_id,
									topic_subject,
									topic_date,
									topic_fid,
									topic_by,
									fid,
									name,
									description,
									user_id,
									username,
									regdate 
								FROM ".
									TP."topics 
								LEFT JOIN ".
									TP."forums 
								ON 
									topic_fid = fid 
								LEFT JOIN ".
									TP."users 
								ON 
									topic_by = user_id 
								WHERE 
									topic_fid = '$id' 
								ORDER BY 
									topic_date 
								DESC " );
		if($sql->num_rows > 0) {
			while($row = $sql->fetch_assoc()) {
				$array[] = $row;
			}
			return $array;
		}
	}
	
	public function catBread($id) {
		$sql = $this->_db->query( "SELECT 
									topic_id,
									topic_fid,
									fid,
									name 
								FROM ".
									TP."topics 
								LEFT JOIN ".
									TP."forums 
								ON 
									topic_fid = fid 
								WHERE 
									topic_fid = '$id' LIMIT 1" );
		if($sql->num_rows > 0) {
			while($row = $sql->fetch_assoc()) {
				$array[] = $row;
			}
			return $array;
		}
	}
	
	public function currentForum($id) {
		$sql = $this->_db->query( "SELECT * 
						  	FROM ".
						  		TP."topics, ".
						  		TP."forums, ".
						  		TP."users, ".
						  		TP."posts 
						  	WHERE 
						  		topic_fid = fid 
						  	AND 
						  		topic_fid = '$id' 
						  	AND 
						  		user_id = post_by 
						  	AND 
						  		user_id = topic_by 
						  	ORDER BY 
						  		topic_date 
						  	DESC 
						  	LIMIT 
						  		1" );
		if($sql->num_rows > 0) {
			while($row = $sql->fetch_assoc()) {
				$array[] = $row;
			}
			return $array;
		}
	}
	
	public function topic($id) {
		$sql = $this->_db->query( "SELECT 
								post_id,
								post_topic,
								post_content,
								post_date,
								post_by,
								user_id,
								username,
								facebook,
								twitter,
								googleplus,
								linkedin,
								role,
								regdate,
								topic_id,
								topic_subject,
								topic_fid 
							FROM ".
								TP."posts 
							LEFT JOIN ".
								TP."users 
							ON 
								post_by = user_id 
							LEFT JOIN " .
								TP."topics 
							ON
								post_topic = topic_id 
							WHERE 
								post_topic = '$id'" );
		if($sql->num_rows > 0) {
			while($row = $sql->fetch_assoc()) {
				$array[] = $row;
			}
			return $array;
		}
	}
	
	public function topicBread($id) {
		$sql = $this->_db->query( "SELECT 
								post_id,
								post_topic,
								topic_id,
								topic_subject,
								topic_fid 
							FROM ".
								TP."posts 
							LEFT JOIN " .
								TP."topics 
							ON
								post_topic = topic_id 
							WHERE 
								post_topic = '$id' LIMIT 1" );
		if($sql->num_rows > 0) {
			while($row = $sql->fetch_assoc()) {
				$array[] = $row;
			}
			return $array;
		}
	}
	
	public function topicTitle($id) {
		$sql = $this->_db->query( "SELECT 
								post_id,
								post_topic,
								topic_id, 
								topic_subject 
							FROM ".
								TP."posts 
							LEFT JOIN " .
								TP."topics 
							ON 
								post_topic = topic_id 
							WHERE 
								post_topic = '$id' LIMIT 1" );
		if($sql->num_rows > 0) {
			while($row = $sql->fetch_assoc()) {
				$array[] = $row;
			}
			return $array;
		}
	}
	
	public function user($id) {
		$q = $this->_db->select( TP."users","*","user_id = '$id'" );
		if($q->num_rows > 0) {
			while($r = $q->fetch_assoc()) {
				$array[] = $r;
			}
			return $array;
		}
	}
	
	public function getPost($id) {
		$q = $this->_db->query( "SELECT * FROM " . TP . "posts WHERE post_id = '$id'" );
		if($q->num_rows > 0) {
			while($r = $q->fetch_assoc()) {
				$array[] = $r;
			}
			return $array;
		}
	}
	
	public function __destruct() {
		$this->_db->disconnect();
	}

	
}