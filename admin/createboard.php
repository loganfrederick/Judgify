<?php include'../layout.html';
if ($_SESSION['level']>=50 && isset($_COOKIE["judgify_login"])) {
	if (isset($_POST['title']) && isset($_POST['view']) && isset($_POST['post']) && isset($_POST['topic']) && isset($_POST['cat'])) {
		$name=escape_chars_trim($_POST['title']);
		if(!is_numeric($_POST['post']) && !is_numeric($_POST['view']) && !is_numeric($_POST['topic'])) {$page="admin/createboard.php?msg=The%20entry%20was%20not%20a%20number.";redirect($page);}
		mysql_query("INSERT INTO `forums` (`name`,`category`,`level_view`,`level_post`,`level_topic`) VALUES ('".$name."','".$_POST['cat']."','".$_POST['view']."','".$_POST['post']."','".$_POST['topic']."')");
		$page="index.php";redirect($page);
	}
	else {
		echo'<form action="admin/createboard.php" method="post" enctype="multipart/form-data" class="form">
		<fieldset>
		<legend>Create Board</legend>
		<p>Board Title: <input type="text" name="title" maxlength="30" /></p>
		<p>Category: <select name="cat"><optgroup label="Categories">';
		$query=mysql_query("SELECT `cat_id`,`cat_name` FROM `forums_cats`");
		while($result=mysql_fetch_assoc($query)) {
			echo'<option value="'.$result['cat_id'].'">'.$result['cat_name'].'</option>';
		}
		echo'</optgroup></select></p>
		<p>Minimum View Level: <input type="text" name="view" maxlength="2" /></p>
		<p>Minimum Posting Level: <input type="text" name="post" maxlength="2" /></p>
		<p>Minimum Topic Create Level: <input type="text" name="topic" maxlength="2" /></p>
		<p><input type="submit" value="Submit" /></p></fieldset></form>';
	}
}
else redirect();
include'../footer.html';
?>
