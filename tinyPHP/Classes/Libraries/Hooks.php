<?php namespace tinyPHP\Classes\Libraries;
/**
 *
 * @package tinyForum
 * @since 1.0
 */

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class Hooks {
	
	/**
	 * @var array
	 *
	*/
	private $filters = array();
	
	/**
	 * @var string
	 *
	*/
	private $actions;
	
	/**
	 * @var array
	 *
	*/
	private $merged_filters = array();
	
	/**
	 * @var string
	 *
	*/
	private $current_filter;
	
	/**
	 * @var object
	 *
	*/
	private $db;
	
	/**
	 * @var string
	 *
	*/
	private $error = array();
	
	public function __construct() {
		$this->db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->db->conn();
	}
	
	/**
 	* Registers a filtering function
 	* 
 	* Typical use: hooks::add_filter('some_hook', 'function_handler_for_hook');
 	*
 	* @global array $filters Storage for all of the filters
 	* @param string $hook the name of the PM element to be filtered or PM action to be triggered
 	* @param callback $function the name of the function that is to be called.
 	* @param integer $priority optional. Used to specify the order in which the functions associated with a particular action are executed (default=10, lower=earlier execution, and functions with the same priority are executed in the order in which they were added to the filter)
 	* @param int $accepted_args optional. The number of arguments the function accept (default is the number provided).
 	*/
	public function add_filter( $hook, $function, $priority = 10, $accepted_args = NULL ) {
		
		// At this point, we cannot check if the function exists, as it may well be defined later (which is OK)
		$id = $this->filter_unique_id( $hook, $function, $priority );
	
		$this->filters[$hook][$priority][$id] = array(
			'function' => $function,
			'accepted_args' => $accepted_args,
		);
	}
	
	
	/**
	 * add_action
	 * Adds a hook
	 *
	 * @param string $hook
	 * @param string $function
	 * @param integer $priority (optional)
	 * @param integer $accepted_args (optional)
	 *
	*/
	public function add_action($hook, $function, $priority = 10, $accepted_args = 1) {
		return $this->add_filter( $hook, $function, $priority, $accepted_args );
	}
	
	/**
 	* Build Unique ID for storage and retrieval.
 	*
 	* Simply using a function name is not enough, as several functions can have the same name when they are enclosed in classes.
 	*
 	* @param string $hook
 	* @param string|array $function used for creating unique id
 	* @param int|bool $priority used in counting how many hooks were applied.  If === false and $function is an object reference, we return the unique id only if it already has one, false otherwise.
 	* @return string unique ID for usage as array key
 	*/
	public function filter_unique_id( $hook, $function, $priority ) {

		// If function then just skip all of the tests and not overwrite the following.
		if ( is_string($function) )
			return $function;
		// Object Class Calling
		else if (is_object($function[0]) ) {
			$obj_idx = get_class($function[0]).$function[1];
			if ( !isset($function[0]->_filters_id) ) {
				if ( false === $priority )
					return false;
				$count = isset($this->filters[$hook][$priority]) ? count((array)$this->filters[$hook][$priority]) : 0;
				$function[0]->_filters_id = $count;
				$obj_idx .= $count;
				unset($count);
			} else
				$obj_idx .= $function[0]->_filters_id;
			return $obj_idx;
		}
		// Static Calling
		else if ( is_string($function[0]) )
			return $function[0].$function[1];
	}
	
	/**
 	* Performs a filtering operation on a PM element or event.
 	*
 	* Typical use:
 	*
 	* 		1) Modify a variable if a function is attached to hook 'hook'
 	*		$var = "default value";
 	*		$var = hooks::apply_filter( 'hook', $var );
 	*
 	*		2) Trigger functions is attached to event 'pm_event'
 	*		hooks::apply_filter( 'event' );
 	*       (see hooks::do_action() )
 	* 
 	* Returns an element which may have been filtered by a filter.
 	*
 	* @global array $filters storage for all of the filters
 	* @param string $hook the name of the the element or action
 	* @param mixed $value the value of the element before filtering
 	* @return mixed
 	*/
	public function apply_filter( $hook, $value = '' ) {
		if ( !isset( $this->filters[$hook] ) )
			return $value;
	
		$args = func_get_args();
	
		// Sort filters by priority
		ksort( $this->filters[$hook] );
	
		// Loops through each filter
		reset( $this->filters[$hook] );
		do {
			foreach( (array) current($this->filters[$hook]) as $the_ )
				if ( !is_null($the_['function']) ){
					$args[1] = $value;
					$count = $the_['accepted_args'];
					if (is_null($count)) {
						$value = call_user_func_array($the_['function'], array_slice($args, 1));
					} else {
						$value = call_user_func_array($the_['function'], array_slice($args, 1, (int) $count));
					}
				}

		} while ( next($this->filters[$hook]) !== false );
	
		return $value;
	}
	
	public function do_action( $hook, $arg = '' ) {
		$args = array();
		if ( is_array($arg) && 1 == count($arg) && isset($arg[0]) && is_object($arg[0]) ) // array(&$this)
			$args[] =& $arg[0];
		else
			$args[] = $arg;
		for ( $a = 2; $a < func_num_args(); $a++ )
			$args[] = func_get_arg($a);
	
		$this->apply_filter( $hook, $args );
	}
	
	public function call_all_hook($args) {
	
		reset( $this->filters['all'] );
		do {
			foreach( (array) current($this->filters['all']) as $the_ )
				if ( !is_null($the_['function']) )
					call_user_func_array($the_['function'], $args);
	
		} while ( next($this->filters['all']) !== false );
	}
	
	public function do_action_array($hook, $args) {
	
		if ( ! isset($this->actions) )
			$this->actions = array();
	
		if ( ! isset($this->actions[$hook]) )
			$this->actions[$hook] = 1;
		else
			++$this->actions[$hook];
	
		// Do 'all' actions first
		if ( isset($this->filters['all']) ) {
			$this->current_filter[] = $hook;
			$all_args = func_get_args();
			$this->call_all_hook($all_args);
		}
	
		if ( !isset($this->filters[$hook]) ) {
			if ( isset($this->filters['all']) )
				array_pop($this->current_filter);
			return;
		}
	
		if ( !isset($this->filters['all']) )
			$this->current_filter[] = $hook;
	
		// Sort
		if ( !isset( $this->merged_filters[ $hook ] ) ) {
			ksort($this->filters[$hook]);
			$this->merged_filters[ $hook ] = true;
		}
	
		reset( $this->filters[ $hook ] );
	
		do {
			foreach( (array) current($this->filters[$hook]) as $the_ )
				if ( !is_null($the_['function']) )
					call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));
	
		} while ( next($this->filters[$hook]) !== false );
	
		array_pop($this->current_filter);
	}
	
	/**
 	* Removes a function from a specified filter hook.
 	*
 	* This function removes a function attached to a specified filter hook. This
 	* method can be used to remove default functions attached to a specific filter
 	* hook and possibly replace them with a substitute.
 	*
 	* To remove a hook, the $function_to_remove and $priority arguments must match
 	* when the hook was added.
 	*
 	* @global array $filters storage for all of the filters
 	* @param string $hook The filter hook to which the function to be removed is hooked.
 	* @param callback $function_to_remove The name of the function which should be removed.
 	* @param int $priority optional. The priority of the function (default: 10).
 	* @param int $accepted_args optional. The number of arguments the function accepts (default: 1).
 	* @return boolean Whether the function was registered as a filter before it was removed.
 	*/
	public function remove_filter( $hook, $function_to_remove, $priority = 10, $accepted_args = 1 ) {

		$function_to_remove = $this->filter_unique_id($hook, $function_to_remove, $priority);
		
		$remove = isset ($this->filters[$hook][$priority][$function_to_remove]);

		if ( $remove === true ) {
			unset ($this->filters[$hook][$priority][$function_to_remove]);
			if ( empty($this->filters[$hook][$priority]) )
				unset ($this->filters[$hook]);
		}
		return $remove;
	}
	
	/**
 	* Check if any filter has been registered for a hook.
 	*
 	* @global array $filters storage for all of the filters
 	* @param string $hook The name of the filter hook.
 	* @param callback $function_to_check optional.  If specified, return the priority of that function on this hook or false if not attached.
 	* @return int|boolean Optionally returns the priority on that hook for the specified function.
 	*/
	public function has_filter( $hook, $function_to_check = false ) {

		$has = !empty($this->filters[$hook]);
		if ( false === $function_to_check || false == $has ) {
			return $has;
		}
		if ( !$idx = $this->filter_unique_id($hook, $function_to_check, false) ) {
		return false;
		}

		foreach ( (array) array_keys($this->filters[$hook]) as $priority ) {
			if ( isset($this->filters[$hook][$priority][$idx]) )
				return $priority;
		}
		return false;
	}
	
	public function has_action( $hook, $function_to_check = false ) {
		return $this->has_filter( $hook, $function_to_check );
	}
	
	// Read an option from TP. Return value or $default if not found
	public function get_option( $option_name, $default = false ) {
	
		// Allow plugins to short-circuit options
		$pre = $this->apply_filter( 'pre_option_'.$option_name, false );
		if ( false !== $pre )
			return $pre;

		if ( !isset( $this->db->option[$option_name] ) ) {
			$option_name = $this->db->escape( $option_name );
			$results = $this->db->get_row( "SELECT `option_value` FROM " . TP . "options WHERE `option_name` = '$option_name'" );
			if ( is_object( $results) ) {
				$value = $results->option_value;
			} else { // option does not exist, so we must cache its non-existence
				$value = $default;
			}
			$this->db->option[$option_name] = $this->maybe_unserialize( $value );
		}

		return $this->apply_filter( 'get_option_'.$option_name, $this->db->option[$option_name] );
	}
	
	// Update (add if doesn't exist) an option to TP
	public function update_option( $option_name, $newvalue ) {

		$safe_option_name = $this->db->escape( $option_name );

		$oldvalue = $this->get_option( $safe_option_name );

		// If the new and old values are the same, no need to update.
		if ( $newvalue === $oldvalue )
			return false;

		if ( false === $oldvalue ) {
			$this->add_option( $option_name, $newvalue );
			return true;
		}

		$_newvalue = $this->db->escape( $this->maybe_serialize( $newvalue ) );
	
		$this->do_action( 'update_option', $option_name, $oldvalue, $newvalue );

		$this->db->query( "UPDATE " . TP . "options SET `option_value` = '$_newvalue' WHERE `option_name` = '$option_name'");

		if ( $this->db->rows_affected() == 1 ) {
			$this->db->option[$option_name] = $newvalue;
			return true;
		}
		return false;
	}

	// Add an option to the TP
	public function add_option( $name, $value = '' ) {
		$safe_name = $this->db->escape( $name );

		// Make sure the option doesn't already exist
		if ( false !== $this->get_option( $safe_name ) )
			return;

		$_value = $this->db->escape( $this->maybe_serialize( $value ) );

		$this->do_action( 'add_option', $safe_name, $_value );

		$this->db->query( "INSERT INTO " . TP . "options (`option_name`, `option_value`) VALUES ('$name', '$_value')" );
		$this->db->option[$name] = $value;
		return;
	}

	// Delete an option from the TP
	public function delete_option( $name ) {
		$name = $this->db->escape( $name );

		// Get the ID, if no ID then return
		$results = $this->db->get_row( "SELECT option_id FROM " . TP . "options WHERE `option_name` = '$name'" );
		if ( is_null($results) || !$results->option_id )
			return false;
		
		$this->do_action( 'delete_option', $option_name );
		
		$this->db->query( "DELETE FROM " . TP . "options WHERE `option_name` = '$name'" );
		return true;
	}
	
	// Serialize data if needed. Stolen from WordPress
	public function maybe_serialize( $data ) {
		if ( is_array( $data ) || is_object( $data ) )
			return serialize( $data );

		if ( $this->is_serialized( $data ) )
			return serialize( $data );

		return $data;
	}

	// Check value to find if it was serialized. Stolen from WordPress
	public function is_serialized( $data ) {
		// if it isn't a string, it isn't serialized
		if ( !is_string( $data ) )
			return false;
		$data = trim( $data );
		if ( 'N;' == $data )
			return true;
		if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
			return false;
		switch ( $badions[1] ) {
			case 'a' :
			case 'O' :
			case 's' :
				if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
					return true;
				break;
			case 'b' :
			case 'i' :
			case 'd' :
				if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
					return true;
				break;
		}
		return false;
	}

	// Unserialize value only if it was serialized. Stolen from WP
	public function maybe_unserialize( $original ) {
		if ( $this->is_serialized( $original ) ) // don't attempt to unserialize data that wasn't serialized going in
			return @unserialize( $original );
		return $original;
	}
}