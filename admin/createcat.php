<?php include'../layout.html';
if ($_SESSION['level']>=50 && isset($_COOKIE["judgify_login"])) {
	if (isset($_POST['title']) && isset($_POST['view'])) {
		$name=escape_chars_trim($_POST['title']);
		if(!is_numeric($_POST['view'])) {$page="admin/createboard.php?msg=The%20entry%20was%20not%20a%20number.";redirect($page);}
		mysql_query("INSERT INTO `forums_cats` (`cat_name`,`cat_view`) VALUES ('".$name."','".$_POST['view']."'");
		$page="index.php";redirect($page);
	}
	else {
		echo'<form action="admin/createboard.php" method="post" enctype="multipart/form-data" class="form">
		<fieldset>
		<legend>Create Category</legend>
		<p>Category Title: <input type="text" name="title" maxlength="30" /></p>
		<p>Minimum View Level: <input type="text" name="view" maxlength="2" /></p>
		<p><input type="submit" value="Submit" /></p></fieldset></form>';
	}
}
else redirect();
include'../footer.html';
?>
