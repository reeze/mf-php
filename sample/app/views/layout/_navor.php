<?php
/**
 * Global navor
 */
?>
<div id="navor">
	<ul><?php echo link_to('Home', '@homepage'); ?></ul>
	<ul><?php echo link_to('Feed', '@feed?format=rss'); ?></ul>
	<ul><?php echo link_to('Blog', 'blog/index'); ?></ul>
	<ul><?php echo link_to('+ New Post', 'blog/new'); ?></ul>
</div>