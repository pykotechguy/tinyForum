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

	if (isset($this->css)) {
        foreach ($this->css as $css){
            _e( '<link type="text/css" rel="stylesheet" href="' . BASE_URL . 'static/js/'.$css.'" />' . "\n" );
        }
    }

    if (isset($this->js)) {
        foreach ($this->js as $js){
            _e( '<script type="text/javascript" src="' . BASE_URL . 'static/js/'.$js.'"></script>' . "\n" );
        }
    }
	
	$auth = new \tinyPHP\Classes\Libraries\Cookies();
?>

<script type="text/javascript" >
   $(document).ready(function() {
      $("#postcontent").markItUp(mySettings);
   });
</script>

<?php if($auth->isUserLoggedIn() == true) { ?>
<!-- /.Start of reply object -->
<div class="reply-obj">
	<div class="t1">Create a new topic</div>
	<div class="t2"></div>
	<div class="box01">
		<form method="post" action="<?php echo BASE_URL; ?>topic/run">
		<div>Subject: <input class="text" type="text" name="topic_subject" /></div>
		<div>Forum:<br />
			<select name="topic_fid">
			<option value="">------</option>
			<?php foreach($this->cats as $k => $v) { ?>
			<option value="<?php echo $v['fid']; ?>"><?php echo $v['name']; ?></option>
			<?php } ?>
			</select>
		</div>
		<div><textarea id="postcontent" width="904" height="131" name="post_content"></textarea></div>
		<div class="cols1 clearfix">
			<div class="col3"><input class="a2" type="submit" value="Post Topic" /></div>
		</div>
		</form>
	</div><!-- /.box01 -->
</div><!-- /.reply-obj -->
<?php } ?>