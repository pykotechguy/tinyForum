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
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
	}
	
	public function index() {}
	
	public function editSave($data) {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$data = array();
		$data['content'] = $_POST['post_content'];
		$data['pid'] = $_POST['pID'];
		$data['tid'] = $_POST['tID'];
		$this->model->editSave($data);
	}
	
	public function delete($data) {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$data = array();
		$data['post_id'] = $_POST['pID'];
		$data['fid'] = $_POST['fID'];
		$this->model->delete($data);
		redirect(BASE_URL . 'index/category/' . $data['fid']);
	}
	
	/*public function run($data) {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$data = array();
		$data['topic_subject'] = $_POST['topic_subject'];
		$data['topic_date'] = date("Y-m-d H:i:s");
		$data['topic_fid'] = $_POST['topic_fid'];
		$data['topic_by'] = '2';
		$data['post_content'] = $_POST['post_content'];
		$this->model->run($data);
		redirect(BASE_URL . 'index/category/' . $data['topic_fid']);
	}
	
	public function reply($data) {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$data = array();
		$data['post_content'] = $_POST['post_content'];
		$data['post_date'] = date("Y-m-d H:i:s");
		$data['post_topic'] = $_POST['tID'];
		$data['post_by'] = '1';
		$this->model->reply($data);
		redirect(BASE_URL . 'index/topic/' . $data['post_topic']);
	}*/
	
}