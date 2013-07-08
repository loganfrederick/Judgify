<?php 
$title="Judged: The Judgify Blog";
include'../layout.html';

echo'<h1>Judged: The Judgify Blog</h1>';

echo'<div class="box">Categories: <a href="blog/">All</a> | <a href="blog/index.php?announcements">Site Announcements</a> | <a href="blog/index.php?blog">Judged Blog</a></div>';

if(isset($_GET['announcements'])) {
	$query=mysql_query("SELECT a.`message`,b.`username`,b.`id`,c.`title`,c.`topic_id`,c.`board`,a.`post_date` FROM `forums_messages` a,`user` b,`forums_topics` c WHERE  b.`level`=50 AND c.`board`=3 AND a.`first`='yes' AND a.`topic_id`=c.`topic_id` ORDER BY a.`post_date` DESC LIMIT 5;");
	while ($data=mysql_fetch_assoc($query)) {
		echo'<div class="homepost">';
		echo'<h1>',$data['title'],'</h1>
		<span>Category: <a href="forum/topics.php?id=',$data['board'],'">Site Announcements</a></span><br />
		<span>Author: <a href="profile.php?id=',$data['id'],'">',$data['username'],'</a> on ',date("n/j, Y, g:i A", $data['post_date']),'</span><br />
		',stripslashes($data['message']),'
		<span><a href="forum/posts.php?bid=',$data['board'],'&tid=',$data['topic_id'],'">Comment</a></span>';
		echo'</div>';
	}
}
else if(isset($_GET['blog'])) {
	$query=mysql_query("SELECT a.`message`,b.`username`,b.`id`,c.`title`,c.`topic_id`,c.`board`,a.`post_date` FROM `forums_messages` a,`user` b,`forums_topics` c WHERE  b.`level`=50 AND c.`board`=5 AND a.`first`='yes' AND a.`topic_id`=c.`topic_id` ORDER BY a.`post_date` DESC LIMIT 5;");
	while ($data=mysql_fetch_assoc($query)) {
		echo'<div class="homepost">';
		echo'<h1>',$data['title'],'</h1>
		<span>Category: <a href="forum/topics.php?id=',$data['board'],'">Judged Blog</a></span><br />
		<span>Author: <a href="profile.php?id=',$data['id'],'">',$data['username'],'</a> on ',date("n/j, Y, g:i A", $data['post_date']),'</span><br />
		',stripslashes($data['message']),'
		<span><a href="forum/posts.php?bid=',$data['board'],'&tid=',$data['topic_id'],'">Comment</a></span>';
		echo'</div>';
	}
}
else {
	$query=mysql_query("SELECT a.`message`,b.`username`,b.`id`,c.`title`,c.`topic_id`,c.`board`,a.`post_date` FROM `forums_messages` a,`user` b,`forums_topics` c WHERE  b.`level`=50 AND (c.`board`=3 OR c.`board`=5) AND a.`first`='yes' AND a.`topic_id`=c.`topic_id` ORDER BY a.`post_date` DESC LIMIT 5;");
	while ($data=mysql_fetch_assoc($query)) {
		echo'<div class="homepost">';
		echo'<h1>',$data['title'],'</h1>
		<span>Category: ';
		if($data['board']==3) echo'<a href="forum/topics.php?id=3">Site Announcements</a>';
		else if($data['board']==5) echo'<a href="forum/topics.php?id=5">Judged Blog</a>';
		echo'</span>
		<br /><span>Author: <a href="profile.php?id=',$data['id'],'">',$data['username'],'</a> on ',date("n/j, Y, g:i A", $data['post_date']),'</span><br />
		',stripslashes($data['message']),'
		<span><a href="forum/posts.php?bid=',$data['board'],'&tid=',$data['topic_id'],'">Comment</a></span>';
		echo'</div>';
	}
}

include'../footer.html';
?>
