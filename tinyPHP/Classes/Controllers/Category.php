<?php namespace tinyPHP\Classes\Controllers;
/**
 *
 * Category Controller
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

if ( ! defined('BASE_PATH')) exit('No direct script access allowed');

class Category extends \tinyPHP\Classes\Core\Controller {
	
	private $_auth;

	public function __construct() {
		parent::__construct();
		ob_start();
		
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
	}
	
	public function index() {}
	
	public function success() {
		$this->view->render('category/success');
	}
	
	public function create() {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$this->view->css = array('markitup/skins/markitup/style.css','markitup/sets/html/style.css');
		$this->view->js = array('markitup/jquery.markitup.js','markitup/sets/html/set.js');
		$this->view->render('category/create');
	}
	
	public function run() {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$data = array();
		$data['permission'] = $_POST['permission'];
		$data['name'] = $_POST['name'];
		$data['description'] = $_POST['description'];
		$data['sort'] = $_POST['sort'];
		$this->model->run($data);
	}
	
	public function edit($id) {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$this->view->css = array('markitup/skins/markitup/style.css','markitup/sets/html/style.css');
		$this->view->js = array('markitup/jquery.markitup.js','markitup/sets/html/set.js');
		$this->view->forum = $this->model->forum($id);
		$this->view->render('category/edit');
	}
	
	public function editSave() {
		if($this->_auth->isUserLoggedIn() != true) {
			redirect(BASE_URL);
		}
		$data = array();
		$data['permission'] = $_POST['permission'];
		$data['name'] = $_POST['name'];
		$data['description'] = $_POST['description'];
		$data['sort'] = $_POST['sort'];
		$data['fid'] = $_POST['fID'];
		$this->model->editSave($data);
	}
	
}