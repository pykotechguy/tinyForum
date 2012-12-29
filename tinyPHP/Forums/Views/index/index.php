<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Main Index View
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

$auth = new \tinyPHP\Classes\Libraries\Cookies();
$update = new \tinyPHP\Classes\Libraries\Update();
?>
	<!-- Start breadcrumb -->
	<div class="breadcrumb">
	<ul>
		<li><a class="active" href="<?php echo BASE_URL; ?>"><?php _e( _t( 'Home' ) ); ?></a></li>
	</ul>
	</div><!-- /.breadcrumb -->

<?php if($auth->isUserLoggedIn() && $auth->getUserField('role') == 'Administrator' && TFORUM_VERSION < $update->upgrade(0)) { ?>
<!-- Start yellow notification area -->
<div class="first-obj">
	<div class="first">
		<div class="cols1 clearfix">
			<div class="col1"><img src="<?php echo BASE_URL; ?>static/images/icon08.gif" alt="" width="29" height="26" /></div>
			<div class="col2"><?php echo $update->showUpdateMessage(); ?></div>
		</div>
	</div>
</div><!-- /.first-obj -->
<!-- End yellow notification area -->
<?php } ?>

<!-- Start first category object -->
<div class="cats-obj">
<div class="cat">
	<div class="box01">
		<div class="cols1 clearfix">
			<div class="col1"><div class="t1"><?php _e( _t( 'Forums' ) ); ?></div></div>
			<div class="col3"><a class="collapse" ><img src="<?php echo BASE_URL; ?>static/images/collapse.png" alt="" width="27" height="27" /></a><a  class="expand"><img src="<?php echo BASE_URL; ?>static/images/expand.png" alt="" width="27" height="27" /></a></div>
		</div><!-- /.cols1 -->
	</div><!-- /.box01 -->

	<div class="posts">
		<div class="box02">
			<div class="cols2 clearfix">
				<div class="col1"><?php _e( _t( 'Forum Name' ) ); ?></div>
				<div class="col2"><?php _e( _t( 'Last Topic' ) ); ?></div>
			</div>
		</div>
		<ul class="posts">
		<!-- Start forum thread rows -->
		<?php foreach( $this->getCatTopic as $key => $value ) { ?>
			<li>
			<div class="cols3 clearfix">
				<div class="col1"><img src="<?php echo BASE_URL; ?>static/images/icon09.png" alt="" width="28" height="28" /></div>
				<div class="col2">
				<div class="t2">
					
					<?php if(getPostMeta($value['topic_id'], 'post_id') != '') { ?>
						
					<a href="<?php echo BASE_URL; ?>index/category/<?php echo $value['fid']; ?>"><?php echo stripslashes($value['name']); ?></a>
					
					<?php if($auth->getUserField('role') == 'Administrator') : echo ' <a href="'.BASE_URL.'category/edit/'.$value['fid'].'"><img style="float:left;padding:0px 5px 5px 0px;" src="static/images/bg54.png" alt="" /></a>'; endif; ?> 
						
						(<?php echo $value['COUNT(topic_id)']; ?>)
						
					<?php } else {  ?>
					
					<?php if($auth->isUserLoggedIn()) { ?>
					<a href="<?php echo BASE_URL; ?>topic/create"><?php echo stripslashes($value['name']); ?></a>
					<?php } else { echo stripslashes($value['name']); } ?>
					
					<?php if($auth->getUserField('role') == 'Administrator') : echo ' <a href="'.BASE_URL.'category/edit/'.$value['fid'].'"><img style="float:left;padding:0px 5px 5px 0px;" src="static/images/bg54.png" alt="" /></a>'; endif; ?> 
						
						(<?php echo $value['COUNT(topic_id)']; ?>)
						
					<?php } ?>
						
				</div>
				<div><?php echo stripslashes($value['description']); ?></div>
				</div>
				<div class="col3">
				<?php if($value['topic_id'] != '') : ?>
				<div class="avatar">
					<?php echo get_user_avatar(getUserMeta($value['topic_by'],'email'),40); ?>
				</div>
				<div><a href="<?php echo BASE_URL; ?>index/topic/<?php echo $value['topic_id']; ?>"><?php echo stripslashes($value['topic_subject']); ?></a></div>
				<div class="by"><?php _e( _t( 'by:' ) ); ?> <a href="<?php echo BASE_URL; ?>index/user/<?php echo $value['topic_by']; ?>"><?php echo getUserMeta($value['topic_by'], 'username'); ?></a></div>
				<div><img src="<?php echo BASE_URL; ?>static/images/icon10.png" alt="" width="14" height="14" /> <?php echo date('d M Y', strtotime($value['topic_date'])); ?> 
					<img src="<?php echo BASE_URL; ?>static/images/icon11.png" alt="" width="15" height="14" /> <?php echo date('g:i A', strtotime($value['topic_date'])); ?>
				</div>
				<?php else: _e( _t( '<p>No topics</p>' ) ); endif; ?> 
				</div>
			</div>
			</li>
		<?php } ?>
		<!-- End forum thread first row -->
		</ul>
	</div><!-- /.posts -->
</div><!-- /.cat -->
</div><!-- /.cats-obj -->
<!-- End first category object -->

<!-- Start whats going on object -->
<div class="going-obj">
	<div class="cat">
		<div class="box01">
			<div class="cols1 clearfix">
				<div class="col1"><div class="t1"><?php _e( _t( 'What\'s Going On?' ) ); ?></div></div>
				<div class="col2"></div>
			</div><!-- /.cols1 -->
		</div><!-- /.box01 -->
		<div class="posts">
			<div class="box02">
				<div class="cols2 clearfix">
					<div class="col1"><?php _e( _t( 'Current Forum Info' ) ); ?></div>
				</div>
			</div>
			<ul class="posts">
				<li>
				<div class="cols3 clearfix">
					<div class="col1"><img src="<?php echo BASE_URL; ?>static/images/icon13.gif" alt="" width="32" height="21" /></div>
					<div class="col2">
					<div class="t2"><?php _e( _t( 'Currently Active Users' ) ); ?></div>
					<div><?php echo whoIsOnline(); ?>.</div>
					<div></div></div>
					
				</div>
				</li>
				<li class="last">
				<div class="cols3 clearfix">
					<div class="col1"><img src="<?php echo BASE_URL; ?>static/images/icon14.gif" alt="" width="30" height="26" /></div>
					<div class="col2">
					<div class="t2"><?php _e( _t( 'Forum Statistics' ) ); ?></div>
					<div>
						<?php _e( _t( 'Threads:' ) ); ?> <?php echo threadCount(); ?>, 
						<?php _e( _t( 'Posts:' ) ); ?> <?php echo postCount(); ?>, 
						Members: <?php echo memberCount(); ?>, 
						Active Members: <?php echo activeMemberCount(); ?>
					</div>
					<div>
						<?php _e( _t( 'Welcome to our newest member(s)' ) ); ?> 
						<?php echo newMember(); ?>
					</div>
					<div>
						<?php _e( _t( 'Latest Forum Topic:' ) ); ?> 
						<?php echo latestForumTopic(); ?>
					</div>
					</div>
					
				</div>
				</li>
			</ul>
		</div><!-- /.posts -->
	</div><!-- /.cat -->
</div><!-- /.going-obj -->
<!-- End whats going on object -->