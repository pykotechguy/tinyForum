<?php namespace tinyPHP\Classes\Controllers;
/**
 *
 * Topic Controller
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

class Topic extends \tinyPHP\Classes\Core\Controller {
	
	private $_auth;

	public function __construct() {
		parent::__construct();
		ob_start();
		
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
	}
	
	public function index() {}
	
	public function success() {
		$this->view->render('topic/success');
	}
	
	public function create() {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$this->view->cats = $this->model->listCats();
		$this->view->css = array('markitup/skins/markitup/style.css','markitup/sets/html/style.css');
		$this->view->js = array('markitup/jquery.markitup.js','markitup/sets/html/set.js');
		$this->view->render('topic/create');
	}
	
	public function edit($id) {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$this->view->cats = $this->model->listCats();
		$this->view->editTopic = $this->model->singleTopic($id);
		$this->view->css = array('markitup/skins/markitup/style.css','markitup/sets/html/style.css');
		$this->view->js = array('markitup/jquery.markitup.js','markitup/sets/html/set.js');
		$this->view->render('topic/edit');
	}
	
	public function run() {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$data = array();
		$data['topic_subject'] = $_POST['topic_subject'];
		$data['topic_date'] = date("Y-m-d H:i:s");
		$data['topic_fid'] = $_POST['topic_fid'];
		$data['topic_by'] = $this->_auth->getUserField('user_id');
		$data['post_content'] = $_POST['post_content'];
		$this->model->run($data);
	}
	
	public function reply() {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$data = array();
		$data['post_content'] = $_POST['post_content'];
		$data['post_date'] = date("Y-m-d H:i:s");
		$data['post_topic'] = $_POST['tID'];
		$data['post_by'] = $this->_auth->getUserField('user_id');
		$this->model->reply($data);
	}
	
	public function editSave() {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$data = array();
		$data['subject'] = $_POST['topic_subject'];
		$data['content'] = $_POST['post_content'];
		$data['id'] = $_POST['tID'];
		$data['fid'] = $_POST['fID'];
		$data['pid'] = $_POST['pID'];
		$this->model->editSave($data);
	}

	public function delete() {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$data = array();
		$data['tid'] = $_POST['tID'];
		$data['fid'] = $_POST['fID'];
		$this->model->delete($data);
		redirect(BASE_URL);
	}
	
}