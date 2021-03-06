<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Forum Save Success View
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

header("Refresh: 2;". BASE_URL);

?>

<div class="success-obj">
	<div class="box01">
	<span class="s1"><?php _e( _t( 'Success' ) ); ?></span><?php _e( _t( 'Your forum was saved/updated sucessfully.' ) ); ?> 
	</div>
</div>