<?php namespace tinyPHP\Classes\Controllers;
/**
 *
 * Settings Controller
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

class Settings extends \tinyPHP\Classes\Core\Controller {
	
	private $_auth;

	public function __construct() {
		parent::__construct();
		ob_start();
		
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
		if($this->_auth->getUserField('role') != 'Administrator') {
			redirect(BASE_URL);
		}
	}
	
	public function index() {
		$this->view->render('settings/index');
	}
	
	public function success() {
		$this->view->render('settings/success');
	}
	
	public function save($options) {
		$options = array( 
							'admin_email',
							'forum_name',
							'thcount',
							'ptcount',
							'cookieexpire',
							'cookiepath',
							'cache',
							'facebook',
							'flickr',
							'googleplus',
							'twitter',
							'vimeo'
						);
		$this->model->save($options);
	}
}