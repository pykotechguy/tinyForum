<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Profile View
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
?>
<?php foreach($this->profile as $key => $value) { ?>
<!-- /.Start of reply object -->
<div class="reply-obj">
	<div class="t1"><?php _e( _t( 'Profile' ) ); ?></div>
	<div class="t2"></div>
	<div class="box01">
		<form method="post" action="<?php echo BASE_URL; ?>profile/save">
		<div><?php _e( _t( 'Username:' ) ); ?> <input class="text" readonly name="username" value="<?php echo $value['username']; ?>" /></div>
		<div><?php _e( _t( 'First Name:' ) ); ?> <input class="text" name="first_name" value="<?php echo $value['first_name']; ?>" /></div>
		<div><?php _e( _t( 'Last Name:' ) ); ?> <input class="text" name="last_name" value="<?php echo $value['last_name']; ?>" /></div>
		<div><?php _e( _t( 'Email:' ) ); ?> <input class="text" name="email" value="<?php echo $value['email']; ?>" /></div>
		<div><?php _e( _t( 'Facebook URL:' ) ); ?> <input class="text" name="facebook" value="<?php echo $value['facebook']; ?>" /></div>
		<div><?php _e( _t( 'Twitter URL:' ) ); ?> <input class="text" name="twitter" value="<?php echo $value['twitter']; ?>" /></div>
		<div><?php _e( _t( 'Goolge+ URL:' ) ); ?> <input class="text" name="googleplus" value="<?php echo $value['googleplus']; ?>" /></div>
		<div><?php _e( _t( 'LinkedIn URL:' ) ); ?> <input class="text" name="linkedin" value="<?php echo $value['linkedin']; ?>" /></div>
		<div><?php _e( _t( 'Password:' ) ); ?> <input class="text" type="password" name="password" value="" /></div>
		<div class="cols1 clearfix">
			<div class="col3"><input class="a2" type="submit" value="<?php _e( _t( 'Save Profile' ) ); ?>" /></div>
		</div>
		</form>
	</div><!-- /.box01 -->
</div><!-- /.reply-obj -->
<?php } ?>