<?php namespace tinyPHP\Classes\Core;
/**
 *
 * Form Validator
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

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class Val {
	
	public function __construct() {}
	
	public function minlength($data, $arg) {
		if (strlen($data) < $arg) {
			return "Your string can only be $arg long";
		}
	}
	
	public function maxlength($data, $arg) {
		if (strlen($data) > $arg) {
			return "Your string can only be $arg long";
		}
	}
	
	public function digit($data) {
		if (ctype_digit($data) == false) {
			return "Your string must be a digit";
		}
	}
	
	public function is_valid_username($username) {
		if (preg_match('/^[a-z\d_]{5,20}$/i', $username)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function is_valid_email($email) {
        // First, we check that there's one @ symbol, and that the lengths are right
        if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
            return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
                return false;
            }
        }
        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                    return false;
                }
            }
        }

        return true;
    }
	
	public function is_valid_password($x,$y) {
		if(empty($x) || empty($y) ) { return false; }
			if (strlen($x) < 4 || strlen($y) < 4) { return false; }

		if (strcmp($x,$y) != 0) {
 			return false;
		} 
			return true;
	}
	
	public function generate_user_password($length = 10) {
  		$password = "";
  		$possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels
  
  			$i = 0; 
    
  				while ($i < $length) { 
    				$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
    				if (!strstr($password, $char)) { 
      					$password .= $char;
      				$i++;
    			}

  		}

  		return $password;
	}
	
	public function __call($name, $arguments) {
		throw new \Exception("$name does not exist inside of: " . __CLASS__);
	}
	
}