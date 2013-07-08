<?php include'layout.html';
if (!empty($_POST['name']) && !empty($_POST['s_month']) && !empty($_POST['s_day']) && !empty($_POST['s_year']) && !empty($_POST['e_month']) && !empty($_POST['e_day']) && !empty($_POST['e_year'])) {
	//Image Parse
	$cert1 = "image/pjpeg";
	$cert2 = "image/jpeg";
	$cert3 = "image/gif";
	$cert4 = "image/png";
	$cert5 = "image/tiff";
	$cert6 = "image/bmp";
	$log = "";
	
	if ($img_name[$i] == "") $log .= "No file selected for upload.<br>";
	else {
		if (file_exists("$pic_upload_path/$img_name[$i]")) {
			$log .= "File already existed<br />";
		} 
		else {
			if (($sizelim == "yes") && ($img_size[$i] > $size)) $log .= "File was too big<br />";
			else {
				if (($img_type[$i] == $cert1) or ($img_type[$i] == $cert2) or ($img_type[$i] == $cert3) or ($img_type[$i] == $cert4) or ($img_type[$i] == $cert5) or ($img_type[$i] == $cert6)) {
					@copy($img[$i], "$pic_upload_path/$img_name[$i]") or $log .= "Couldn't copy image 1 to server<br />";
					if (file_exists("$pic_upload_path/$img_name[$i]")) $log .= "File was uploaded<br />";
				} 
				else $log .= "File is not an image<br />";
			}
		}
	}
	echo $log;
	//End Image Parse
	// 
	$birthdayarray=array('Jan','Feb','March','April','May','June','July','Aug','Sept','Oct','Nov','Dec','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');	
}
else if (isset($_GET['p'])) {
	$id=$_GET['p'];
	$query="SELECT (`id`,`name`,`date_added`,`start`,`end`,`birthday`,`pic`,`bio`,`added_by`) FROM `people` WHERE `id`='$id'";
	$data=mysql_fetch_assoc($query);
	echo'<table class="data">
	<tr><th colspan="2">',$data['name'],'</th></tr>
	<tr><td class="color">Name of Person:</td><td>',$data['name'],'</td></tr>
	<tr><td class="color">Date of Birth:</td><td>',$data['s_birth'],'</td></tr>
	<tr><td class="color">Date of Death:</td><td>',$data['s_death'],'</td></tr>
	<tr><td class="color">Date Added:</td><td>',$data['date_added'],'</td></tr>
	<tr><td class="color">Picture:</td><td><img src="pic/people',$data['pic'],'"></td></tr>
	<tr><td class="color">Biography:</td><td>',$data['bio'],'</td></tr>
	</table>';
}
else {
	echo'<form action="people.php" method="post" enctype="multipart/form-data" class="form">
	<fieldset>
	<legend>Submit a Person</legend>
	<p>Name of Person: <input type="text" name="name" maxlength="30" /></p>
	<p>Birthday: Month- <select name="s_month"><option value="Jan">January</option><option value="Feb">February</option><option value="March">March</option><option value="April">April</option><option value="May">May</option><option value="June">June</option><option value="July">July</option><option value="Aug">August</option><option value="Sept">September</option><option value="Oct">October</option><option value="Nov">November</option><option value="Dec">December</option></select>
		Day- <select name="s-day"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>
		Year- <select name="s_year">';
		for ($i=2006; $i>1965; $i--) { echo'<option value="'.$i.'">'.$i.'</option>';} echo'</select></p>
	<p>Death: Month- <select name="e_month"><option value="null">Not Dead</option><option value="Jan">January</option><option value="Feb">February</option><option value="March">March</option><option value="April">April</option><option value="May">May</option><option value="June">June</option><option value="July">July</option><option value="Aug">August</option><option value="Sept">September</option><option value="Oct">October</option><option value="Nov">November</option><option value="Dec">December</option></select>
		Day- <select name="e_day"><option value="null">Not Dead</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>
		Year- <select name="e_year"><option value="null">Not Dead</option>';
		for ($i=2006; $i>1930; $i--) { echo'<option value="'.$i.'">'.$i.'</option>';} echo'</select></p>
	<p>Birthplace: <input type="text" name="birthplace" maxlength="30" /></p>
	<p>Biography: </p>
	<p><textarea rows="30" cols="55">A big load of text here</textarea></p>
	<p>Upload Picture:<input type="file" name="pic" size="30" /></p>
	<p><input type="submit" value="Submit" /></p></fieldset></form>';
}
include'footer.html';
?>
