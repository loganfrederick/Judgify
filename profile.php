<?php include'layout.html';
if(isset($_GET['addfriend']) && isset($_GET['id']) && isset($_SESSION['id'])) {
	$user=$_SESSION['id'];$friend=$_GET['id'];$time=time();
	$count=mysql_query("SELECT COUNT(*) FROM `friends` WHERE (`user`='".$user."' AND `friend`='".$friend."') OR (`user`='".$friend."' AND `friend`='".$user."')") or die(mysql_error());
	$result=mysql_fetch_row($count);
	if($result[0]==0) {
		mysql_query("INSERT INTO `friends` (`user`,`friend`,`date`) VALUES ('$user','$friend','$time')") or die(mysql_error());
	}
	redirect();
}

if (isset($_GET['id']) && ($_GET['id']!=$_SESSION['id'])) {
	echo'<div class="box">Sections: <a href="profile/'.$_GET['id'].'/">Profile</a> | <a href="profile.php?friends&id='.$_GET['id'].'">Friends</a> | <a href="profile.php?recentforums&id='.$_GET['id'].'">Forum Posts</a>';
	$count=mysql_query("SELECT COUNT(*) FROM `friends` WHERE (`user`='".$_SESSION['id']."' AND `friend`='".$_GET['id']."') OR (`user`='".$_GET['id']."' AND `friend`='".$_SESSION['id']."')") or die(mysql_error());
	$result=mysql_fetch_row($count);
	if(isset($_SESSION['id']) && $result[0]==0) echo' | <a href="profile.php?addfriend&id='.$_GET['id'].'">Add to Friends</a>';
	echo'</div>';

	if(isset($_GET['recentforums'])) {
		$count=mysql_query("SELECT COUNT(*) FROM `forums` a,`forums_messages` b,`forums_topics` c WHERE b.`poster_id`='".$id."' AND b.`topic_id`=c.`topic_id` AND a.`board_id`=c.`board`") or die(mysql_error());
		$result=mysql_fetch_row($count);
		if($result[0]>0) {
			$query=mysql_query("SELECT a.`board_id`,c.`title`,c.`topic_id`,b.`message` FROM `forums` a,`forums_messages` b,`forums_topics` c WHERE b.`poster_id`='".$id."' AND b.`topic_id`=c.`topic_id` AND a.`board_id`=c.`board` ORDER BY b.`post_date` DESC LIMIT 10;") or die(mysql_error());
			echo'<table>
			<tr><th colspan="2">Recent Forum Posts</th></tr>';
			while($info=mysql_fetch_assoc($query)) {
				echo'<tr><td class="color"><a href="forum/posts.php?bid='.$info['board_id'].'&tid='.$info['topic_id'].'">'.$info['title'].'</a></td><td>'.cutoff(strip_tags(stripslashes($info['message'])),10).'</td></tr>';
			}
			echo'</table>';
		}
	}
	else if(isset($_GET['friends'])) {
		$id=intval($_GET['id']);$query=mysql_query("SELECT b.`username`,a.`friend`,a.`date` FROM `friends` a,`user` b WHERE a.`user`='".$id."' AND a.`friend`=b.`id` ORDER BY a.`date` DESC LIMIT 10;") or die(mysql_error());
		echo'<table>
		<tr><th colspan="2">Friends</th></tr>';
		while($info=mysql_fetch_assoc($query)) {
			echo'<tr><td class="color"><a href="profile/'.$info['friend'].'/">'.$info['username'].'</a></td><td>',date("F j, Y", $info['date']),'</td></tr>';
		}
		echo'</table>';
	}
	else {
		$id=intval($_GET['id']);
		$query=mysql_query("SELECT a.*,CONCAT(a.first_name, ' ', a.last_name) AS `name`,b.`title` FROM `user` a,`userlevel` b WHERE a.`id`='".$id."' AND a.`level`=b.`rank`") or die(mysql_error());
		$user=mysql_fetch_assoc($query);
		echo'<table>
		<tr><th colspan="2">',$user['username'],'</th></tr>
		<tr><td class="color">User Level:</td><td>(',$user['level'],') ',$user['title'],' User</td></tr>
		<tr><td class="color">Email:</td><td>',$user['pub_email'],'</td></tr>
		<tr><td class="color">Name:</td><td>',$user['name'],'</td></tr>
		<tr><td class="color">Last Visit:</td><td>',date("F j, Y", $user['last_visit']),'</td></tr>
		<tr><td class="color">Joined:</td><td>',date("F j, Y", $user['joined']),'</td></tr>
		<tr><td class="color">Number of Entries:</td><td>',$user['num_entries'],'</td></tr>
		<tr><td class="color">Forum Posts:</td><td>',$user['num_posts'],'</td></tr>
		<tr><td class="color">Comments Posted:</td><td>',$user['num_comments'],'</td></tr>
		</table>';
	}
}
else if (isset($_GET['id']) && ($_GET['id']==$_SESSION['id'])) {
	echo'<div class="box">Sections: <a href="profile.php?edit&id='.$_SESSION['id'].'">Edit Profile</a> | <a href="profile/'.$_SESSION['id'].'/">Profile</a> | <a href="profile.php?friends&id='.$_SESSION['id'].'">Friends</a> | <a href="profile.php?recentforums&id='.$_SESSION['id'].'">Forum Posts</a></div>';

	$id=intval($_SESSION['id']);
	echo'<h1>Your Profile</h1>';
	
	if (isset($_GET['msg']) && in_array($_GET['msg'],$msgs)) echo'<div class="announce">Message: ',$_GET['msg'],'</div>';
	else if(isset($_POST['pri_email']) && isset($_GET['edit'])) {
		/*$name=$escape_string(strip_tags(trim($_POST['name'], ENT_QUOTES)));*/$f_name=$escape_string(strip_tags(trim($_POST['f_name'], ENT_QUOTES)));$l_name=$escape_string(strip_tags(trim($_POST['l_name'], ENT_QUOTES)));
		$password=$escape_string(strip_tags(trim($_POST['password'])));$password=hash('whirlpool',$password);
		$password2=$escape_string(strip_tags(trim($_POST['password2'])));$password2=hash('whirlpool',$password2);
		$joined=time();$pri_email=strip_tags(trim($_POST['pri_email'], ENT_QUOTES));$pub_email=strip_tags(trim($_POST['pri_email'], ENT_QUOTES));
		//$count=mysql_query('SELECT COUNT(*) FROM `user` WHERE `username`="'.$name.'"') or die(mysql_error());$result=mysql_fetch_row($count);
		$query=mysql_query("SELECT `username` FROM `user` WHERE `id`='$id'") or die(mysql_error());$user=mysql_fetch_assoc($query);
		//if ($result[0]>=1 && $name!=$user['username']) {$page='profile.php?msg=This%20username%20is%20already%20in%20use.';redirect($page);}
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['pri_email']) || !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['pub_email'])) {$page='profile.php?msg=The%20email%20was%20not%20valid.';redirect($page);}
		else {
			$id=$_SESSION['id'];$_GET['msg']="<p>You're profile has been updated.</p>";
			mysql_query("UPDATE `user` SET `password`='$password',`pri_email`='$pri_email',`pub_email`='$pub_email',`first_name`='$f_name',`last_name`='$l_name' WHERE `id`='$id'") or die(mysql_error());
			echo'<form class="smallform" action="profile.php" method="post">
			<fieldset>',$_GET['msg'],'</fieldset></form>';
		}
	}
	else if(isset($_GET['edit'])) {
		$id=intval($_SESSION['id']);
		$query=mysql_query("SELECT a.*,CONCAT(a.first_name, ' ', a.last_name) AS `name`,b.`title` FROM `user` a,`userlevel` b WHERE a.`id`='".$id."' AND a.`level`=b.`rank`") or die(mysql_error());
		$user=mysql_fetch_assoc($query);
		echo'<form class="form" action="profile.php?id=',$id,'" method="post">
		<fieldset>
		<legend>Edit Profile</legend>';
		//<p>Username:<input type="text" name="name" maxlength="30" value="',$user['username'],'" /></p>
		echo'<p>Private Email:<input type="text" name="pri_email" maxlength="30" value="',$user['pri_email'],'" /></p>
		<p>Public Email:<input type="text" name="pub_email" maxlength="30" value="',$user['pub_email'],'" /></p>
		<p>First name:<input type="text" name="f_name" maxlength="30" value="',$user['first_name'],'" /></p>
		<p>Last name:<input type="text" name="l_name" maxlength="30" value="',$user['last_name'],'" /></p>
		<p><input type="submit" value="Submit" /></p></fieldset></form>';
	}
	else if(isset($_GET['friends'])) {
		$id=intval($_SESSION['id']);$query=mysql_query("SELECT b.`username`,a.`friend`,a.`date` FROM `friends` a,`user` b WHERE a.`user`='".$id."' AND a.`friend`=b.`id` ORDER BY a.`date` DESC LIMIT 10;") or die(mysql_error());
		echo'<table>
		<tr><th colspan="2">Friends</th></tr>';
		while($info=mysql_fetch_assoc($query)) {
			echo'<tr><td class="color"><a href="profile/'.$info['friend'].'/">'.$info['username'].'</a></td><td>',date("F j, Y", $info['date']),'</td></tr>';
		}
		echo'</table>';
	}
	else if(isset($_GET['recentforums'])) {
		$id=intval($_SESSION['id']);$query=mysql_query("SELECT a.`board_id`,c.`title`,c.`topic_id`,b.`message` FROM `forums` a,`forums_messages` b,`forums_topics` c WHERE b.`poster_id`='".$id."' AND b.`topic_id`=c.`topic_id` AND a.`board_id`=c.`board` ORDER BY b.`post_date` DESC LIMIT 10;") or die(mysql_error());
		echo'<table>
		<tr><th colspan="2">Recent Forum Posts</th></tr>';
		while($info=mysql_fetch_assoc($query)) {
			echo'<tr><td class="color"><a href="forum/posts.php?bid='.$info['board_id'].'&tid='.$info['topic_id'].'">'.$info['title'].'</a></td><td>'.cutoff(strip_tags(stripslashes($info['message'])),7).'</td></tr>';
		}
		echo'</table>';
	}
	else {
		$id=intval($_SESSION['id']);$query=mysql_query("SELECT a.*,CONCAT(a.first_name, ' ', a.last_name) AS `name`,b.`title` FROM `user` a,`userlevel` b WHERE a.`id`='".$id."' AND a.`level`=b.`rank`") or die(mysql_error());
		$user=mysql_fetch_assoc($query);
		echo'<table>
		<tr><th colspan="2">',$user['username'],'</th></tr>
		<tr><td class="color">User Level:</td><td>(',$user['level'],') ',$user['title'],' User</td></tr>
		<tr><td class="color">Private Email:</td><td>',$user['pri_email'],'</td></tr>
		<tr><td class="color">Public Email:</td><td>',$user['pub_email'],'</td></tr>
		<tr><td class="color">Name:</td><td>',$user['name'],'</td></tr>
		<tr><td class="color">Last Visit:</td><td>',date("F j, Y", $user['last_visit']),'</td></tr>
		<tr><td class="color">Joined:</td><td>',date("F j, Y", $user['joined']),'</td></tr>
		<tr><td class="color">Number of Entries:</td><td>',$user['num_entries'],'</td></tr>
		<tr><td class="color">Forum Posts:</td><td>',$user['num_posts'],'</td></tr>
		<tr><td class="color">Comments Posted:</td><td>',$user['num_comments'],'</td></tr>
		</table>';
	}
}
else {
	echo'<div class="split"><table>
	<tr><th colspan="2">Newest Members</th></tr>';
	$query=mysql_query("SELECT `id`,`username`,`joined` FROM `user` ORDER BY `id` DESC LIMIT 20");
	while ($data=mysql_fetch_assoc($query)) { echo'<tr><td class="color"><a href="profile.php?id=',$data['id'],'">',$data['username'],'</a></td><td>',date("F j, Y", $data['joined']),'</td></tr>';}
	echo'</table></div>';

	echo'<div class="split2"><table>
	<tr><th colspan="2">Most Contributions</th></tr>';
	$query=mysql_query("SELECT `id`,`username`,`num_entries` FROM `user` ORDER BY `num_entries` DESC LIMIT 20");
	while ($data=mysql_fetch_assoc($query)) { echo'<tr><td class="color"><a href="profile.php?id=',$data['id'],'">',$data['username'],'</a></td><td>',$data['num_entries'],' Submissions</td></tr>';}
	echo'</table></div>';
}
include'footer.html';
?>
