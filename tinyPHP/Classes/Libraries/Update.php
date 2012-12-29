<?php namespace tinyPHP\Classes\Libraries;
/**
 *
 * tinyForum Update Class
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

if ( ! defined('BASE_PATH')) exit('No direct script access allowed');

class Update {
	
	private $_hook;
	private $_auth;
	
	public function __construct() {
		$this->_hook = new \tinyPHP\Classes\Libraries\Hooks();
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
	}
	
	/**
	 * Contacts the main server, reads the variables and returns 
	 * an update message if returns true
	 * 
	 * @param array $array Reads the values in a file.
	 * @return bool
	 */
	public function upgrade($array) {
		$upgrade = explode("\n", file_get_contents('http://www.7mediaws.org/tf-variables.txt'));
		$upgrade = $this->_hook->apply_filter('upgrade', $upgrade[$array]);
		return $upgrade;
	}
	
	// Prints an update message if the installed version is less than the current version.
	public function showUpdateMessage() {
		$update = 'tinyForum <a href="https://github.com/7mediaws/tinyForum">'.$this->upgrade(0).'</a> is now available for download. Make sure to read the <a href="https://github.com/7mediaws/tinyForum/wiki/Changelog">changelog</a> before upgrading.';
		$update = $this->_hook->apply_filter('update_message',$update);
		return $update;
	}
  
}