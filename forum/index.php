<?php
include'../layout.html';

echo'<h1>Judgify Forums</h1>';

$select_cats=mysql_query("SELECT * FROM `forums_cats` ORDER BY `cat_order`") or die(mysql_error());
while($cats=mysql_fetch_assoc($select_cats)) {
	if(!isset($_SESSION['level'])) $_SESSION['level']=0;
	if($cats['cat_min']<=$_SESSION['level']) { echo'<table class="catlist"><th colspan=3>',$cats['cat_name'],'</th>';
		$select_boards=mysql_query("SELECT `name`,`board_id`,`category`,`num_topics`,`num_posts` FROM `forums` WHERE `category`=".$cats['cat_id']." AND `level_view`<=".$_SESSION['level']." ORDER BY `board_id`") or die(mysql_error());
		while($boards=mysql_fetch_assoc($select_boards)) {
			echo'<tr><td><a href="forum/topics.php?id=',$boards['board_id'],'">',$boards['name'],'</a></td><td>Topics: ',$boards['num_topics'],'</td><td>Posts: ',$boards['num_posts'],'</td></tr>';
		}
		echo'</table>';
	}
}

include'../footer.html';
?>
