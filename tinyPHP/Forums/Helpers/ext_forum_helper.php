<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * tinyForum Helper
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
	
	function isUserFieldEmpty($id,$field) {
 		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT * FROM " . TP . "users WHERE user_id = '$id'" );
		$r = $sql->fetch_object();
		if($r->$field == '') {
			return ' style="display:none;"';
		}
 	}
	
	function userPostCount($id) {
 		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT COUNT(post_by) FROM " . TP . "posts WHERE post_by = '$id'" );
		if($sql->num_rows > 0) {
			while( $r = $sql->fetch_array() ) {
				return $r['COUNT(post_by)'];
			}
		}
 	}
	
 	function getUserMeta($id, $field) {
 		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT * FROM " . TP . "users WHERE user_id = '$id'" );
		if($sql->num_rows > 0) {
			while( $r = $sql->fetch_object() ) {
				return $r->$field;
			}
		}
 	}
	
	function getForumMeta($id, $field) {
 		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT * FROM " . TP . "forums WHERE fid = '$id'" );
		if($sql->num_rows > 0) {
			while( $r = $sql->fetch_object() ) {
				return $r->$field;
			}
		}
 	}
	
	function getTopicMeta($id, $field) {
 		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT * FROM " . TP . "topics WHERE topic_id = '$id'" );
		if($sql->num_rows > 0) {
			while( $r = $sql->fetch_object() ) {
				return $r->$field;
			}
		}
 	}
	
	function getPostMeta($id, $field) {
 		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT * FROM " . TP . "topics, " . TP . "posts WHERE topic_id = post_topic AND topic_id = '$id' ORDER BY post_date DESC" );
		if($sql->num_rows > 0) {
			while( $r = $sql->fetch_object() ) {
				return $r->$field;
			}
		} else {
			return false;
		}
 	}
	
	function get_user_avatar($email, $size = 100) {
		$hook = new \tinyPHP\Classes\Libraries\Hooks;
		$avatarsize = getimagesize("http://www.gravatar.com/avatar.php?gravatar_id=".md5($email).'?s=200');
		$avatar = '<img src="http://www.gravatar.com/avatar.php?gravatar_id=' . md5($email).'?s=200' . '" ' . imgResize($avatarsize[1],  $avatarsize[1], $size) . ' />';
		return $hook->apply_filter('user_avatar', $avatar, $email, $size);
	}

	function whoIsOnline() {
		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT COUNT(user_id) FROM " . TP . "users WHERE NOT auth_token = 'NULL' AND NOT auth_token = ''" );
		$r = $sql->fetch_array();
		if($r['COUNT(user_id)'] == 1) {
			return _t( 'There is currently ') . '<a href="#">' . $r['COUNT(user_id)'] . _t( ' User Online' ) . '</a>';
		} else {
			return _t( 'There are currently ') . '<a href="#">' . $r['COUNT(user_id)'] . _t( ' Users Online' ) . '</a>';
		}
	}
	
	function isUserOnline($username) {
		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT username,auth_token FROM " . TP . "users WHERE username = '$username' AND NOT auth_token = 'NULL' AND NOT auth_token = ''" );
		if($sql->num_rows > 0) {
			return '<span class="online">Online</span>';
		} else {
			return '<span class="offline">Offline</span>';
		}
	}
	
	function threadCount() {
		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT COUNT(topic_id) FROM " . TP . "topics" );
		$r = $sql->fetch_array();
		return $r['COUNT(topic_id)'];
	}
	
	function postCount() {
		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT COUNT(post_id) FROM " . TP . "posts" );
		$r = $sql->fetch_array();
		return $r['COUNT(post_id)'];
	}
	
	function memberCount() {
		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT COUNT(user_id) FROM " . TP . "users WHERE active = '1'" );
		$r = $sql->fetch_array();
		return $r['COUNT(user_id)'];
	}
	
	function activeMemberCount() {
		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT COUNT(DISTINCT post_by) FROM ".TP."posts" );
		$r = $sql->fetch_array();
		return $r['COUNT(DISTINCT post_by)'];
	}
	
	function newMember() {
		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT * FROM ".TP."users WHERE regdate >= CURDATE() - INTERVAL 1 WEEK" );
		
		if($sql->num_rows > 0) {
			while($r = $sql->fetch_array()) {
				return '<a href="'.BASE_URL.'index/user/'.$r['user_id'].'">'.$r['username'].'</a>, ';
			}
		} else {
			echo 'None';
		}
	}
	
	function latestForumTopic() {
		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		
		$sql = $db->query( "SELECT * FROM ".TP."topics ORDER BY topic_date DESC LIMIT 1" );
		$r = $sql->fetch_object();
		return '<a href="'.BASE_URL.'index/topic/'.$r->topic_id.'">'.$r->topic_subject.'</a>';
	}

	function tf_hash_password($password) {
		// By default, use the portable hash from phpass
		$hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, FALSE);
	
			return $hasher->HashPassword($password);
	}
	 
	function tf_check_password($password, $hash, $user_id = '') {
		$hook = new \tinyPHP\Classes\Libraries\Hooks;
		// If the hash is still md5...
		if ( strlen($hash) <= 32 ) {
			$check = ( $hash == md5($password) );
			if ( $check && $user_id ) {
				// Rehash using new hash.
				tf_set_password($password, $user_id);
				$hash = tf_hash_password($password);
			}
			return $hook->apply_filter('check_password', $check, $password, $hash, $user_id);
		}
		
		// If the stored hash is longer than an MD5, presume the
		// new style phpass portable hash.
		$hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, FALSE);
		
		$check = $hasher->CheckPassword($password, $hash);
		
			return $hook->apply_filter('check_password', $check, $password, $hash, $user_id);
	}
	 
	function tf_set_password( $password, $user_id ) {
		$db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$db->conn();
		$hash = tf_hash_password($password);
		$db->update( TP . 'users', array( 'password' => $hash ), array( 'user_id', $user_id ));
		
	}
	
	function tf_hash_cookie($cookie) {
		// By default, use the portable hash from phpass
		$hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, TRUE);

			return $hasher->HashPassword($cookie);
	}
	 
	function tf_authenticate_cookie($cookie, $cookiehash, $user_id = '') {

		$hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, TRUE);
		$hook = new \tinyPHP\Classes\Libraries\Hooks;

		$check = $hasher->CheckPassword($cookie, $cookiehash);

			return $hook->apply_filter('authenticate_cookie', $check, $cookie, $cookiehash, $user_id);
	}