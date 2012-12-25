<?php if ( ! defined('BASE_PATH')) exit('No direct script access allowed');
/**
 *
 * Main Category View
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

$hook = new \tinyPHP\Classes\Libraries\Hooks();
$auth = new \tinyPHP\Classes\Libraries\Cookies();

echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>'."\n";

if (isset($this->js)) {
        foreach ($this->js as $js){
            _e( '<script type="text/javascript" src="' . BASE_URL . 'static/js/'.$js.'"></script>' . "\n" );
        }
    }

?>

<script type="text/javascript" >
$(document).ready(function(){
	$('#pages').pajinate({num_page_links_to_display : 3,items_per_page : <?php echo $hook->get_option('thcount'); ?>});
});
</script>

<?php foreach( $this->catBread as $key => $value ) { ?>
	<!-- Start breadcrumb -->
	<div class="breadcrumb">
	<ul>
		<li><a href="<?php echo BASE_URL; ?>">Home</a></li>
		<li><a class="active" href="<?php echo BASE_URL; ?>index/category/<?php echo $value['topic_fid']; ?>">Main Forum</a></li>
	</ul>
	</div><!-- /.breadcrumb -->
<?php } ?>

<!-- Start new thread bar -->
<div class="new-obj">
	<div class="cols1 clearfix">
		<?php if($auth->isUserLoggedIn() == true) { ?>
		<div class="floatleft"><a class="new" href="<?php echo BASE_URL; ?>topic/create/">Start new topic</a></div>
		<?php } ?>
	</div><!-- /.cols1 -->
</div><!-- /.new-obj -->
<!-- End new thread bar -->

<div id="pages">
<div class="page_navigation floatright"></div><!-- /.floatright -->
<!-- Start thread listings area -->
<div class="threads-obj">
	<div class="thread">
		<div class="box01">
			<div class="cols1 clearfix">
				<div class="col1"><div class="t1">Forum: <?php foreach($this->curForum as $k => $v) { echo $v['name']; } ?></div></div>
				<div class="col2"><?php foreach($this->curForum as $k => $v) { echo $v['description']; } ?></div>
				<div class="col3"></div>
			</div><!-- /.cols1 -->
		</div><!-- /.box01 -->
		
		<div class="posts">
			<div class="box02">
				<div class="cols2 clearfix">
					<div class="col1">Title/Thread Starter</div>
					<div class="col2">Last Post by</div>
				</div>
			</div>
			<ul class="posts content">
				<?php foreach( $this->category as $key => $value ) { ?>
				<li> <!-- / start of first row -->
					<div class="cols3 clearfix">
						<div class="col1"><img src="<?php echo BASE_URL; ?>static/images/icon09.png" alt="" width="28" height="28" /></div>
						<div class="col2">
						<div class="t2">
							<a href="<?php echo BASE_URL; ?>index/topic/<?php echo $value['topic_id']; ?>"><?php echo stripslashes($value['topic_subject']); ?></a>&nbsp;
							
							<?php if($auth->isUserLoggedIn() == true && $value['topic_by'] == $auth->getUserField('user_id')) { ?>
								<div style="float:left;">
								<a href="<?php echo BASE_URL; ?>topic/edit/<?php echo $value['topic_id']; ?>">
									<img src="<?php echo BASE_URL; ?>static/images/bg54.png" alt="" width="13" height="13" />
								</a> &nbsp;
					
								<form method="post" action="<?php echo BASE_URL; ?>topic/delete" style="vertical-align:top">
									<input type="hidden" name="fID" value="<?php echo $value['topic_fid']; ?>" />
									<input type="hidden" name="tID" value="<?php echo $value['topic_id']; ?>" />
									<input type="image" src="<?php echo BASE_URL; ?>static/images/bg55.png" name="delete" value="Delete" />
								</form>
								</div>
							<?php } ?>
						
						</div>
						<div class="by">Started by <a href="<?php echo BASE_URL; ?>index/user/<?php echo $value['topic_by']; ?>"><?php echo getUserMeta($value['topic_by'], 'username'); ?></a>, 
						<?php echo date('d M Y', strtotime($value['topic_date'])); ?>
						</div>
						</div><!-- /.col2 -->
						<div class="col3">
						<div class="col01"></div>
						<div class="col02">
						<div class="avatar">
							<?php echo get_user_avatar(getUserMeta(getPostMeta($value['topic_id'], 'post_by'),'email'),38); ?>
						</div>
						<div><a href="<?php echo BASE_URL; ?>index/user/<?php echo getUserMeta(getPostMeta($value['topic_id'], 'post_by'), 'user_id'); ?>" class="name"><?php echo getUserMeta(getPostMeta($value['topic_id'], 'post_by'), 'username'); ?></a></div>
						<div>
							<?php if(getPostMeta($value['topic_id'], 'post_date') != '') { ?>
							<img src="<?php echo BASE_URL; ?>static/images/icon10.png" alt="" width="14" height="14" /> <?php echo date('d M Y', strtotime(getPostMeta($value['topic_id'], 'post_date'))); ?> 
							<img src="<?php echo BASE_URL; ?>static/images/icon11.png" alt="" width="15" height="14" /> <?php echo date('g:i A', strtotime(getPostMeta($value['topic_id'], 'post_date'))); ?>
							<?php } else { echo '<p>No posts</p>'; } ?>
						</div>
						</div>
						</div><!-- /.col3 -->
					</div><!-- /.cols3 -->
				</li><!-- / end of first row -->
				<?php } ?>
			</ul>
		</div><!-- /.posts -->
	</div><!-- /.thread -->
</div><!-- /.threads-obj -->
</div>
<!-- End thread listings area -->