<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Register View
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

use \tinyPHP\Classes\Libraries\Hooks as Action;
$hook = new Action;
?>

<!-- /.Start of reply object -->
<div class="reply-obj">
	<div class="t1">Register</div>
	<div class="t2"></div>
	<div class="box01">
		<form method="post" action="<?php echo BASE_URL; ?>register/run">
		<?php $hook->do_action('reg_form_top'); ?>
		<div>Username: <input class="text" name="username" /></div>
		<div>Email: <input class="text" name="email" /></div>
		<div>Password: <input type="password" class="text" name="password" /></div>
		<?php $hook->do_action('reg_form_bottom'); ?>
		<div class="cols1 clearfix">
			<div class="col3"><input class="a2" type="submit" value="Register" /></div>
		</div>
		</form>
	</div><!-- /.box01 -->
</div><!-- /.reply-obj -->