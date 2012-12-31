<?php namespace tinyPHP\Classes\Libraries;
/**
 * @package MegaCache Class
 * @author parkerj
 * @version 1.0
 *
*/

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class Cache {
	
	/**
	 * The path to the cache file folder
	 *
	 * @var string
	 */
	private $_cachepath = 'cache/';
	
	/**
	 * The key name of the cache file
	 *
	 * @var string
	 */
	private $_cachename = 'default';
	
	/**
	 * The cache file extension
	 *
	 * @var string
	 */
	private $_extension = '.cache';
	
	/**
	 * Time to live for cache file
	 *
	 * @var int
	 */
	private $_setTTL = '3600';
	
	/**
	 * Full location of cache file
	 *
	 * @var string
	 */
	private $_cachefile;
	
	/**
	 * Execution Time
	 *
	 * @var float
	 */
	private $_starttime;
	
	/**
	 * Logs errors that may occur
	 *
	 * @var float
	 */
	private $_log;
	
	public function __construct($expire='', $path='', $name='') {
		$this->_setTTL = $expire;
		$this->_cachepath = $path;
		$this->_cachename = $name;
		
		if(!is_dir($this->_cachepath) || !is_writeable($this->_cachepath)) mkdir($this->_cachepath, 0755);
		
		$this->_cachefile = $this->_cachepath . $this->_cachename . $this->_extension;
		
		$mtime = microtime();
   		$mtime = explode(" ",$mtime);
   		$mtime = $mtime[1] + $mtime[0];
   		$this->_starttime = $mtime;
	}
	
	/**
	 * Sets objects that should be cached.
	 * 
	 * @param string (required) $key Prefix of the cache file
	 * @param mixed (required) $data The object that should be cached
	 * @return mixed
	 */
	public function set($key, $data) {
		$values = serialize($data);
		$cachefile = $this->_cachepath . $key . $this->_extension;
		$cache = fopen($cachefile, 'w');
		if($cache) {
			fwrite($cache, $values);
			fclose($cache);
		} else {
			return $this->addLog( 'Unable to write key: ' . $key . ' file: ' . $cachefile );
		}
	}
	
	/**
	 * Cached data by its Prefix
	 * 
	 * @param string (required) $key Returns cached objects by its key.
	 * @return mixed
	 */
	public function get($key) {
		$cachefile = $this->_cachepath . $key . $this->_extension;
		$file = fopen($cachefile, 'r');
		if (filemtime($cachefile) < (time() - $this->_setTTL)) {  
            $this->clearCache($key);  
            return false;  
        }  
		if($file) {
			$data = fread($file, filesize($cachefile));
		    fclose($file);
		    return unserialize($data);
		}
	}
	
	/**
	 * Begins the section where caching begins
	 * 
	 * @return mixed
	 */
	public function setCache($cache = 'Yes') {
		if($cache == 'Yes') :
			if(!$this->isCacheValid($this->_cachefile)) {
				ob_start();
				return $this->addLog( 'Could not find valid cachefile: ' . $this->_cachefile );
	    	} else {
	    		return true;
	    	}
		endif;
	}
	
	/**
	 * Ends the section where caching stops and returns 
	 * the cached file.
	 * 
	 * @return mixed
	 */
	public function getCache($cache = 'Yes') {
		$mtime = microtime();
   		$mtime = explode(" ",$mtime);
   		$mtime = $mtime[1] + $mtime[0];
   		$endtime = $mtime;
   		$totaltime = ($endtime - $this->_starttime);
		if($cache == 'Yes') :
			if(!$this->isCacheValid($this->_cachefile)) {
				$output = ob_get_contents();
				$output .= "<!-- This MegaCache file was built for ( " . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . " ) in " . $totaltime . " seconds, on " . gmdate("M d, Y") . " @ " . gmdate("H:i:s A") . " UTC. -->";
				ob_end_clean();
				$this->writeCache($output, $this->_cachefile);
			} else {
				$output = $this->readCache($this->_cachefile);
			}
			return $output;
		endif;
	}
	
	/**
	 * Reads a cache file if it exists and prints it out 
	 * to the screen.
	 * 
	 * @param string (required) $filename Full path to the requested cache file
	 * @return mixed
	 */
	public function readCache($filename) {
		if ( file_exists($filename) ) {
			$cache = fopen($filename, 'r');
			$output = fread($cache, filesize($filename));
			fclose($cache);
			return unserialize($output) . "\n" . $this->pageLoad();
		} else {
			return $this->addLog( 'Could not find filename: ' . $filename );
		}
	}
	
	/**
	 * Writes cache data to be read
	 * 
	 * @param string (required) $data Data that should be cached
	 * @param string (required) $filename Name of the cache file
	 * @return mixed
	 */
	public function writeCache($data, $filename) {
		$fp = fopen($filename, 'w');
		if($fp) {
			$values = serialize($data);
	    	fwrite($fp, $values);
	    	fclose($fp);
		} else {
			return $this->addLog( 'Could not read filename: ' . $filename . ' data: ' . $data );
		}
	}
	
	/**
	 * Checks if a cache file is valid
	 * 
	 * @param string (required) $filename Name of the cache file
	 * @return mixed
	 */
	public function isCacheValid($filename) {
		if(file_exists($filename) && (filemtime($filename) > (time() - $this->_setTTL))){
			return true;
		}else{
			return $this->addLog( 'Could not find filename: ' . $filename );	
		}
	}
	
	/**
	 * Execution time of the cached page
	 * 
	 * @return mixed
	 */
	public function pageLoad() {
		$mtime = microtime();
   		$mtime = explode(" ",$mtime);
   		$mtime = $mtime[1] + $mtime[0];
   		$endtime = $mtime;
   		$totaltime = ($endtime - $this->_starttime);
   		return "<!-- MegaCache if fully functional. A MegaCache file was just served for ( " . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . " ) in " . $totaltime . " seconds, on " . gmdate("M d, Y") . " @ " . gmdate("H:i:s A") . " UTC. -->"."\n"; 
	}
	
	/**
	 * Clears the cache base on cache file name/key
	 * 
	 * @param string (required) $filename Key name of cache
	 * @return mixed
	 */
	public function clearCache($filename) {
		$cachelog = $this->_cachepath . $filename . $this->_extension;
		if(file_exists($cachelog)) {
			unlink($cachelog);
		}
	}
	
	/**
	 * Clears all cache files
	 * 
	 * @return mixed
	 */
	public function purge() {
		foreach(glob($this->_cachepath . '*.cache') as $file) {
			unlink($file);
		}
	}
	
	/**
	 * Prints a log if error occurs
	 * 
	 * @param mixed (required) $value Message that should be returned
	 * @return mixed
	 */
	public function addLog($value) {
		$this->_log = array();
		array_push($this->_log, round((microtime(true) - $this->_starttime),5).'s - '. $value);
	}
}