<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
use \tinyPHP\Classes\Libraries\Hooks as Action;
$hook = new Action;
?>
<div class="totop-obj">
	<a href="#top"><img src="<?php echo BASE_URL; ?>static/images/top.png" alt="" width="32" height="32" /></a>
</div>
</div><!-- /.container -->
<!-- End Main Container -->

<div class="footer">
	<div class="inner">
		<div class="logo"><a href="http://tinyforum.us/"><img src="<?php echo BASE_URL; ?>static/images/logo02.png" alt="" width="204" height="45" /></a></div>
		<div class="links">
			v<?php echo TFORUM_VERSION; ?>&nbsp;&nbsp;
			<a href="http://tinyphp.us/"><img src="<?php echo BASE_URL; ?>static/images/tpowered.png" alt="Powered by tinyPHP" title="Powered by tinyPHP" /></a>&nbsp;&nbsp;
			<a href="http://us.php.net/"><img src="<?php echo BASE_URL; ?>static/images/php5.png" alt="Powered by PHP" title="Powered by PHP" /></a>
		</div>
	</div><!-- /.inner -->
</div><!-- /.footer -->

<div class="bottom">
	<div class="inner">
		<div class="copyright"><?php _e( _t( 'Copyright &copy; 2012 Designed by RohitCreations, Coded by Templatation. All rights reserved.' ) ); ?></div>
		<div class="social">
			<a<?php if($hook->get_option('facebook') == '') : echo ' style="display:none"'; endif; ?> href="<?php echo $hook->get_option('facebook'); ?>">
				<img src="<?php echo BASE_URL; ?>static/images/facebook.gif" alt="" width="22" height="22" />
			</a>
			<a<?php if($hook->get_option('flickr') == '') : echo ' style="display:none"'; endif; ?> href="<?php echo $hook->get_option('flickr'); ?>">
				<img src="<?php echo BASE_URL; ?>static/images/flickr.gif" alt="" width="23" height="22" />
			</a>
			<a<?php if($hook->get_option('googleplus') == '') : echo ' style="display:none"'; endif; ?> href="<?php echo $hook->get_option('googleplus'); ?>">
				<img src="<?php echo BASE_URL; ?>static/images/googleplus.gif" alt="" width="23" height="22" />
			</a>
			<a<?php if($hook->get_option('twitter') == '') : echo ' style="display:none"'; endif; ?> href="http://twitter.com/<?php echo $hook->get_option('twitter'); ?>">
				<img src="<?php echo BASE_URL; ?>static/images/twitter.gif" alt="" width="23" height="22" />
			</a>
			<a<?php if($hook->get_option('vimeo') == '') : echo ' style="display:none"'; endif; ?> href="<?php echo $hook->get_option('vimeo'); ?>">
				<img src="<?php echo BASE_URL; ?>static/images/vimeo.gif" alt="" width="22" height="22" />
			</a>
		</div>
	</div><!-- /.inner -->
</div><!-- /.bottom -->

</body>
<!-- End body tag -->
</html>
<?php ob_flush(); ?>