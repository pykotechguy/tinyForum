<?php namespace tinyPHP\Classes\Controllers;
/**
 *
 * Index Controller
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

use \tinyPHP\Classes\Libraries\Cookies as Auth;
class Index extends \tinyPHP\Classes\Core\Controller {
	
	private $_auth;

	public function __construct() {
		$this->_auth = new Auth;
		parent::__construct();
		ob_start();
	}
	
	public function index() {
		$this->view->getCatTopic = $this->model->getCatTopic();
		$this->view->render('index/index');
	}
	
	public function category($id) {
		$this->view->curForum = $this->model->currentForum($id);
		$this->view->catBread = $this->model->catBread($id);
		$this->view->category = $this->model->category($id);
		$this->view->js = array('jquery.pajinate.js');
		$this->view->render('category/index');
	}
	
	public function topic($id) {
		$this->view->topic = $this->model->topic($id);
		$this->view->topicBread = $this->model->topicBread($id);
		$this->view->title = $this->model->topicTitle($id);
		$this->view->css = array('markitup/skins/markitup/style.css','markitup/sets/html/style.css');
		$this->view->js = array('markitup/jquery.markitup.js','markitup/sets/html/set.js','jquery.pajinate.js');
		$this->view->render('topic/index');
	}
	
	public function post($id) {
		$this->view->post = $this->model->getPost($id);
		$this->view->css = array('markitup/skins/markitup/style.css','markitup/sets/html/style.css');
		$this->view->js = array('markitup/jquery.markitup.js','markitup/sets/html/set.js');
		$this->view->render('post/index');
	}
	
	public function user($id) {
		if(!$this->_auth->isUserLoggedIn()) { redirect(BASE_URL. 'error/user'); }
		
		$this->view->user = $this->model->user($id);
		$this->view->render('user/index');
	}
	
	public function logout() {
		$this->_auth->logout();
	}
	
}