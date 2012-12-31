<?php namespace tinyPHP\Classes\Controllers;
/**
 *
 * Login Controller
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

class Login extends \tinyPHP\Classes\Core\Controller {
	
	private $_auth;

	public function __construct() {
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
		if($this->_auth->isUserLoggedIn()) { redirect(BASE_URL); }
		parent::__construct();
		ob_start();
	}
	
	public function confirm() {
		$this->view->staticTitle = array('Password Reset Confirmation');
		$this->view->render('header/index',true);
		$this->view->render('login/confirm',true);
		$this->view->render('footer/index',true);
	}
	
	public function index() {
		$this->view->staticTitle = array('Login');
		$this->view->render('header/index',true);
		$this->view->render('login/index',true);
		$this->view->render('footer/index',true);
	}
	
	public function forgot() {
		$this->view->staticTitle = array('Reset Password');
		$this->view->render('header/index',true);
		$this->view->render('login/forgot',true);
		$this->view->render('footer/index',true);
	}
	
	public function success() {
		$this->view->staticTitle = array('Login Success');
		$this->view->render('header/index',true);
		$this->view->render('login/success',true);
		$this->view->render('header/index',true);
	}
	
	public function run() {
		$data = array();
		$data['username'] = $_POST['username'];
		$data['password'] = $_POST['password'];
		$data['remember'] = isset($_POST['remember']);
		$this->model->run($data);
	}
	
	public function resetPass() {
		$data = array();
		$data['email'] = $_POST['email'];
		$this->model->resetPass($data);
	}
}