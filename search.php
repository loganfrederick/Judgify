<?php $title="Judgify- Search";
include'layout.html';

if($_GET['cat']=="all") {
	echo'<h1>Search Results</h1>';
	$entry=escape_chars_trim($_GET['entry'],"null");
	$query=mysql_query('(SELECT `id`,`username` AS `name`,"user" AS `User`,`joined` AS `date_added` FROM `user` WHERE `username` LIKE "%'.$entry.'%") UNION (SELECT `id`,`name`,"movie" AS `Movie`,`date_added` FROM `movie` WHERE `name` LIKE "%'.$entry.'%") UNION (SELECT `id`,`name`,"song" AS `Song`,`date_added` FROM `song` WHERE `name` LIKE "%'.$entry.'%") ORDER BY `date_added`') or die(mysql_error());
	echo'<table class="catlist"><th colspan=3>Results for: ',$entry,'</th>
	<tr class="color"><td>Category</td><td>Name</td><td>Added/Joined</td></tr>';
	while ($result=mysql_fetch_assoc($query)) {
		if(isset($result['User'])) echo'<tr><td>',$result['User'],'</td><td><a href="profile.php?id=',$result['id'],'">',$result['name'],'</a></td><td>',date("n/j, Y, g:i A",$result['date_added']),'</td></tr>';
		if(isset($result['Song'])) echo'<tr><td>',$result['Song'],'</td><td><a href="profile.php?id=',$result['id'],'">',$result['name'],'</a></td><td>',date("n/j, Y, g:i A",$result['date_added']),'</td></tr>';
		if(isset($result['Movie'])) echo'<tr><td>',$result['Movie'],'</td><td><a href="profile.php?id=',$result['id'],'">',$result['name'],'</a></td><td>',date("n/j, Y, g:i A",$result['date_added']),'</td></tr>';
	}
	echo'</table>';
}
else if($_GET['cat']=="user") {
	//ADD POINTS TO THIS
	echo'<h1>Search Results</h1>';
	$entry=escape_chars_trim($_GET['entry'],"null");
	$query=mysql_query("SELECT `id`,`username`,`points`,`joined` FROM `user` WHERE `username` LIKE '%".$entry."%'") or die(mysql_error());
	echo'<table class="catlist"><th colspan=2>Results for: ',$entry,'</th>
	<tr class="color"><td>User</td><td>Joined</td></tr>';
	while ($result=mysql_fetch_assoc($query)) {
		echo'<tr><td><a href="profile.php?id=',$result['id'],'">',$result['username'],'</a></td>'/*<td>',$result['points'],'</td>*/,'<td>',date("n/j, Y, g:i A",$result['joined']),'</td></tr>';
	}
	echo'</table>';
}
else if($_GET['cat']=="tag") {
	echo'<h1>Search Results</h1>';
	$entry=escape_chars_trim($_GET['entry'],"null");
	$query=mysql_query("SELECT `id`,`name`,`date_added`,(`rate`/`votes`) AS `average` FROM `song` WHERE `tags` LIKE '%$entry%';") or die(mysql_error());
	echo'<table class="catlist"><th colspan=3>Results for: ',$entry,'</th>
	<tr class="color"><td>Title</td><td>Score</td><td>Date Added</td></tr>';
	while ($result=mysql_fetch_assoc($query)) {
		echo'<tr><td><a href="song.php?id=',$result['id'],'">',stripslashes($result['name']),'</a></td><td>',$result['average'],'</td><td>',date("n/j, Y, g:i A",$result['date_added']),'</td></tr>';
	}
	echo'</table>';
}
else if($_GET['cat']=="song") {
	echo'<h1>Search Results</h1>';
	$entry=escape_chars_trim($_GET['entry'],"null");
	$query=mysql_query("SELECT `id`,`name`,`date_added`,(`rate`/`votes`) AS `average` FROM `song` WHERE `name` LIKE '%".$entry."%'") or die(mysql_error());
	echo'<table class="catlist"><th colspan=3>Results for: ',$entry,'</th>
	<tr class="color"><td>Title</td><td>Score</td><td>Date Added</td></tr>';
	while ($result=mysql_fetch_assoc($query)) {
		echo'<tr><td><a href="song.php?id=',$result['id'],'">',$result['name'],'</a></td><td>',$result['average'],'</td><td>',date("n/j, Y, g:i A",$result['date_added']),'</td></tr>';
	}
	echo'</table>';
}
else if($_GET['cat']=="movie") {
	echo'<h1>Search Results</h1>';
	$entry=escape_chars_trim($_GET['entry'],"null");
	$query=mysql_query("SELECT `id`,`name`,`date_added`,(`rate`/`votes`) AS `average` FROM `movie` WHERE `name` LIKE '%".$entry."%'") or die(mysql_error());
	echo'<table class="catlist"><th colspan=3>Results for: ',$entry,'</th>
	<tr class="color"><td>Title</td><td>Score</td><td>Date Added</td></tr>';
	while ($result=mysql_fetch_assoc($query)) {
		echo'<tr><td><a href="movie.php?id=',$result['id'],'">',$result['name'],'</a></td><td>',$result['average'],'</td><td>',date("n/j, Y, g:i A",$result['date_added']),'</td></tr>';
	}
	echo'</table>';
}

/*if($_GET['cat']=="user") {
	$cat=$_GET['cat'];
	$query=mysql_query("SELECT `id`,`username`,`joined`,`last_visit` FROM `user` WHERE `name` LIKE '%".$entry."%'") or die(mysql_error());
}
else if(isset($_GET['cat']) && in_array($cat,$cats)) {
	$cat=$_GET['cat'];
	$query=mysql_query("SELECT `id`,`name`,`date_added`,(`rate`/`votes`) AS `average` FROM `".$cat."` WHERE `name` LIKE '%".$entry."%'") or die(mysql_error());
}

if($_GET['by']=="title") {
	
}

if (isset($_GET['cat']) && isset($_GET['by'])) {
	echo'<h1>Search Results</h1>';
	$entry=escape_chars_trim($_GET['entry'],"null");
	$query=mysql_query("SELECT `id`,`name`,`date_added`,(`rate`/`votes`) AS `average` FROM `movie` WHERE `name` LIKE '%".$entry."%'") or die(mysql_error());
	echo'<table class="catlist"><th colspan=3>Results for: ',$entry,'</th>
	<tr class="color"><td>Title</td><td>Score</td><td>Date Added</td></tr>';
	while ($result=mysql_fetch_assoc($query)) {
		echo'<tr><td><a href="movie.php?id=',$result['id'],'">',stripslashes($result['name']),'</a></td><td>',$result['average'],'</td><td>',date("n/j, Y, g:i A",$result['date_added']),'</td></tr>';
	}
	echo'</table>';
}
else {
	echo'<form action="search.php" method="get" class="form">
	<fieldset>
	<legend>Advanced Search</legend>
	<p>Category: <select name="cat"><option value="all">All</option><option value="user">Users</option><option value="song">Songs</option><option value="movie">Movie</option></select></p>
	<p>Search By: <select name="by"><option value="title">Title</option><option value="other">Person/Company</option><option value="tag">Tags</option><option value="description">Description</option></select></p>
	<p>Time: <select name="time"><option value="7">Last Week</option><option value="30">Last Month</option><option value="all">All Time</option></select></p>
	<p>Search: <input name="entry" maxlength=50 /></p>
	<p></p>
	<p><input type="submit" value="Submit" /></p></form>';
}*/
include'footer.html'; ?>
