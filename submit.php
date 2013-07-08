<?php
$title="Judgify- Submit";
include'layout.html';
//SONG
if ($_GET['cat']=="song" && isset($_COOKIE["judgify_login"])) {
	if (!empty($_POST['name']) && !empty($_POST['s_month']) && !empty($_POST['s_day']) && !empty($_POST['s_year'])) {
		$tmp=explode('.',$_FILES['img']['name']);
		$fileext=$tmp[count($tmp)-1];
		$file_name=$_FILES["img"]["name"];
		$file_name=str_replace(" ","_",$file_name);

		foreach ($_POST as $key=>$value) { $_POST[$key]=escape_chars_trim($value, $key);}$name=censor($_POST['name'],$censored);
		$count=mysql_query('SELECT COUNT(*) FROM `song` WHERE `name`="'.$name.'"') or die(mysql_error());$result=mysql_fetch_row($count);
		if ($result[0]>=1) {$page='submit.php?cat=song&msg=This%20title%20is%20already%20in%20use.';redirect($page);}
		else if (!is_numeric($_POST['s_year'])) {$page='submit.php?cat=song&msg=The%20year%20can%20only%20contain%20numbers.';redirect($page);}
		else if (strlen($_POST['name'])>30 || str_word_count($_POST['bio'])>1500) {$page='<p>The%20title%20can%20not%20be%20more%20than%2030%20letters%20long.%20The%20information%20must%20be%20less%20than%201,500%20words.</p>';redirect($page);}
		else if (!in_array($_POST['s_day'], $datearray) || !in_array($_POST['s_month'], $datearray)) {$page='<p>You%20did%20not%20correctly%20choose%20a%20day%20and/or%20month.</p>';redirect($page);}
		else if (!in_array($_POST['genre'], $song_genres)) {$page='<p>You%20did%20not%20correctly%20pick%20a%20genre.</p>';redirect($page);}
		else if ($_FILES['img']['size']>$pic_size) {$page='<p>Your%20image%20is%20too%20large%20to%20be%20uploaded.</p>';redirect($page);}
		else if (!in_array($fileext,$img_file_extensions)) {$page='<p>The%20file%20failed%20to%20upload%20because%20it%20was%20not%20an%20image.</p>';}
		else {
			$img=$movie_pic_upload_path.$file_name;
			move_uploaded_file($_FILES['img']['tmp_name'],$img);
			if (isset($_SESSION['id'])) $username=$_SESSION['id'];
			else $username=0;
			$band=$_POST['band'];$genre=$_POST['genre'];$bio=censor(bbcode_parse($_POST['bio']),$censored);$cat=$_GET['cat'];
			$start=$_POST['s_month'].' '.$_POST['s_day'].' '.$_POST['s_year'];$start=strtotime($start);$time=time();
			mysql_query("INSERT INTO `song` (`name`,`date_added`,`start`,`band`,`genre`,`img`,`bio`,`added_by`,`rate`,`votes`) VALUES ('$name','$time','$start','$band','$genre','$img','$bio','$username','10','1')") or die(mysql_error());
			$query=mysql_query("SELECT `id` FROM `$cat` WHERE `name`='$name'");$id=mysql_fetch_assoc($query);$id=$id['id'];
			mysql_query("INSERT INTO `votehistory` (`ipaddress`,`user_id`,`time`,`cat`,`item_id`,`vote`) VALUES ('$ipaddress','$username','$time','$cat','$id','10')") or die(mysql_error());
			mysql_query("UPDATE `user` SET num_entries=num_entries+1 WHERE `id`=$username") or die(mysql_error());
			echo'<p>Your song was submitted. <a href="index.php">Return to index.</a></p>';
		}
	}
	else {
		echo'<form action="submit.php?cat=song" method="post" enctype="multipart/form-data" class="form">
		<fieldset>
		<legend>Submit a Song</legend>
		<p>Name of Song: <input type="text" name="name" maxlength="30" /></p>
		<p>Released: Month- <select name="s_month"><option value="Jan">January</option><option value="Feb">February</option><option value="March">March</option><option value="April">April</option><option value="May">May</option><option value="June">June</option><option value="July">July</option><option value="Aug">August</option><option value="Sept">September</option><option value="Oct">October</option><option value="Nov">November</option><option value="Dec">December</option></select>
			Day- <select name="s_day"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>
			Year- <input type="text" name="s_year" maxlength="4" /></p>
		<p>Band: <input type="text" name="band" maxlength="30" /></p>
		<p>Genre: <select name="genre"><optgroup label="Genres"><option value="Blues/Jazz">Blues/Jazz</option>
			<option value="Country">Country</option>
			<option value="Classical/Orchestra">Classical/Orchestra</option>
			<option value="Dance">Dance</option>
			<option value="Gospel">Gospel</option>
			<option value="Hip-Hop">Hip-Hop</option>
			<option value="Metal">Metal</option>
			<option value="Other">Other</option>
			<option value="Pop">Pop</option>
			<option value="R&B">R&B</option>
			<option value="Reggae">Reggae</option>
			<option value="Rock">Rock</option>
			<option value="Techno">Techno</option></optgroup></select></p>
		<p>Upload a Song Image: <input type="file" name="img" size=30></p>
		<p>Information <span class="par">(Available Tags: [url=Link to Site]Text Link[/url],[b]Bold Text[/b], [i]Italicize Text[/i])</span>: </p>
		<p><textarea name="bio" rows="20" cols="55">A big load of text here</textarea></p>
		<p><input type="submit" value="Submit" /></p></fieldset></form>';
	}
}
//MOVIE
else if ($_GET['cat']=="movie" && isset($_COOKIE["judgify_login"])) {
	if (!empty($_POST['name']) && !empty($_POST['s_month']) && !empty($_POST['s_day']) && !empty($_POST['s_year'])) {
		$tmp=explode('.',$_FILES['img']['name']);
		$fileext=$tmp[count($tmp)-1];
		$file_name=$_FILES["img"]["name"];
		$file_name=str_replace(" ","_",$file_name);
		
		foreach ($_POST as $key=>$value) { $_POST[$key]=escape_chars_trim($value, $key);}$name=censor($_POST['name'],$censored);
		$count=mysql_query('SELECT COUNT(*) FROM `movie` WHERE `name`="'.$name.'"') or die(mysql_error());$result=mysql_fetch_row($count);
		if ($result[0]>=1) {$page='submit.php?cat=movie&msg=This%20title%20is%20already%20in%20use.';redirect($page);}
		else if ($_POST['s_month']=="February" && ($_POST['day']==30 || $_POST['day']==31)) {$page='<p>There%20is%20no%20February%2030th%20or%2031st.</p>';redirect($page);}
		else if (!is_numeric($_POST['s_year'])) {$page='submit.php?cat=song&msg=The%20year%20can%20only%20contain%20numbers.';redirect($page);}
		else if (strlen($_POST['name'])>30 || str_word_count($_POST['bio'])>1500) {$page='<p>The%20title%20can%20not%20be%20more%20than%2030%20letters%20long.%20The%20information%20must%20be%20less%20than%201,500%20words.</p>';redirect($page);}
		else if (!in_array($_POST['s_day'], $datearray) || !in_array($_POST['s_month'], $datearray)) {$page='<p>You%20did%20not%20correctly%20choose%20a%20day%20and/or%20month.</p>';redirect($page);}
		else if (!in_array($_POST['genre'], $movie_genres)) {$page='<p>You%20did%20not%20correctly%20pick%20a%20genre.</p>';redirect($page);}
		else if ($_FILES['img']['size']>$pic_size) {$page='<p>Your%20image%20is%20too%20large%20to%20be%20uploaded.</p>';redirect($page);}
		else if (!in_array($fileext,$img_file_extensions)) {$page='<p>The%20file%20failed%20to%20upload%20because%20it%20was%20not%20an%20image.</p>';}
		else {
			$img=$movie_pic_upload_path.$file_name;
			move_uploaded_file($_FILES['img']['tmp_name'],$img);
			if (isset($_SESSION['id'])) $username=$_SESSION['id'];
			else $username=0;
			$studio=$_POST['studio'];$director=$_POST['director'];$producer=$_POST['producer'];$writer=$_POST['writer'];$genre=$_POST['genre'];$bio=censor(bbcode_parse($_POST['bio']),$censored);$cat=$_GET['cat'];
			$start=$_POST['s_month'].' '.$_POST['s_day'].' '.$_POST['s_year'];$start=strtotime($start);$time=time();
			mysql_query("INSERT INTO `movie` (`name`,`date_added`,`start`,`studio`,`genre`,`director`,`producer`,`writer`,`img`,`bio`,`added_by`,`rate`,`votes`) VALUES ('$name','$time','$start','$studio','$genre','$director','$producer','$writer','$img','$bio','$username','10','1')") or die(mysql_error());
			$query=mysql_query("SELECT `id` FROM `$cat` WHERE `name`='$name'");$id=mysql_fetch_assoc($query);$id=$id['id'];
			mysql_query("INSERT INTO `votehistory` (`ipaddress`,`user_id`,`time`,`cat`,`item_id`,`vote`) VALUES ('$ipaddress','$username','$time','$cat','$id','10')") or die(mysql_error());
			mysql_query("UPDATE `user` SET num_entries=num_entries+1,points=points+3 WHERE `id`=$username") or die(mysql_error());
			echo'<p>Your movie was submitted. <a href="index.php">Return to index.</a></p>';
		}
	}
	else {
		echo'<form action="submit.php?cat=movie" method="post" enctype="multipart/form-data" class="form">
		<fieldset>
		<legend>Submit a Movie</legend>
		<p>Name of Movie: <input type="text" name="name" maxlength="30" /></p>
		<p>Released: Month- <select name="s_month"><option value="Jan">January</option><option value="Feb">February</option><option value="March">March</option><option value="April">April</option><option value="May">May</option><option value="June">June</option><option value="July">July</option><option value="Aug">August</option><option value="Sept">September</option><option value="Oct">October</option><option value="Nov">November</option><option value="Dec">December</option></select>
			Day- <select name="s_day"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>
			Year- <input type="text" name="s_year" maxlength="4" /></p>
		<p>Studio: <input type="text" name="studio" maxlength="30" /></p>
		<p>Genre: <select name="genre"><optgroup label="Genres">
			<option value="Action">Action</option>
			<option value="Comedy">Comedy</option>
			<option value="Drama">Drama</option>
			<option value="Horror">Horror</option>
			<option value="Mystery">Mystery</option>
			<option value="Other">Other</option>
			<option value="Romance">Romance</option>
			</optgroup></select></p>
		<p>Director: <input type="text" name="director" maxlength="30" /></p>
		<p>Producer: <input type="text" name="producer" maxlength="30" /></p>
		<p>Writer: <input type="text" name="writer" maxlength="30" /></p>
		<p>Upload a Movie Image: <input type="file" name="img" size=30></p>
		<p>Information <span class="par">(Available Tags: [url=Link to Site]Text Link[/url],[b]Bold Text[/b], [i]Italicize Text[/i])</span>: </p>
		<p><textarea name="bio" rows="20" cols="55">A big load of text here</textarea></p>
		<p><input type="submit" value="Submit" /></p></fieldset></form>';
	}
}
else if (!isset($_COOKIE["judgify_login"]) && !isset($_SESSION['id'])) {
	echo'<p>You will need to be <a href="login.php">logged in</a> to submit Judgify entries. If you haven\'t yet, try <a href="register.php">creating an account</a>!</p>';
}
else {
	echo'<dl class="center"><dt>Submit to a Category</dt>
	<dd><ul><li><a href="submit.php?cat=song">Submit a Song</a></li>
	<li><a href="submit.php?cat=movie">Submit a Movie</a></li></ul></dd></dl>';
}
include'footer.html';
?>
