<div id="sidebar">
	<h1>
		<?php if(!include_slot('sidebar_title')): ?>
			Default sidebar title
		<?php endif; ?>
	</h1>
	<ul>
		<li>This is the sidebar</li>
		<li>This is the sidebar</li>
		<li>This is the sidebar</li>
	</ul>
	<?php include_component('blog', 'catagory');?>
</div>