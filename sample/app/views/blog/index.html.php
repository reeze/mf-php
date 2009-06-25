<h1>Posts</h1>
<?php foreach ($posts as $post): ?>
	<hr>
	<?php echo link_to($post['title'], "@view_post?year=2009&month=10&day=15&slug={$post['slug']}"); ?>
<?php endforeach; ?>