<?php include'../layout.html';
if ($_SESSION['level']>=40) {
	if (isset($_POST['action'])) {
		if ($_POST['action']=="Excuse") {
			mysql_query("DELETE FROM `modque` WHERE `id`=".$_POST['id']." LIMIT 1;") or die(mysql_error());
			redirect();
		}
		else if ($_POST['action']=="Delete") {
			mysql_query("DELETE FROM `modque` WHERE `id`=".$_POST['id']." LIMIT 1;") or die(mysql_error());
			mysql_query("DELETE FROM `".$_POST['cat']."` WHERE `id`=".$_POST['item_id'].";") or die(mysql_error());
			mysql_query("UPDATE `user` SET `num_entries`=`num_entries`-1,`points`=`points`-3 WHERE `id`=".$_POST['u_id'].";") or die(mysql_error());
		}
		else {
			echo'<p>You did not enter this with authority. Cease and desist.</p>';
		}
	}
	else { $query=mysql_query("SELECT a.*,b.`id` AS `u_id`,b.`username` AS `u_username` FROM `modque` a,`user` b WHERE b.`id`=a.`from`") or die(mysql_error());
	echo'<table>
	<tr><th colspan="7">Mod Queue</th></tr>
	<tr><td class="color">Report #</td><td>Submitted By</td><td>Time Added</td><td>Item</td><td>Reason</td><td>Explanation</td><td>Action</td></tr>';
	while ($data=mysql_fetch_assoc($query)) {
		echo'<tr><td class="color">Report #',$data['id'],':</td><td>',$data['u_username'],'</td><td>',date("F j, Y", $data['time']),'</td><td><a href="',$data['cat'],'.php?id=',$data['item_id'],'">',$data['cat'],' ',$data['item_id'],'</a></td><td>',$data['reason'],'</td><td>',$data['explain'],'</td><td>
		<form action="admin/modqueue.php" method="post"><input type="hidden" name="id" value="',$data['id'],'" />
		<input type="hidden" name="cat" value="',$data['cat'],'" />
		<input type="hidden" name="item_id" value="',$data['item_id'],'" />
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
