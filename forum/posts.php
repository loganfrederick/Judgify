<?php
include'../layout.html';

$board_id=intval($_GET['bid']);
$topic_id=intval($_GET['tid']);

$select_topic=mysql_query("SELECT a.`title`,a.`board`,a.`status`,b.`name` FROM `forums_topics` a,`forums` b WHERE a.`topic_id`='$topic_id' AND a.`board`=b.`board_id`") or die(mysql_error());
$topic=mysql_fetch_assoc($select_topic);

echo'<h1>',$topic['name'],'</h1>';

if (!isset($_GET['bid']) || $topic['board']!=$board_id) {
	echo'<p>You reached this page improperly. Return back and try again.</p>';include'../footer.html';exit;
}

echo'<div class="forum_right_menu">';
if ($topic['status']!="closed" && isset($_COOKIE['judgify_login']) && isset($_SESSION['id'])) echo'<a href="forum/makepost.php?bid=',$board_id,'&tid=',$topic_id,'">Add Post</a> |';
else if ($topic['status']=="closed") { echo'<img src="forum/pic/closed.gif" /> | <strong>Topic Closed</strong>';
	if($_SESSION['level']>=40 && isset($_COOKIE["judgify_login"])) echo' | <a href="forum/closetopic.php?bid=',$board_id,'&tid=',$topic_id,'&f=close">Unlock Topic</a>';
}
if ($_SESSION['level']>=40 && $topic['status']!="closed") echo' <a href="forum/closetopic.php?bid=',$board_id,'&tid=',$topic_id,'&f=yes">Close Topic</a>';
echo'</div>';

echo'<a href="forum/index.php">Forums</a>- <a href="forum/topics.php?id=',$board_id,'">Topic List</a> | ';

//FSDKJDOFJIDJFOISJIOJDOJFISOJDIOJOSJIOFDSOIJFDSOI

$query=mysql_query("SELECT * FROM `forums_messages` WHERE `topic_id`='$topic_id'");
if(!$query) die(mysql_error());  
$total_items=mysql_num_rows($query);
	
$limit=10;
$page=$_GET['page'];
//if((!$limit)  || (is_numeric($limit) == false) || ($limit < 10) || ($limit > 50)) $limit=10; //default
if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) $page=1;//default

$total_pages=ceil($total_items / $limit);
$set_limit=$page*$limit-($limit);

$select_messages=mysql_query('SELECT a.*,b.`id`,b.`username` FROM `forums_messages` a, `user` b WHERE `topic_id`='.$topic_id.' AND a.`poster_id`=b.`id` ORDER BY `post_date` ASC LIMIT '.$set_limit.', '.$limit.'') or die(mysql_error());

if(!$select_messages) die(mysql_error());
$err=mysql_num_rows($select_messages);
if($err==0) die("No matches met your criteria.");
	
	/*show data matching query:
	echo'<span class="paginate">Posts:  
	<a href="'.$_SERVER['SCRIPT_NAME'].'?bid',$board_id,'&tid=',$topic_id,'&limit=10&page=1">10</a> | 
	<a href="'.$_SERVER['SCRIPT_NAME'].'?bid',$board_id,'&tid=',$topic_id,'&limit=25&page=1">25</a> | 
	<a href="'.$_SERVER['SCRIPT_NAME'].'?bid',$board_id,'&tid=',$topic_id,'&limit=50&page=1">50</a>';*/
	
	$prev_page=$page-1;
	echo'Pages:';
	if($prev_page>=1) echo('<strong><<</strong> <a href="'.$_SERVER['SCRIPT_NAME'].'?bid='.$board_id.'&tid='.$topic_id.'&limit='.$limit.'&page='.$prev_page.'"><strong>Prev.</strong></a>'); 

	for($a=1;$a<=$total_pages;$a++)
	{
		if($a == $page) echo('<strong> '.$a.'</strong> | '); //no link
		else echo('<a href="'.$_SERVER['SCRIPT_NAME'].'?bid='.$board_id.'&tid='.$topic_id.'&limit='.$limit.'&page='.$a.'"> '.$a.' </a> | ');
	}
	$next_page=$page+1;
	if($next_page<=$total_pages) echo('<a href="'.$_SERVER['SCRIPT_NAME'].'?bid='.$board_id.'&tid='.$topic_id.'&limit='.$limit.'&page='.$next_page.'"><b>Next</b></a> > >');
//FDKSFFDOSJFKDLSKFJLDKSJFKLSJDLKFJKLSDJFLKDSJKDFJLKDSJFKSJDLKFJ

echo'<div class="postlist_head">',$topic['title'],'</div>';

while($messages=mysql_fetch_assoc($select_messages)) {
	/*for($i=0;$i<10;$i++) {
		if($i % 2)
		{
			echo'<style type="text/css"> div.post {background: #FFFFFF;}</style>';
		}
		else {
			echo'<style type="text/css"> div.post {background: #C3D9FF;}</style>';
		}
	}*/
	echo'<div class="postdetail"><a href="forum/posts.php?bid=',$board_id,'&tid=',$topic_id,'#',$messages['message_id'],'" name="',$messages['message_id'],'">#</a> | <a href="profile.php?id=',$messages['poster_id'],'">',$messages['username'],'</a> | Posted: ',date("n/j, Y, g:i A", $messages['post_date']),'';
	if ($_SESSION['level']>=40 && $messages['first']!='yes') echo' | <a href="forum/delete.php?bid=',$board_id,'&tid=',$topic_id,'&mid=',$messages['message_id'],'">Delete</a>';
	if ($messages['first']=='yes' && $topic['status']!="closed" && $_SESSION['level']>=40) echo' | <a href="forum/closetopic.php?bid=',$board_id,'&tid=',$topic_id,'&f=yes">Close Topic</a>';
	echo' | <a href="report.php?bid=',$board_id,'&tid=',$topic_id,'&mid=',$messages['message_id'],'&uid=',$messages['id'],'">Report</a>';
	echo'</div>';
	echo'<div class="post">',stripslashes($messages['message']),'</div>';
}

if (($_SESSION['level']>0) && $topic['status']!="closed") {
	echo'<form action="forum/makepost.php?mode=post&bid=',$board_id,'&tid=',$topic_id,'" method="post" enctype="multipart/form-data" class="form">
	<fieldset>
	<legend>Quick Post</legend>
	<p><span class="par">(Available Tags: [url=Link to Site]Text Link[/url],[b]Bold Text[/b], [i]Italicize Text[/i])</span>: </p>
	<p><textarea name="text" rows="5" cols="55">A big post here</textarea></p>
	<p><input type="submit" name="submit" value="Post" /></p></fieldset></form>'; }

include'../footer.html';
?>
