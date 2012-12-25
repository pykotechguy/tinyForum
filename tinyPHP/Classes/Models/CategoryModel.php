<?php namespace tinyPHP\Classes\Models;
/**
 *
 * Catagory Model
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

class CategoryModel {
	
	private $_db;
	private $_cache;
	
	public function __construct() {
		$this->_db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->_db->conn();
		
		$this->_cache = new \tinyPHP\Classes\Libraries\Cache('',BASE_PATH.'tmp/cache/','');
	}
	
	public function run($data) {
		if(empty($data['name']) || empty($data['description']) || empty($data['permission'])) {
			redirect(BASE_URL . 'error/category');
		} else {
			$permission = $this->_db->escape( $data['permission'] );
			$name = $this->_db->escape( $data['name'] );
			$description = $this->_db->escape( $data['description'] );
			$sort = $this->_db->escape( (int)$data['sort'] );
			
			$this->_db->insert( TP . "forums",
						array(
								$permission,
								$name,
								$description,
								$sort
							 ),
							 	"permission,
							 	name,
							 	description,
							 	sort"
							 );
			$this->_cache->purge();
			redirect(BASE_URL . 'category/success');
		}
	}
	
	public function forum($id) {
		$q = $this->_db->select( TP."forums", "*", "fid = '".$id."'", null);
		if($q->num_rows > 0) {
			while($r = $q->fetch_assoc()) {
				$array[] = $r;
			}
			return $array;
		}
	}
	
	public function editSave($data) {
		if(empty($data['name']) || empty($data['description']) || empty($data['permission'])) {
			redirect(BASE_URL . 'error/category');
		} else {
			$permission = $this->_db->escape( $data['permission'] );
			$name = $this->_db->escape( $data['name'] );
			$description = $this->_db->escape( $data['description'] );
			$sort = $this->_db->escape( (int)$data['sort'] );
			$fid = $data['fid'];
			
			$this->_db->update( TP . "forums",
						array(
								'permission' => $permission,
								'name' => $name,
								'description' => $description,
								'sort' => $sort
							 ),
						array(
								"fid",
								$fid
							 )
							 );
			$this->_cache->purge();
			redirect(BASE_URL . 'category/success');
		}
	}
	
	public function __destruct() {
		$this->_db->disconnect();
	}

	
}