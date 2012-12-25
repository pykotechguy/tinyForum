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
?>
<?php foreach($this->profile as $key => $value) { ?>
<!-- /.Start of reply object -->
<div class="reply-obj">
	<div class="t1">Profile</div>
	<div class="t2"></div>
	<div class="box01">
		<form method="post" action="<?php echo BASE_URL; ?>profile/save">
		<div>Username: <input class="text" readonly name="username" value="<?php echo $value['username']; ?>" /></div>
		<div>First Name: <input class="text" name="first_name" value="<?php echo $value['first_name']; ?>" /></div>
		<div>Last Name: <input class="text" name="last_name" value="<?php echo $value['last_name']; ?>" /></div>
		<div>Email: <input class="text" name="email" value="<?php echo $value['email']; ?>" /></div>
		<div>Facebook URL: <input class="text" name="facebook" value="<?php echo $value['facebook']; ?>" /></div>
		<div>Twitter URL: <input class="text" name="twitter" value="<?php echo $value['twitter']; ?>" /></div>
		<div>Goolge+ URL: <input class="text" name="googleplus" value="<?php echo $value['googleplus']; ?>" /></div>
		<div>LinkedIn URL: <input class="text" name="linkedin" value="<?php echo $value['linkedin']; ?>" /></div>
		<div>Password: <input class="text" type="password" name="password" value="" /></div>
		<div class="cols1 clearfix">
			<div class="col3"><input class="a2" type="submit" value="Save Profile" /></div>
		</div>
		</form>
	</div><!-- /.box01 -->
</div><!-- /.reply-obj -->
<?php } ?>