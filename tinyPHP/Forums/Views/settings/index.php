<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Settings View
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
	<div class="t1">Forum Settings</div>
	<div class="t2"></div>
	<div class="box01">
		<form method="post" action="<?php echo BASE_URL; ?>settings/save">
		<div>Admin Email: <input class="text" name="admin_email" value="<?php echo $hook->get_option('admin_email'); ?>" /></div>
		<div>Forum Name: <input class="text" name="forum_name" value="<?php echo $hook->get_option('forum_name'); ?>" /></div>
		<div>Threads Per Page: <input class="text" name="thcount" value="<?php echo $hook->get_option('thcount'); ?>" /></div>
		<div>Posts Per Page: <input class="text" name="ptcount" value="<?php echo $hook->get_option('ptcount'); ?>" /></div>
		<div>Cookie TTL: <input class="text" name="cookieexpire" value="<?php echo $hook->get_option('cookieexpire'); ?>" /></div>
		<div>Cookie Path: <input class="text" name="cookiepath" value="<?php echo $hook->get_option('cookiepath'); ?>" /></div><br />
		<div>Enable Caching: 
			<select name="cache">
				<option value="Yes"<?php echo selected( 'Yes', $hook->get_option('cache'), false ); ?>>Yes</option>
				<option value="No"<?php echo selected( 'No', $hook->get_option('cache'), false ); ?>>No</option>
			</select>
		</div><br />
		<div>Facebook URL: <input class="text" name="facebook" value="<?php echo $hook->get_option('facebook'); ?>" /></div>
		<div>Flickr URL: <input class="text" name="flickr" value="<?php echo $hook->get_option('flickr'); ?>" /></div>
		<div>Google+ URL: <input class="text" name="googleplus" value="<?php echo $hook->get_option('googleplus'); ?>" /></div>
		<div>Twitter Username: <input class="text" name="twitter" value="<?php echo $hook->get_option('twitter'); ?>" /></div>
		<div>Vimeo URL: <input class="text" name="vimeo" value="<?php echo $hook->get_option('vimeo'); ?>" /></div>
		<div class="cols1 clearfix">
			<div class="col3"><input class="a2" type="submit" value="Save Settings" /></div>
		</div>
		</form>
	</div><!-- /.box01 -->
</div><!-- /.reply-obj -->