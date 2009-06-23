<html>
<head>
	<title><?php isset($title) ? print($title) : print("Page") ?> - MF</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<?php include_javascripts('default', 'jquery'); ?>
	<?php include_stylesheets('mf'); ?>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<h1>MF: My PHP Framework</h1>
			<?php include_partial('layout/navor');?>
		</div>
		<?php
			if($mf_flash->has('notice'))
			{
				echo "<h>";
				echo $mf_flash->get('notice');
				echo "</h>";
			}
		?>

		<div id="content"><?php echo $mf_layout_content; ?></content>
	</div>
</body>
</html>
