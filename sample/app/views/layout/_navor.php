<?php
/**
 * Global navor
 */
?>
<div id="navor">
	<ul><?php echo link_to('Home', '@root'); ?></ul>
	<ul><?php echo link_to('Feed', '@feed?format=xml'); ?></ul>
	<ul><?php echo link_to('Blog', 'blog/index?format=rss'); ?></ul>
</div>