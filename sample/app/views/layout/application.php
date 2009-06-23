<html>
<head>
	<title><?php isset($title) ? print($title) : print("Page") ?> - MF</title>
	<?php include_javascripts('default', 'jquery'); ?>
	<?php include_stylesheets('mf'); ?>
	<style type="text/css">
	body {
		font-size: 12px;
		background-color: #efefef;
		margin: 0;
	}
	
	#wrapper {
		background-color: #fff;
		margin: 10px auto;
		width: 800px;
		border: 1px solid #acacac;
	}
	#header {
		margin: 0 20px;
		border-bottom: 2px solid #9e9e9e;
	}
	#header h1 {
		color: #5e5e33;
	}
	#content {
		padding: 20px
	}
	</style>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<h1>MF: Sample App</h1>
			<?php include_partial('layout/navor');?>
		</div>
		<?php
			if($mf_flash->has('notice'))
			{
				echo "<h>";
				echo $mf_flash->get('notice');
				echo "</h>";
			}
		?><?php echo link_to("Post", "@view_post?year=2007&month=08&day=10&show=It#hah")?></li>
		</ul>
		<div id="content"><?php echo $mf_layout_content; ?></content>
	</div>
</body>
</html>