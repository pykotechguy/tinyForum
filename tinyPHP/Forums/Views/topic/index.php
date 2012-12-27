<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Topic View
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

	if (isset($this->css)) {
        foreach ($this->css as $css){
            _e( '<link type="text/css" rel="stylesheet" href="' . BASE_URL . 'static/js/'.$css.'" />' . "\n" );
        }
    }

	echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>'."\n";

    if (isset($this->js)) {
        foreach ($this->js as $js){
            _e( '<script type="text/javascript" src="' . BASE_URL . 'static/js/'.$js.'"></script>' . "\n" );
        }
    }
	
	$auth = new \tinyPHP\Classes\Libraries\Cookies();
	$hook = new \tinyPHP\Classes\Libraries\Hooks();
	
	foreach($this->topic as $key => $value) {
		$cache = new \tinyPHP\Classes\Libraries\Cache('1800', BASE_PATH . 'tmp/cache/', $value['topic_id'].'topic');
	}
	
	if(!$cache->setCache( $hook->get_option('cache') )) :
?>

<script type="text/javascript" >
   $(document).ready(function() {
      $("#postcontent").markItUp(mySettings);
      $('#pages').pajinate({num_page_links_to_display : 3,items_per_page : <?php echo $hook->get_option('ptcount'); ?>});
   });
</script>

<?php foreach( $this->topicBread as $key => $value ) { ?>
	<!-- Start breadcrumb -->
	<div class="breadcrumb">
	<ul>
		<li><a href="<?php echo BASE_URL; ?>">Home</a></li>
		<li><a href="<?php echo BASE_URL; ?>index/category/<?php echo $value['topic_fid']; ?>">Main Forum</a></li>
		<li><a class="active" href="<?php echo BASE_URL; ?>index/topic/<?php echo $value['topic_id']; ?>"><?php echo $value['topic_subject']; ?></a></li>
	</ul>
	</div><!-- /.breadcrumb -->
<?php } ?>
<!-- /.Start of Posts area -->
<div class="posts-obj">

	<div class="box01">
		<div class="cols1 clearfix">
			<div class="col1">Viewing <?php foreach( $this->title as $k => $v) { echo $v['topic_subject']; } ?></div>
			<div class="col2"></div>
			<div class="col3">&nbsp;</div>
		</div><!-- /.cols1 -->
	</div><!-- /.box01 -->

<!-- /.Start of threads -->
<div class="posts" id="pages">
<div class="page_navigation floatright"></div><!-- /.floatright -->
<ul class="posts content">
<?php foreach( $this->topic as $key => $value ) { ?>
<li class="list">
<!-- /.Start of first thread post -->
	<div class="box02 content">
		<div class="cols2 clearfix">
			<div class="col1"><?php echo date('d M Y', strtotime($value['post_date'])); ?></div>
			<div class="col2"># <?php echo $value['post_id']; ?></div>
		</div><!-- /.cols2 -->
	</div><!-- /.box02 -->

	<div class="cols3 clearfix">
		<div class="col1">
			<div class="col1-inner">
				<div class="name">
					<a href="<?php echo BASE_URL; ?>index/user/<?php echo $value['user_id']; ?>"><?php echo $value['username']; ?></a>
				</div>
				<div class="role"><?php echo $value['role']; ?></div>
				<div class="photo"><?php echo get_user_avatar(getUserMeta($value['user_id'],'email'),115); ?></div>
				<ul class="info">
					<li><strong>Join Date:</strong> <?php echo date('d M Y', strtotime($value['regdate'])); ?></li>
					<li><strong>Posts:</strong> <?php echo userPostCount($value['user_id']); ?></li>
					<li><strong>Status:</strong> <?php echo isUserOnline($value['username']); ?></li>
				</ul>
			</div><!-- /.col1-inner -->
		</div><!-- /.col1 -->
	
		<div class="col2">
			<div class="t1"><?php echo $value['topic_subject']; ?></div>
			<div class="detail">
			<?php echo stripslashes($value['post_content']); ?>
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
				<div class="col02">
					<?php if($auth->isUserLoggedIn() == true && $value['post_by'] == $auth->getUserField('user_id')) { ?>
					<a href="<?php echo BASE_URL; ?>index/post/<?php echo $value['post_id']; ?>">
						<img src="<?php echo BASE_URL; ?>static/images/bg54.png" alt="" width="13" height="13" />
					</a>
					<?php } ?>
				</div>
			</div><!-- /.cols01 -->
		</div><!-- /.col2 -->
	</div><!-- /.cols3 -->
<!-- /.End of first thread post -->
</li>
<?php } ?>
</ul>

</div><!-- /.posts -->
<!-- /.Start of threads -->
</div><!-- /.posts-obj -->
<!-- /.End of Posts area -->

<?php endif; echo $cache->getCache( $hook->get_option('cache') ); ?>

<?php if($auth->isUserLoggedIn() == true) {
	if(getForumMeta($value['topic_fid'],'permission') == 'Y' || $auth->getUserField('role') == 'Administrator') { ?>
<!-- /.Start of reply object -->
<div class="reply-obj">
	<div class="t1">Quick Reply</div>
	<div class="t2">Reply To This Topic</div>
	<div class="box01">
		<form method="post" action="<?php echo BASE_URL; ?>topic/reply/<?php echo $value['topic_id']; ?>">
		<div><textarea id="postcontent" width="904" height="131" name="post_content"></textarea></div>
		<div><input type="hidden" name="tID" value="<?php echo $value['topic_id']; ?>" /></div>
		<div class="cols1 clearfix">
			<div class="col3"><input class="a2" type="submit" value="Post Quick Reply" /></div>
		</div>
		</form>
	</div><!-- /.box01 -->
</div><!-- /.reply-obj -->
</div><!-- /.container -->
<?php } } 