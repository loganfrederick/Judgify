<?php include'layout.html';
if (isset($_GET['id'])) {
	$id=intval($_GET['id']);
	$query=mysql_query("SELECT a.*,(`rate`/`votes`) AS `average`,b.`username`,b.`id` AS `u_id` FROM `movie` a, `user` b WHERE a.`id`='$id' AND `added_by`=b.`id`;");
	$data=mysql_fetch_assoc($query);
	echo'<table>
	<tr><th colspan="2">',$data['name'],'</th></tr>';
	echo'<tr><td class="color">Name of Movie:</td><td>',$data['name'],'</td></tr>
	<tr><td class="color">Added By:</td><td><a href="profile.php?id=',$data['u_id'],'">',$data['username'],'</a></td></tr>
	<tr><td class="color">Judge:</td><td> ';
    	for ($i=0;$i<=10;$i++) { echo '<a href="vote.php?cat=movie&id='.$id.'&vote='.$i.'">'.$i.'</a>'; if ($i!=10) echo ' | '; else echo'</td></tr>';}
	echo'<tr><td class="color">Average Score:</td><td>',$data['average'],' <span class="par">(based on ';
	if ($data['votes']==1) {$msg="vote";}else{$msg="votes";}
	echo $data['votes'],' ',$msg,')</span></td></tr>';
	if($data['start'])echo'<tr><td class="color">Released:</td><td>',date("F j, Y",$data['start']),'</td></tr>';
	if($data['studio'])echo'<tr><td class="color">Movie Studio:</td><td>',stripslashes($data['studio']),'</td></tr>';
	if($data['genre'])echo'<tr><td class="color">Genre:</td><td>',stripslashes($data['genre']),'</td></tr>';
	if($data['director'])echo'<tr><td class="color">Director:</td><td>',stripslashes($data['director']),'</td></tr>';
	if($data['producer'])echo'<tr><td class="color">Producer:</td><td>',stripslashes($data['producer']),'</td></tr>';
	if($data['writer'])echo'<tr><td class="color">Writer:</td><td>',stripslashes($data['writer']),'</td></tr>';
	if($data['date_added'])echo'<tr><td class="color">Date Added:</td><td>',date("F j, Y", $data['date_added']),'</td></tr>';
	$types=array();
	$query=mysql_query("SELECT `tags` FROM `movie` WHERE `id`='$id'") or die(mysql_error());
	while($ftypes=mysql_fetch_array($query)) {
		$types=array_merge($types, explode(",", $ftypes[0]));
	}
	$types=array_compact($types);
	if (!empty($types[0])) {
		echo'<tr><td class="color">Tags:</td><td>';
		for($i=0;$i<count($types);$i++) echo $types[$i].',';
	}
	if($data['img']) echo'<tr><td class="color">Image:</td><td><img src="',$data['img'],'" /></td></tr>';
	if($data['bio']) echo'<tr><td class="color">Information:</td><td>',stripslashes($data['bio']),'</td></tr>';
	echo'<tr><td class="color">Comment on ',stripslashes($data['name']),':</td><td><input type="button" value="Hide" class="buttonBslideup" />
	<input type="button" value="Show" class="buttonBslidedown" /></td></tr>
	<tr><td class="color">Report:</td><td><input type="button" value="Hide" class="buttonAslideup" />
	<input type="button" value="Show" class="buttonAslidedown" /></td></tr>
	</table>
	<div class="contentToChange">
	<div id="report" class="commentform"><form action="comment.php" method="post" enctype="multipart/form-data" class="form">
		<fieldset>
		<legend>Comment</legend>
		<input type="hidden" name="cat" value="movie" maxlength="30" />
		<input type="hidden" name="id" value="',$id,'" maxlength="30" />
		<p><span class="par">(Available Tags: [url=Link to Site]Text Link[/url],[b]Bold Text[/b], [i]Italicize Text[/i])</span>: </p>
		<p><textarea name="comment" rows="10" cols="55">Add your comment here....</textarea></p>
		<p><input type="submit" value="Submit" /></p></fieldset></form></div></div>
	<div class="contentToChange">
	<div id="report" class="reportform"><form action="report.php" method="post" enctype="multipart/form-data" class="form">
		<fieldset>
		<legend>Report this Entry</legend>
		<input type="hidden" name="cat" value="movie" maxlength="30" />
		<input type="hidden" name="id" value="',$id,'" maxlength="30" />
		<p>Reason: <select name="reason"><optgroup label="Reasons">
			<option value="cuss">Foul Language in Description</option>
			<option value="dupe">Duplicate Entry</option>
			<option value="inaccurate">Inaccurate Info</option></optgroup></select></p>
		<p>Explanation <span class="par">(Available Tags: [url=Link to Site]Text Link[/url],[b]Bold Text[/b], [i]Italicize Text[/i])</span>: </p>
		<p><textarea name="explain" rows="10" cols="55">Explain Here</textarea></p>
		<p><input type="submit" value="Submit" /></p></fieldset></form></div></div>';
	$query=mysql_query("SELECT a.*,b.`username`,b.`id` AS `userid` FROM `movie_comment` a, `user` b WHERE a.`item_id`='$id' and a.`from`=b.`id` ORDER BY a.`id`;") or die(mysql_error());
	while($data=mysql_fetch_assoc($query)) echo'<dl class="comment"><dt>Comment by: <a href="profile.php?id=',$data['userid'],'">',$data['username'],'</a> at ',date("F j, Y @ g:i A",$data['time']),'</dt><dd>',stripslashes($data['comment']),'</dd></dl>';
}
else {
	echo'<dl class="center"><dt>Movie<dt>
	<dd><ul><li><a href="submit.php?cat=movie">Submit a Movie</a></li>
	<li><a href="new.php?cat=movie">Newest Movie</a></li></ul></dd></dl>';
	
	echo'<div class="split">';
	echo'<table>
	<tr><th colspan="2">Newest Movies</th></tr>';
	$query=mysql_query("SELECT `id`,`name`,`date_added` FROM `movie` ORDER BY `id` DESC LIMIT 20");
	while ($data=mysql_fetch_assoc($query)) { echo'<tr><td class="color"><a href="movie.php?id=',$data['id'],'">',$data['name'],'</a></td><td>',date("F j, Y", $data['date_added']),'</td></tr>';}
	echo'</table>';
	echo'</div>';
	
	echo'<div class="split">';
	echo'<table>
	<tr><th colspan="2">Highest Rated Movie</th></tr>';
	$query=mysql_query("SELECT `id`,`name`,(`rate`/`votes`) AS `average` FROM `movie` WHERE `votes`>=3 ORDER BY `average` DESC LIMIT 10");
	while ($data=mysql_fetch_assoc($query)) { echo'<tr><td class="color"><a href="movie.php?id=',$data['id'],'">',$data['name'],'</a></td><td>Score: ',$data['average'],'</td></tr>';}
	echo'</table>';
	echo'</div>';
}
include'footer.html';
?>
