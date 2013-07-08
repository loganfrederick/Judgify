<?php include'layout.html';
if (in_array($_POST['cat'],$cats) && isset($_POST['id']) && isset($_POST['comment'])) {
	foreach ($_POST as $key=>$value) $_POST[$key]=escape_chars_trim($value, $key);
	$time=time();$id=intval($_POST['id']);$reason=$_POST['reason'];$comment=$_POST['comment'];$user=$_SESSION['id'];
	mysql_query("INSERT INTO `".$_POST['cat']."_comment` (`from`,`time`,`item_id`,`comment`) VALUES ('$user','$time','$id','$comment')") or die(mysql_error());
	mysql_query("UPDATE `user` SET num_comments=num_comments+1 WHERE `id`=$user") or die(mysql_error()); 
	$page=$_SERVER['HTTP_REFERER']."&msg=Your%20comment%20has%20been%20added.";redirect($page);
}
else redirect();
include'footer.html';
?>
