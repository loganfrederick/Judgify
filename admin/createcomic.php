<?php include'../layout.html';
if ($_SESSION['level']>=50 && isset($_COOKIE["judgify_login"])) {
	if (isset($_POST['title']) && isset($_POST['tags'])) {
		$name=escape_chars_trim($_POST['title'],"null");
		$tags=$_POST['tags'];
		$tmp=explode('.',$_FILES['img']['name']);
		$fileext=$tmp[count($tmp)-1];
		$file_name=$_FILES["img"]["name"];
		$file_name=str_replace(" ","_",$file_name);
		
		if (!in_array($fileext,$img_file_extensions)) {echo'error';}//$page='admin/createcomic.php?msg=The%20file%20failed%20to%20upload%20because%20it%20was%20not%20an%20image.';}
		
		$img=$comic_pic_upload_path.$file_name;$time=time();
		move_uploaded_file($_FILES['img']['tmp_name'],$img);
		echo $img;
		//mysql_query("INSERT INTO `comics` (`time`,`title`,`comic`,`tags`) VALUES ('$time','$name','$img','$tags')") or die(mysql_error());
		//$page="index.php";redirect($page);
	}
	else {
		echo'<form action="admin/createcomic.php" method="POST" enctype="multipart/form-data" class="form">
		<fieldset>
		<legend>Add Comic</legend>
		<p>Comic Title: <input type="text" name="title" maxlength="30" /></p>
		<p>Tags (Seperate by comma): <input type="text" name="tags" /></p>
		<p>Upload Comic: <input type="file" name="img" size=30 /></p>
		<p><input type="submit" value="Submit" /></p></fieldset></form>';
	}
}
else redirect();
include'../footer.html';
?>
