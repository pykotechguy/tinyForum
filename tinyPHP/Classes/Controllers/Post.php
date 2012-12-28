<?php namespace tinyPHP\Classes\Controllers;
/**
 *
 * Post Controller
 *  
 * PHP 5
 *
 * tinyForum(tm) : Simple & Lightweight Forum (http://tinyphp.us/downloads/tinyForum/)
 * Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 * @link http://tinyphp.us/downloads/tinyForum/ tinyForum(tm) Project
 * @since tinyForum(tm) v 0.1
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class Post extends \tinyPHP\Classes\Core\Controller {
	
	private $_auth;

	public function __construct() {
		parent::__construct();
		ob_start();
		
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
		
		if(!$this->_auth->isUserLoggedIn()) { redirect(BASE_URL); }
	}
	
	public function index() {}
	
	public function editSave() {
		if(!$this->_auth->isUserLoggedIn()) { redirect(BASE_URL); }
		
		$data = array();
		$data['content'] = $_POST['post_content'];
		$data['pid'] = $_POST['pID'];
		$data['tid'] = $_POST['tID'];
		$this->model->editSave($data);
	}
	
	public function delete() {
		if(!$this->_auth->isUserLoggedIn()) { redirect(BASE_URL); }
		
		$data = array();
		$data['post_id'] = $_POST['pID'];
		$data['fid'] = $_POST['fID'];
		$this->model->delete($data);
		redirect(BASE_URL . 'index/category/' . $data['fid']);
	}
	
}