<?php namespace tinyPHP\Classes\Models;
/**
 *
 * Topic Model
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

class TopicModel {
	
	private $_db;
	private $_auth;
	private $_cache;
	
	public function __construct() {
		$this->_db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->_db->conn();
		
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
		$this->_cache = new \tinyPHP\Classes\Libraries\Cache('',BASE_PATH.'tmp/cache/','');
	}
	
	public function index() {}
	
	public function listCats() {
		$q1 = $this->_db->query( "SELECT * FROM " . TP . "forums WHERE permission = 'Y' ORDER BY sort" );
		$q2 = $this->_db->query( "SELECT * FROM " . TP . "forums ORDER BY sort" );
		if($q1->num_rows > 0) {
			if($this->_auth->getUserField('role') != 'Administrator') {
				while($r = $q1->fetch_assoc()) {
					$array[] = $r;
				}
				return $array;
			} else {
				while($r = $q2->fetch_assoc()) {
					$array[] = $r;
				}
				return $array;
			}
		}
	}
	
	public function singleTopic($id) {
		$q = $this->_db->query( "SELECT * FROM ".TP."topics, ".TP."posts WHERE topic_id = '$id' AND topic_id = post_topic LIMIT 1" );
		if($q->num_rows > 0) {
			while($r = $q->fetch_assoc()) {
				$array[] = $r;
			}
			return $array;
		}
	}
	
	public function run($data) {
		if(empty($data['topic_subject']) || empty($data['topic_fid']) || empty($data['post_content'])) {
			redirect(BASE_URL . 'error/topic');
		} else {
			$topicsub = $this->_db->escape( $data['topic_subject'] );
			$topicdate = $this->_db->escape( $data['topic_date'] );
			$topicfid = $this->_db->escape( (int)$data['topic_fid'] );
			$topicby = $this->_db->escape( (int)$data['topic_by'] );
			$content = $this->_db->escape( $data['post_content'] );
			
			$this->_db->insert( TP . "topics", 
						array(
								$topicsub,
								$topicdate,
								$topicfid,
								$topicby
							 ),
								"topic_subject,
								topic_date,
								topic_fid,
								topic_by"
							 );
			$this->_db->insert( TP . "posts", 
						array(
								$content,
								$topicdate,
								$this->_db->insert_id(),
								$topicby
							 ),
								"post_content,
								post_date,
								post_topic,
								post_by"
							 );
			$this->_cache->purge();
			redirect(BASE_URL . 'topic/success');
		}
	}
	
	public function reply($data) {
		if(empty($data['post_content']) || empty($data['post_topic']) || empty($data['post_by'])) {
			redirect(BASE_URL . 'error/reply');
		} else {
			$post = $this->_db->escape( $data['post_content'] );
			$date = $this->_db->escape( $data['post_date'] );
			$topic = $this->_db->escape( (int)$data['post_topic'] );
			$user = $this->_db->escape( (int)$data['post_by'] );
			
			$this->_db->insert( TP . "posts",
						array(
								$post,
								$date,
								$topic,
								$user
							 ),
								"post_content,
								post_date,
								post_topic,
								post_by"
							);
			$this->_cache->purge();
			redirect(BASE_URL . 'index/topic/'. $data['post_topic']);
		}
	}
	
	public function editSave($data) {
		if(empty($data['subject']) || empty($data['content'])) {
			redirect(BASE_URL . 'error/topic');
		} else {
			$subject = $this->_db->escape($data['subject']);
			$fID = $this->_db->escape((int)$data['fid']);
			$content = $this->_db->escape($data['content']);
			$tID = $this->_db->escape((int)$data['id']);
			$pID = $this->_db->escape((int)$data['pid']);
			
			$this->_db->query( "UPDATE ".TP."topics SET topic_subject='$subject' WHERE topic_fid = '$fID' AND topic_id = '$tID'" );
			$this->_db->query( "UPDATE ".TP."posts SET post_content='$content' WHERE post_topic = '$tID' AND post_id = '$pID'" );
			
			$this->_cache->purge();
			redirect(BASE_URL . 'index/topic/' . $data['id']);
		}
	}
	
	public function delete($data) {
		$tID = $data['tid'];
		$fID = $data['fid'];
		$this->_db->query( "DELETE FROM ".TP."topics WHERE topic_id = '$tID' AND topic_fid = '$fID' AND topic_by = '".$this->_auth->getUserField('user_id')."'" );
		
		$this->_cache->purge();
	}
	
	public function __destruct() {
		$this->_db->disconnect();
	}

}