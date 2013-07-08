<?php include'../layout.html';

if (isset($_GET['bid']) && isset($_GET['tid']) && $_SESSION['level']>=40 && $_GET['f']=="yes") {
	$tid=intval($_GET['tid']);
	mysql_query("UPDATE `forums_topics` SET `status`='closed' WHERE `topic_id`='$tid';") or die(mysql_error());
	$page=$_SERVER['HTTP_REFERER'];redirect($page);
}
if (isset($_GET['bid']) && isset($_GET['tid']) && $_SESSION['level']>=40 && $_GET['f']=="close") {
	$tid=intval($_GET['tid']);
	mysql_query("UPDATE `forums_topics` SET `status`='active' WHERE `topic_id`='$tid';") or die(mysql_error());
	$page=$_SERVER['HTTP_REFERER'];redirect($page);
}
else echo'<p>There has been a problem processing your request. Try again.</p>';

include'../footer.html';
?>
