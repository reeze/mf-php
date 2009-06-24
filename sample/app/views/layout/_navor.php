<div id="navor">
	<ul class="clearfix">
		<li><?php echo link_to('Home', '@homepage'); ?></li>
		<li><?php echo link_to('About', '@page?slug=about'); ?></li>
		<li><?php echo link_to('Documentation', '@document?page=index'); ?></li>
		<li><?php echo link_to('Feed', '@feed?format=rss'); ?></li>
		<li><?php echo link_to('Blog', 'blog/index'); ?></li>
		<li><?php echo link_to('+ New Post', 'blog/new'); ?></li>
	</ul>
</div>
