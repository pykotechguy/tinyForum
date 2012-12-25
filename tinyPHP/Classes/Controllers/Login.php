<?php namespace tinyPHP\Classes\Controllers;
/**
 *
 * Login Controller
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

class Login extends \tinyPHP\Classes\Core\Controller {
	
	private $_auth;

	public function __construct() {
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
		if($this->_auth->isUserLoggedIn() == true) {
			redirect(BASE_URL);
		}
		parent::__construct();
		ob_start();
	}
	
	public function index() {
		$this->view->render('login/index');
	}
	
	public function success() {
		$this->view->render('login/success');
	}
	
	public function run($data) {
		$data = array();
		$data['username'] = $_POST['username'];
		$data['password'] = $_POST['password'];
		$data['remember'] = isset($_POST['remember']);
		$this->model->run($data);
	}
}