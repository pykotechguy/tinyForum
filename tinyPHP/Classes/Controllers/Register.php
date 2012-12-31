<?php namespace tinyPHP\Classes\Controllers;
/**
 *
 * Register Controller
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

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class Register extends \tinyPHP\Classes\Core\Controller {
	
	private $_auth;

	public function __construct() {
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
		if($this->_auth->isUserLoggedIn()) { redirect(BASE_URL); }
		parent::__construct();
		ob_start();
	}
	
	public function active() {
		$this->view->staticTitle = array('Account Already Active');
		$this->view->render('header/index',true);
		$this->view->render('register/active',true);
		$this->view->render('footer/index',true);
	}
	
	public function confirm() {
		$this->view->staticTitle = array('Activate Account Confirmation');
		$this->view->render('header/index',true);
		$this->view->render('register/confirm',true);
		$this->view->render('footer/index',true);
	}
	
	public function index() {
		$this->view->staticTitle = array('Register');
		$this->view->render('header/index',true);
		$this->view->render('register/index',true);
		$this->view->render('footer/index',true);
	}
	
	public function success() {
		$this->view->staticTitle = array('Registration Successful');
		$this->view->render('header/index',true);
		$this->view->render('register/success',true);
		$this->view->render('footer/index',true);
	}
	
	public function run() {
		$data = array();
		$data['md5'] = md5($_POST['username']);
		$data['username'] = $_POST['username'];
		$data['password'] = $_POST['password'];
		$data['email'] = $_POST['email'];
		$data['regdate'] = date('Y-m-d H:i:s');
		$data['activation_code'] = rand(1000,9999);
		$this->model->save($data);
	}
	
	public function activate($id) {
		$this->model->activate($id);
	}
}