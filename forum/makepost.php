<?php
include'../layout.html';
$topic_id=intval($_GET['tid']);
$board_id=intval($_GET['bid']);

$select_topic=mysql_query("SELECT `status` FROM `forums_topics` WHERE `topic_id`='$topic_id'") or die("You reached this page improperly. Return back and try again.");
$topic=mysql_fetch_assoc($select_topic);
if ($topic['status']=="closed") {
	echo'<p>You reached this page improperly. Return back and try again.</p>';include'../footer.html';exit;
}

if (in_array($_GET['msg'],$msgs)) echo'<div class="announce">Message: ',$_GET['msg'],'</div>';
if ($_GET['mode']=="post" && isset($_GET['bid']) && isset($_GET['tid']) && isset($_POST['text']) && isset($_COOKIE["judgify_login"]) && isset($_SESSION['id']) && $_POST['submit']=="Post") {
	$_POST['text']=mysql_real_escape_string(trim(htmlentities($_POST['text'])));$text=censor(bbcode_parse($_POST['text']),$censored);
	if (strlen($_POST['text'])<5) {$page='makepost.php?bid='.$board_id.'&tid='.$topic_id.'&msg=The%20post%20can%20not%20be%20less%20than%205%20characters.';redirect($page);}
	else if (str_word_count($_POST['text'])>1500) {$page='makepost.php?bid='.$board_id.'&tid='.$topic_id.'&msg=The%20post%20must%20be%20less%20than%2012C500%20words.';redirect($page);}	
	else {
		$text='<p>'.str_replace('\r\n\r\n', '</p><p>', $text).'</p>';$userid=$_SESSION['id'];$time=time();
		mysql_query("INSERT INTO `forums_messages` (`message`,`poster_id`,`post_date`,`topic_id`) VALUES ('$text','$userid','$time','$topic_id')") or die(mysql_error());
		mysql_query("UPDATE `user` SET num_posts=num_posts+1 WHERE `id`=$userid") or die(mysql_error());
		mysql_query("UPDATE `forums` SET num_posts=num_posts+1 WHERE `board_id`=$board_id") or die(mysql_error());
		mysql_query("UPDATE `forums_topics` SET posts=posts+1,recent_date=$time WHERE `topic_id`=$topic_id") or die(mysql_error());
		$page='posts.php?bid='.$board_id.'&tid='.$topic_id.'&msg=Your%20post%20was%20added.';redirect($page);
	}
}
if ($_GET['mode']=="post" && isset($_GET['bid']) && isset($_GET['tid']) && isset($_POST['text']) && isset($_COOKIE["judgify_login"]) && isset($_SESSION['id']) && $_POST['submit']=="Spellcheck") {
	$text=censor($_POST['text'],$censored);$result=($_POST['submit']=="Spellcheck" ? spellcheck($text) : false);
	if (strlen($_POST['text'])<5) {$page='makepost.php?bid='.$board_id.'&tid='.$topic_id.'&msg=The%20post%20can%20not%20be%20less%20than%205%20characters.';redirect($page);}
	else if (str_word_count($_POST['text'])>1500) {$page='makepost.php?bid='.$board_id.'&tid='.$topic_id.'&msg=The%20post%20must%20be%20less%20than%2012C500%20words.';redirect($page);}	
	else {
		$userid=$_SESSION['id'];$time=time();
		echo'<form action="forum/makepost.php?mode=post&bid=',$board_id,'&tid=',$topic_id,'" method="post" enctype="multipart/form-data" class="form">
		<fieldset>
		<legend>Write a Post</legend>
		<p><span class="par">(Available Tags: [url=Link to Site]Text Link[/url],[b]Bold Text[/b], [i]Italicize Text[/i])</span>: </p>
		<p><textarea name="text" rows="20" cols="55">',$text,'</textarea></p>
		<p><input type="submit" name="submit" value="Post" /> <input type="submit" name="submit" value="Spellcheck" /></p></fieldset></form>';
		
		if (isset($result)) echo 'Spelling Suggestions: '.$result;
	}
}
else if ($_GET['mode']=="topic" && isset($_GET['bid']) && isset($_POST['title']) && isset($_POST['text']) && isset($_COOKIE["judgify_login"]) && isset($_SESSION['id'])) {
	$_POST['text']=mysql_real_escape_string(trim(htmlentities($_POST['text'])));$text=censor(bbcode_parse($_POST['text']),$censored);
	$_POST['title']=mysql_real_escape_string(trim(htmlentities($_POST['title'])));$title=censor(bbcode_parse($_POST['title']),$censored);
	if (strlen($_POST['text'])<5) {$page='makepost.php?bid='.$board_id.'&msg=The%20post%20can%20not%20be%20less%20than%205%20characters.';redirect($page);}
	else if (str_word_count($_POST['text'])>1500) {$page='makepost.php?bid='.$board_id.'&msg=The%20post%20must%20be%20less%20than%201,500%20words.';redirect($page);}
	else {
		$text='<p>'.str_replace('\r\n\r\n', '</p><p>', $text).'</p>';$userid=$_SESSION['id'];$time=time();
		mysql_query("INSERT INTO `forums_topics` (`title`,`board`,`creator_id`,`create_date`,`recent_date`,`posts`) VALUES ('$title','$board_id','$userid','$time','$time','1')") or die(mysql_error());
		$topic=mysql_query("SELECT `topic_id` FROM `forums_topics` WHERE `creator_id`='$userid' AND `create_date`='$time' AND `board`='$board_id'") or die(mysql_error());
		$topic=mysql_fetch_row($topic);$topic_id=$topic[0];
		mysql_query("INSERT INTO `forums_messages` (`message`,`poster_id`,`post_date`,`topic_id`,`first`) VALUES ('$text','$userid','$time','$topic_id','yes')") or die(mysql_error());
		mysql_query("UPDATE `forums` SET num_posts=num_posts+1,num_topics=num_topics+1 WHERE `board_id`=$board_id") or die(mysql_error());
		mysql_query("UPDATE `user` SET num_posts=num_posts+1 WHERE `id`=$userid") or die(mysql_error());
		$page='topics.php?id='.$board_id.'&msg=Your%20topic%20was%20added.';redirect($page);
	}
}
else if (isset($_GET['bid']) && isset($_GET['tid']) && isset($_COOKIE["judgify_login"]) && isset($_SESSION['id'])) {
	echo'<form action="forum/makepost.php?mode=post&bid=',$board_id,'&tid=',$topic_id,'" method="post" enctype="multipart/form-data" class="form">
	<fieldset>
	<legend>Write a Post</legend>
	<p><span class="par">(Available Tags: [url=Link to Site]Text Link[/url],[b]Bold Text[/b], [i]Italicize Text[/i])</span>: </p>
	<p><textarea name="text" rows="20" cols="55">A big post here</textarea></p>
	<p><input type="submit" name="submit" value="Post" /><input type="submit" name="submit" value="Spellcheck" /></p></fieldset></form>';
}
else if (isset($_GET['bid']) && isset($_COOKIE["judgify_login"]) && isset($_SESSION['id'])) {
	echo'<form action="forum/makepost.php?mode=topic&bid='.$board_id.'" method="post" enctype="multipart/form-data" class="form">
	<fieldset>
	<legend>Create Topic</legend>
	<p>Topic Title: <input type="text" name="title" maxlength="30" /></p>
	<p><span class="par">(Available Tags: [url=Link to Site]Text Link[/url],[b]Bold Text[/b], [i]Italicize Text[/i])</span>: </p>
	<p><textarea name="text" rows="10" cols="55">A big post here</textarea></p>
	<p><input type="submit" value="Submit" /></p></fieldset></form>';
}
else if (!isset($_COOKIE["judgify_login"]) || !isset($_SESSION['id'])) {
	echo'<p>You will need to be <a href="login.php">logged in</a> to submit Judgify entries. If you haven\'t yet, try <a href="register.php">creating an account</a>!</p>';
}
else {
	echo'<p>You reached this page improperly. Return back and try again.</p>';
}
include'../footer.html';
?>
