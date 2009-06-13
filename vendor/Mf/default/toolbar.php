<!-- Debug Tool Bar Middleware -->
<style>
	#mf_toolbar {
		padding: 10px;
		border: 1px solid #ddd;
		position: absolute;
		top: 0;
		right: 200px;
		background-color: #fff;
	}
	#mf_logs {
	}
	
	
</style>

<div id="mf_toolbar">
	<div id="mf_tool_bar_banner">
		<a href="#" onclick="mf_logs.style.display=''">Show</a>
	</div>
	
	<div id="mf_logs" style="display:none">
		<?php foreach ($logs as $log) {
			echo $log['message'] . "<br />";
		}
		
		echo "<hr />";
		var_dump($mf_flash);
		?>
	</div>
</div>
