<?php
include'../layout.html';

echo'<h1>Judgify Forums</h1>';

$board_id=intval($_GET['id']);

$count=mysql_query("SELECT COUNT(*) FROM `forums` WHERE `board_id`='$board_id'") or die(mysql_error());
$result=mysql_fetch_row($count);
if ($result[0]!=1) {
	echo'You reached this page improperly. Return back and try again.</p>';include'../footer.html';exit;
}

echo'<a href="forum/index.php">Forums</a>';
if($_SESSION['level']>=40 && isset($_COOKIE["judgify_login"])) echo'<div class="forum_right_menu"><a href="forum/makepost.php?bid=',$board_id,'">Create Topic</a></div>';

$select_topics=mysql_query("SELECT a.*,b.`username` FROM `forums_topics` a,`user` b WHERE `board`='$board_id' AND a.`creator_id`=b.`id` ORDER BY a.`recent_date` DESC") or die(mysql_error());
$select_board=mysql_query("SELECT `name` FROM `forums` WHERE `board_id`='$board_id'") or die(mysql_error());

$board=mysql_fetch_assoc($select_board);
echo'<table class="catlist"><th colspan=5>',$board['name'],' Board</th>
<tr class="color"><td>Topic</td><td>Started By</td><td>Posts</td><td>Created</td><td>Updated</td></tr>';
while($topics=mysql_fetch_assoc($select_topics)) {
	echo'<tr><td><a href="forum/posts.php?bid=',$board_id,'&tid=',$topics['topic_id'],'">',$topics['title'];
	if ($topics['status']=="closed") echo'- <img src="forum/pic/closed.gif" />';
	if ($topics['sticky']=="yes") echo'- <img src="forum/pic/sticky.gif" />'; 
	echo'</a>';
	echo'</td><td><a href="profile.php?id=',$topics['creator_id'],'">',$topics['username'],'</a></td><td>',$topics['posts'],'</td><td>',date("n/j, Y, g:i A", $topics['create_date']),'</td><td>',date("n/j, Y, g:i A", $topics['recent_date']),'</td></tr>';
}
echo'</table>';
include'../footer.html';
?>
