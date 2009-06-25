<form method="post">
	<input type="text" name="title" id="title" />
	<select name="catagory_id">
	   <?php
	       foreach ($catagories as $catagory)
	       {
	       	   echo "<option value='{$catagory['id']}'>{$catagory['name']}</option>";
	       }
	   ?>
	</select>
	<textarea name="content"></textarea>
	<input type="submit" value="提交" />
</form>
<hr />
<h2>Add catagory</h2>
<form method="post" action="<?php echo url_for("catagory/add"); ?>">
Name: <input type="text" name="name" />
<input type="submit" value="添加" />
</form>