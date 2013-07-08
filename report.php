<?php include'layout.html';
if (!isset($_COOKIE['judgify_login']) || !isset($_SESSION['id'])) {
	$page="login.php";redirect();
}
else if (isset($_POST['cat']) && isset($_POST['id']) && isset($_POST['reason']) && isset($_POST['explain'])) {
	foreach ($_POST as $key=>$value) $_POST[$key]=escape_chars_trim($value, $key);
	if (!in_array($_POST['reason'],$report_reasons)) redirect();
	else {
		$time=time();$id=intval($_POST['id']);$reason=$_POST['reason'];$explain=$_POST['explain'];$cat=$_POST['cat'];$user=$_SESSION['id'];
		mysql_query("INSERT INTO `modque` (`from`,`time`,`cat`,`item_id`,`reason`,`explain`) VALUES ('$user','$time','$cat','$id','$reason','$explain')") or die(mysql_error());
		$page=$_SERVER['HTTP_REFERER']."&msg=Your%20report%20has%20been%20sent.";redirect($page);
	}
}
else if (isset($_POST['bid']) && isset($_POST['tid']) && isset($_POST['mid']) && isset($_POST['uid']) && isset($_POST['reason'])) {
	$reason=escape_chars_trim($_POST['reason'],"null");
	if (!in_array($_POST['reason'],$forum_report_reasons)) redirect();
	else {
		$poster=intval($_POST['uid']);$time=time();$bid=intval($_POST['bid']);$tid=intval($_POST['tid']);$mid=intval($_POST['mid']);$user=$_SESSION['id'];$reason=$_POST['reason'];
		mysql_query("INSERT INTO `forumque` (`from`,`poster`,`time`,`bid`,`tid`,`mid`,`reason`) VALUES ('$user','$poster','$time','$bid','$tid','$mid','$reason')") or die(mysql_error());
		$page=$_SERVER['HTTP_REFERER']."&msg=Your%20report%20has%20been%20sent.";redirect($page);
	}
}
else if (isset($_GET['bid']) && isset($_GET['tid']) && isset($_GET['mid']) && isset($_GET['uid'])) {
	$bid=intval($_GET['bid']);$tid=intval($_GET['tid']);$mid=intval($_GET['mid']);$uid=intval($_GET['uid']);
	echo'<form action="report.php" method="post" enctype="multipart/form-data" class="form">
		<fieldset>
		<legend>Report this Entry</legend>
		<input type="hidden" name="uid" value="',$uid,'" />
		<input type="hidden" name="bid" value="',$bid,'" />
		<input type="hidden" name="tid" value="',$tid,'" />
		<input type="hidden" name="mid" value="',$mid,'" />
		<p>Reason: <select name="reason"><optgroup label="Reasons">
			<option value="cuss">Foul Language</option>
			<option value="flame">Flaming/Trolling</option>
			<option value="spam">Spam/Disruption</option>
			<option value="spoil">Spoiler</option>
			<option value="other">Other</option>
		<p><input type="submit" value="Submit" /></p></fieldset></form></div></div>';
}
else redirect();
include'footer.html';
?>
