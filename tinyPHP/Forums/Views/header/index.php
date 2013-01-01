<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Header View
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
 
ob_start();
use \tinyPHP\Classes\Libraries\Menu as menu;
use \tinyPHP\Classes\Libraries\Cookies as Auth;
use \tinyPHP\Classes\Libraries\Hooks as Action;
$hook = new Action;
$auth = new Auth;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php 
	if(isset($this->staticTitle)) {
		foreach($this->staticTitle as $title) {
		 	echo $title . ' - ' . $hook->get_option('forum_name');
		 } 
	} else {
		foreach($this->dynamicTitle as $title) {
			echo $title . ' - ' . $hook->get_option('forum_name');
		} 
	}
	 ?>
</title>
<link type="text/css" rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/forum.css" />
<script type="text/javascript" src="<?php echo BASE_URL; ?>static/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>static/js/custom.js"></script>
</head>
<!-- Start body tag -->
<body>

<!-- Start top black bar -->
<div class="top" id="top">
	<div class="inner">
		<form action="">
		<div class="login">
		<div class="col1"></div>
		<div class="col2"></div>
		<div class="col3"></div>
		<div class="col4"></div>
		<?php if($auth->isUserLoggedIn()) { ?>
		<div class="col5"><?php _e( _t( 'Howdy' ) ); ?></div>
		<div class="col6"><a href="<?php echo BASE_URL; ?>profile"><?php echo $auth->getUserField('username'); ?></a> <a href="<?php echo BASE_URL; ?>index/logout">( <?php _e( _t( 'Logout' ) ); ?> )</a></div>
		<?php } else { ?>
		<div class="col5"><a href="<?php echo BASE_URL; ?>login" class="a1"><?php _e( _t( 'Login' ) ); ?></a></div>
		<div class="col6"><a href="<?php echo BASE_URL; ?>register" class="a1"><?php _e( _t( 'Register' ) ); ?></a></div>
		<?php } ?>
		</div>
		</form>
	</div><!-- /.inner -->
</div><!-- /.top -->
<!-- End top black bar -->

<!-- Start header -->
<div class="header">
	<div class="logo"><a href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>static/images/logo01.png" alt="" width="206" height="46" /></a></div>
	</div><!-- /.header -->
<!-- End header -->

<!-- Start Menu -->
<div class="topmenu">
	<div class="inner">
		<ul class="menu">
			<li class="item01"><a href="<?php echo BASE_URL; ?>"><span><?php _e( _t( 'Home' ) ); ?></span></a></li>
			<li class="item02"><a class="parent" href="#"><span><?php _e( _t( 'Browse All Pages' ) ); ?></span></a>
			<?php $menu = menu::factory();
				$menu->add( _t('Forum Home'), BASE_URL );
				if($auth->isUserLoggedIn()) :
					if($auth->getUserField('role') == 'Administrator') :
				$menu->add( _t('Forum Settings'), BASE_URL.'settings' );
				$menu->add( _t('Create a Forum'), BASE_URL.'category/create' );
					endif;
				$menu->add( _t('Edit Profile'), BASE_URL.'profile' );
				$menu->add( _t('Start a topic'), BASE_URL.'topic/create' );
				endif;
				echo new \tinyPHP\Classes\Libraries\TidyMenu($menu);
			?>
			</li>
		</ul>
	</div><!-- /.inner -->
</div><!-- /.topmenu -->
<div class="topmenu2-obj">
	<div class="inner"></div><!-- /.inner -->
</div><!-- /.topmenu2-obj -->
<!-- End of Menu -->

<!-- Start main container -->
<div class="container">