<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Edit Forum View
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

?>

<script type="text/javascript" >
   $(document).ready(function() {
      $("#description").markItUp(mySettings);
   });
</script>

<?php foreach($this->forum as $key => $value) { ?>
<!-- /.Start of reply object -->
<div class="reply-obj">
	<div class="t1"><?php _e( _t( 'Edit Forum' ) ); ?></div>
	<div class="t2"></div>
	<div class="box01">
		<form method="post" action="<?php echo BASE_URL; ?>category/editSave">
		<div><?php _e( _t( 'Forum Name:' ) ); ?> <input class="text" type="text" name="name" value="<?php echo stripslashes($value['name']); ?>" /><br /></div>
		<div><?php _e( _t( 'Can Users Post to this Forum?:' ) ); ?>
			<select name="permission">
				<option value="">-----------</option>
				<option value="Y"<?php if($value['permission'] == 'Y') echo " selected='selected'"; ?>><?php _e( _t( 'Yes' ) ); ?></option>
				<option value="N"<?php if($value['permission'] == 'N') echo " selected='selected'"; ?>><?php _e( _t( 'No' ) ); ?></option>
			</select><br /></div>
		<div><?php _e( _t( 'Sort:' ) ); ?> <input class="text" type="text" name="sort" value="<?php echo $value['sort']; ?>" /><br /></div>
		<div><?php _e( _t( 'Description:' ) ); ?></div>
		<div><textarea id="description" width="904" height="131" name="description"><?php echo stripslashes($value['description']); ?></textarea></div>
		<div class="cols1 clearfix">
			<div class="col3"><input name="fID" type="hidden" value="<?php echo $value['fid']; ?>" /></div>
			<div class="col3"><input class="a2" type="submit" value="<?php _e( _t( 'Edit Forum' ) ); ?>" /></div>
		</div>
		</form>
	</div><!-- /.box01 -->
</div><!-- /.reply-obj -->
<?php } ?>