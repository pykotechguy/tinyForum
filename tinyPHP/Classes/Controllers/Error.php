<?php namespace tinyPHP\Classes\Controllers;
/**
 *
 * Error Controller
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

if ( ! defined('BASE_PATH')) exit('No direct script access allowed');

class Error extends \tinyPHP\Classes\Core\Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function category() {
		$this->view->render('error/category');
	}
	
	public function index() {
		$this->view->render('error/index');
	}
	
	public function login() {
		$this->view->render('error/login');
	}
	
	public function post() {
		$this->view->render('error/post');
	}
	
	public function profile() {
		$this->view->render('error/profile');
	}
	
	public function register() {
		$this->view->render('error/register');
	}
	
	public function reply() {
		$this->view->render('error/reply');
	}
	
	public function settings() {
		$this->view->render('error/settings');
	}
	
	public function topic() {
		$this->view->render('error/topic');
	}
	
	public function user() {
		$this->view->render('error/user');
	}

}