<html>
<head>
	<title>MF:Micro PHP Framework</title>
	<style type="text/css">
	body {
		font-size: 12px;
		background-color: #efefef;
		margin: 0;
	}
	
	#wrapper {
		background-color: #fff;
		margin: 20px auto;
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
	#msg {
		border: 1px solid #cfcfd0;
		border-width: 1px 0;
		background-color: #efefef;
		padding: 10px;
		font-size: 14px;
	}
	
	</style>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<h1>MF: The Micro PHP Framework</h1>
		</div>
		<div id="content"><?php echo $mf_layout_content; ?></content>
	</div>
</body>
</html>