<?php namespace tinyPHP\Classes\Controllers;
/**
 *
 * Error Controller
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

class Error extends \tinyPHP\Classes\Core\Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function category() {
		$this->view->staticTitle = array('Forum Error');
		$this->view->render('header/index',true);
		$this->view->render('error/category',true);
		$this->view->render('footer/index',true);
	}
	
	public function index() {
		$this->view->staticTitle = array('404 Error');
		$this->view->render('header/index',true);
		$this->view->render('error/index',true);
		$this->view->render('footer/index',true);
	}
	
	public function login() {
		$this->view->staticTitle = array('Login Error');
		$this->view->render('header/index',true);
		$this->view->render('error/login',true);
		$this->view->render('footer/index',true);
	}
	
	public function post() {
		$this->view->staticTitle = array('Post Error');
		$this->view->render('header/index',true);
		$this->view->render('error/post',true);
		$this->view->render('footer/index',true);
	}
	
	public function profile() {
		$this->view->staticTitle = array('Profile Error');
		$this->view->render('header/index',true);
		$this->view->render('error/profile',true);
		$this->view->render('footer/index',true);
	}
	
	public function register() {
		$this->view->staticTitle = array('Register Error');
		$this->view->render('header/index',true);
		$this->view->render('error/register',true);
		$this->view->render('footer/index',true);
	}
	
	public function reply() {
		$this->view->staticTitle = array('Reply Error');
		$this->view->render('header/index',true);
		$this->view->render('error/reply',true);
		$this->view->render('footer/index',true);
	}
	
	public function settings() {
		$this->view->staticTitle = array('Settings Error');
		$this->view->render('header/index',true);
		$this->view->render('error/settings',true);
		$this->view->render('footer/index',true);
	}
	
	public function topic() {
		$this->view->staticTitle = array('Topic Error');
		$this->view->render('header/index',true);
		$this->view->render('error/topic',true);
		$this->view->render('footer/index',true);
	}
	
	public function user() {
		$this->view->staticTitle = array('User Error');
		$this->view->render('header/index',true);
		$this->view->render('error/user',true);
		$this->view->render('footer/index',true);
	}

}