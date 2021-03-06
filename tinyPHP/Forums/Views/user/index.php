<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * User View
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

<!-- /.Start of Posts area -->
<div class="posts-obj">
	
<?php foreach($this->user as $key => $value) { ?>
<!-- /.Start of threads -->
<div class="posts" id="pages">
<ul class="posts content">
<li class="list">
<!-- /.Start of first thread post -->
	<div class="box02 content">
		<div class="cols2 clearfix">
			<div class="col1">&nbsp;</div>
			<div class="col2">&nbsp;</div>
		</div><!-- /.cols2 -->
	</div><!-- /.box02 -->

	<div class="cols3 clearfix">
		<div class="col1">
			<div class="col1-inner">
				<div class="name"><?php echo $value['username']; ?></div>
				<div class="role"><?php echo $value['role']; ?></div>
				<div class="photo"><?php echo get_user_avatar(getUserMeta($value['user_id'],'email'),115); ?></div>
				<ul class="info">
					<li><strong><?php _e( _t( 'Join Date:' ) ); ?></strong> <?php echo date('d M Y', strtotime($value['regdate'])); ?></li>
					<li><strong><?php _e( _t( 'Posts:' ) ); ?></strong> <?php echo userPostCount($value['user_id']); ?></li>
					<li><strong><?php _e( _t( 'Status:' ) ); ?></strong> <?php echo isUserOnline($value['username']); ?></li>
				</ul>
			</div><!-- /.col1-inner -->
		</div><!-- /.col1 -->
	
		<div class="col2">
			<div class="t1"></div>
			<div class="detail">
				
			</div>
			<div class="cols01 clearfix">
				<div class="col01">
					<a<?php _e(isUserFieldEmpty($value['user_id'],'facebook')); ?> href="<?php echo $value['facebook']; ?>">
						<img src="<?php echo BASE_URL; ?>static/images/facebook2.gif" alt="" width="6" height="13" />
					</a>
					<a<?php _e(isUserFieldEmpty($value['user_id'],'twitter')); ?> href="<?php echo $value['twitter']; ?>">
						<img src="<?php echo BASE_URL; ?>static/images/twitter2.gif" alt="" width="13" height="13" />
					</a>
					<a<?php _e(isUserFieldEmpty($value['user_id'],'googleplus')); ?> href="<?php echo $value['googleplus']; ?>">
						<img src="<?php echo BASE_URL; ?>static/images/googleplus2.gif" alt="" width="13" height="13" />
					</a>
					<a<?php _e(isUserFieldEmpty($value['user_id'],'linkedin')); ?> href="<?php echo $value['linkedin']; ?>">
						<img src="<?php echo BASE_URL; ?>static/images/linkedin2.gif" alt="" width="11" height="13" />
					</a>
				</div>
			</div><!-- /.cols01 -->
		</div><!-- /.col2 -->
	</div><!-- /.cols3 -->
<!-- /.End of first thread post -->
</li>
</ul>

</div><!-- /.posts -->
<?php } ?>
</div>