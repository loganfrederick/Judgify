<?php include'../layout.html';
if ($_SESSION['level']>=40) {
	if (isset($_POST['action'])) {
		if ($_POST['action']=="Excuse") {
			$mid=intval($_POST['mid']);
			mysql_query("DELETE FROM `forumque` WHERE `mid`=".$_POST['mid']." LIMIT 1;") or die(mysql_error());
			redirect();
		}
		else if ($_POST['action']=="Delete") {
			$mid=intval($_POST['mid']);
			mysql_query("DELETE FROM `forumque` WHERE `mid`=".$_POST['mid'].";") or die(mysql_error());
			mysql_query("DELETE FROM `forums_messages` WHERE `id`=".$_POST['mid'].";") or die(mysql_error());
			//mysql_query("UPDATE `user` SET `num_posts`=`num_posts`-1,`num_points`=`num_points`-1 WHERE `id`=".$_POST['u_id'].";") or die(mysql_error());
		}
		else {
			echo'<p>You did not enter this with authority. Cease and desist.</p>';
		}
	}
	else { $query=mysql_query("SELECT a.*,b.`id` AS `u_id`,b.`username` FROM `forumque` a,`user` b WHERE b.`id`=a.`from`") or die(mysql_error());
		echo'<table>
		<tr><th colspan="7">Forum Queue</th></tr>
		<tr><td class="color">Report #</td><td>Submitted By</td><td>Posted By</td><td>Time Added</td><td>Message</td><td>Reason</td><td>Action</td></tr>';
		while ($data=mysql_fetch_assoc($query)) {
			echo'<tr><td class="color">Report #',$data['id'],':</td><td>',$data['username'],'</td><td>',$data['poster'],'</td><td>',date("n/j, Y, g:i A", $data['time']),'</td><td><a href="../forum/posts.php?bid=',$data['bid'],'&tid=',$data['tid'],'#',$data['mid'],'">#',$data['mid'],'</a></td><td>',$data['reason'],'</td><td>
			<form action="admin/forumqueue.php" method="post"><input type="hidden" name="id" value="',$data['id'],'" />
			<input type="hidden" name="mid" value="',$data['mid'],'" />
			<input type="hidden" name="u_id" value="',$data['u_id'],'" />
			<select name="action"><optgroup label="Actions">
			<option value="Excuse">Excuse</option><option value="Delete">Delete</option>
			<input type="submit" value="Submit" /></form>
			</td></tr>';
		}
		echo'</table>';
	}
}
else {
	echo'<p>You are not authorized to use this page. Therefore, you must leave now or our head of security, Bruce Willis, will find you.</p>';
}

include'../footer.html';
?>
