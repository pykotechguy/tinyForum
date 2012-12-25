<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Main Index View
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

$auth = new \tinyPHP\Classes\Libraries\Cookies();
?>
	<!-- Start breadcrumb -->
	<div class="breadcrumb">
	<ul>
		<li><a class="active" href="<?php echo BASE_URL; ?>">Home</a></li>
	</ul>
	</div><!-- /.breadcrumb -->

<!-- Start first category object -->
<div class="cats-obj">
<div class="cat">
	<div class="box01">
		<div class="cols1 clearfix">
			<div class="col1"><div class="t1">Forums</div></div>
			<div class="col3"><a class="collapse" ><img src="<?php echo BASE_URL; ?>static/images/collapse.png" alt="" width="27" height="27" /></a><a  class="expand"><img src="<?php echo BASE_URL; ?>static/images/expand.png" alt="" width="27" height="27" /></a></div>
		</div><!-- /.cols1 -->
	</div><!-- /.box01 -->

	<div class="posts">
		<div class="box02">
			<div class="cols2 clearfix">
				<div class="col1">Forum Name</div>
				<div class="col2">Last Topic</div>
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
					
					<?php if($auth->isUserLoggedIn() == true) { ?>
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
				<div class="by">by: <a href="<?php echo BASE_URL; ?>index/user/<?php echo $value['topic_by']; ?>"><?php echo getUserMeta($value['topic_by'], 'username'); ?></a></div>
				<div><img src="<?php echo BASE_URL; ?>static/images/icon10.png" alt="" width="14" height="14" /> <?php echo date('d M Y', strtotime($value['topic_date'])); ?> 
					<img src="<?php echo BASE_URL; ?>static/images/icon11.png" alt="" width="15" height="14" /> <?php echo date('g:i A', strtotime($value['topic_date'])); ?>
				</div>
				<?php else: echo '<p>No topics</p>'; endif; ?> 
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