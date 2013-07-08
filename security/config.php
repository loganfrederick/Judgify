<?php
// Connection Information
$dbhost= "localhost";
$dbuser= "";
$dbpass= "";
$dbname= "";
$db = mysql_connect($dbhost, $dbuser, $dbpass) or die("<b>Error:</b> Failed to connect to database");
mysql_select_db($dbname, $db) or die("<b>Error:</b> Failed to select database");

// Variable Functions
$escape_string="mysql_real_escape_string";

// Variables
$movie_pic_upload_path="pic/movie/";
$song_pic_upload_path="pic/song/";
$comic_pic_upload_path="comic/images/";
$pic_size = "100000"; //What do you want size limited to be if there is one
$ipaddress=$_SERVER['REMOTE_ADDR'];
$spell_lang=pspell_new("en");
//$browser=get_browser();

//Arrays
$img_file_extensions=array("gif","jpg","jpeg","bmp","png");
$datearray=array('Jan','Feb','March','April','May','June','July','Aug','Sept','Oct','Nov','Dec','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$cats=array('user','song','movie');
$msgs=array('The entry was not a number.','Your topic was added.','Your post was added.','The post can not be less than 5 characters.','The post must be less than 1,500 words.','Your comment has been added.','The file failed to upload because it was not an image.','Your image is too large to be uploaded.','You did not correctly pick a genre.','You did not correctly choose a day and/or month.','The title can not be more than 30 letters long. The information must be less than 1,500 words.','There is no February 30th or 31st.','The year can only contain numbers.','Your report has been sent.','This title is already in use.','Vote Added!','Error With Vote!','Vote Changed!','You must fill in your name and password.','This username is already in use.','Your passwords did not match.','The e-mail was not valid.');
$song_genres=array('Blues/Jazz','Classical/Orchestra','Dance','Gospel','Hip-Hop','Metal','Other','Pop','R&B','Reggae','Rock','Techno');
$movie_genres=array('Action','Comedy','Drama','Horror','Mystery','Other','Romance');
$censored=array("fuck", "nigga", "nigge", "echo j","format c:","fcuk","fuk","ngg","cunt","bitch");
$report_reasons=array('inaccurate','cuss','dupe');
$forum_report_reasons=array('cuss','flame','spam','spoil','other');

// Other Functions
function bbcode_parse($text) {
	$patterns = array("/\[url\](.*?)\[\/url\]/","/\[url\=(.*?)\](.*?)\[\/url\]/is","/\[b\](.*?)\[\/b\]/","/\[i\](.*?)\[\/i\]/"); 
	$replacements = array("<a href=\"\\1\">\\1</a>","<a href=\"\\1\">\\2</a>","<strong>\\1</strong>","<em>\\1</em>"); 
	$text=preg_replace($patterns,$replacements,$text);
	return $text;
}

function escape_chars_trim($input, $key) {
	$input=mysql_real_escape_string(trim(htmlentities($input)));
	if ($key=="null");
	else if ($key!="bio" && $key!="explain" && $key!="comment") $input= str_replace("\n", " ", $input);
	else {
		$input='<p>'.str_replace('\r\n\r\n', '</p><p>', $input).'</p>';
	}
	return $input;
}

function redirect($page) {
	if (!isset($page)) $page=$_SERVER['HTTP_REFERER'];
	header('Location: '.$page);exit;
}

function addVote($id, $user_id, $vote, $cat) {
	if (!isset($user_id)) $user_id=0;$ipaddress=$_SERVER['REMOTE_ADDR'];
	$count=mysql_query('SELECT COUNT(*) FROM `votehistory` WHERE `ipaddress`="'.$ipaddress.'" AND `user_id`="'.$user_id.'" AND `cat`="'.$cat.'" AND `item_id`='.$id.'') or die(mysql_error());
	$result=mysql_fetch_row($count);
	$time=time();
	
	//Check if it has been voted for already by this user
	if ($result[0]>=1) {
		$oldvote=mysql_query('SELECT `vote` FROM `votehistory` WHERE `ipaddress`="'.$ipaddress.'" OR `user_id`="'.$user_id.'" AND `cat`="'.$cat.'" AND `item_id`='.$id.' ORDER BY `id` DESC LIMIT 1') or die(mysql_error());
		$result=mysql_fetch_row($oldvote);
		mysql_query("UPDATE `$cat` SET `rate`=`rate`+".($vote-$result[0])." WHERE `id`='$id'") or die(mysql_error());
		mysql_query("INSERT INTO `votehistory` (`ipaddress`, `user_id`,`time`,`cat`, `item_id`, `vote`) VALUES ('$ipaddress', '$user_id','$time','$cat','$id','$vote')") or die(mysql_error());
		return 2;
	}
	else {
		mysql_query("UPDATE `$cat` SET `rate`=`rate`+$vote,`votes`=`votes`+1 WHERE `id`='$id'") or die(mysql_error());
		mysql_query("INSERT INTO `votehistory` (`ipaddress`, `user_id`,`time`,`cat`, `item_id`, `vote`) VALUES ('$ipaddress', '$user_id','$time','$cat','$id','$vote')") or die(mysql_error());
		return 1;
	}
}

function censor($body,$censored,$replace=1) {
	foreach($censored as &$notallowed) { 
	// This puts the regex modifications on the string. I did this so you dont need to add regex yourself...
		$notallowed = str_pad($notallowed, (strlen($notallowed) + 1), "/", STR_PAD_LEFT);
		$notallowed = str_pad($notallowed, (strlen($notallowed) + 2), "/i");
		$regex = 3;
	}
	if($replace == 1) {
		foreach($censored as $nA) { // Loops through whole array
			$starred = '';
			for($i = 0; $i < (strlen($nA) - $regex); $i++) { 
				// Will loop through to add each star based on word length minus the regex characters (7)
				$starred .= "*";
			}
			$starred_out[] = $starred; // Send the starrs to a new array
			unset($starred); // unset that "counter" star
		}
		$body = preg_replace($censored, $starred_out, $body); // Replace!
	} else {
		foreach($censored as $notAllowed) { // Preg_match_all only accepts strings
			if(preg_match_all($notAllowed, $body, $out) == TRUE) { // if you find a match
				foreach($out[0] as $oot) { // Set them
					$banned_words[] = $oot;
				}
			}
		}
	}
	return $body;
}

function constant_login() {
if (isset($_COOKIE["judgify_login"]) && isset($_COOKIE["judgify_login_name"]))
{
	$user_query=mysql_query("SELECT `id`,`level` FROM `user` WHERE `username`='".$_COOKIE["judgify_login_name"]."' AND `password`='".$_COOKIE["judgify_login"]."'") or die(mysql_error());
	if (mysql_num_rows($user_query)==1) {
		$user=mysql_fetch_assoc($user_query);
		$_SESSION['level']=$user['level'];$_SESSION['id']=$user['id'];$last_visit=time();
		mysql_query("UPDATE `user` SET `last_visit`=".$last_visit." WHERE `id`='".$user['id']."'") or die(mysql_error());
	}
}
}

function spellcheck(&$string)
{
	$words = array_unique(preg_split('/[^a-zA-Z]/', strtolower(trim($string)), -1, PREG_SPLIT_NO_EMPTY));
	$dict = pspell_new('en', 'american');
	$return = '';

	foreach ($words as $word)
	{
		if (!pspell_check($dict, $word))
		{
			$string = preg_replace("/([^a-zA-Z])($word)([^a-zA-Z])/i", "$1<span style='color: red;'>$2</span>$3", $string);
			$return .= sprintf('<li><strong>%s:</strong> %s</li>', ucfirst($word), implode(', ', pspell_suggest($dict, $word)));
		}
	}

	return ($return ? "<ul style='list-style-type: none;'>$return</ul>" : false);
}


function cutoff($message, $cutoff) {
	// Use a logical cutoff for the user. Just add one.
        $cutoff++;
        // Explode by space = word
        $message=explode(" ", $message, $cutoff);
        // Chop off anything after the cuttoff + 1. array_pop will push our array to only $cutoff - 1 which is why we added one.
        array_pop($message);
        // Reset the cutoff number
        $cutoff--;
        // Create a string out of it
        $outstring='';
        foreach($message as $key => $val) {
            $outstring.=' '.$val;
        }
	return $outstring.'...';
}

function array_compact($a){
  $tmparr = array_unique($a);
  $i=0;
  foreach ($tmparr as $v) {
    $newarr[$i] = $v;
    $i++;
  }
  return $newarr;
}

function passgen(){
	$var1 = array ("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

	srand((double)microtime()*1000000);
        $charX1 = rand(1,25);
	$charX2 = rand(1,25);
	$charX3 = rand(1,25);
	$charX4 = rand(1,25);
	$charX5 = rand(1,25);
	$charX6 = rand(1,25);
	$charX7 = rand(1,25);
	$charX8 = rand(1,25);
	$charX9 = rand(1,25);
	$charX10 = rand(1,25);
	$charX11 = rand(1,25);
	$charX12 = rand(1,25);
	$charX13 = rand(1,25);
	$charX14 = rand(1,25);
	$charX15 = rand(1,25);

	$var2 = array("$var1[$charX1]","$charX2","$var1[$charX3]","$charX4","$var1[$charX5]","$charX6","$var1[$charX7]","$charX7","$var1[$charX8]","$charX9","$var1[$charX10]","$charX11","$var1[$charX12]","$charX13","$var1[$charX14]","$charX15");

	$charVar1 = rand(1,10);
	$charVar2 = rand(1,10);
	$charVar3 = rand(1,10);
	$charVar4 = rand(1,10);
	$charVar5 = rand(1,10);
	$charVar6 = rand(1,10);
	$charVar7 = rand(1,10);
	$charVar8 = rand(1,10);
	$charVar9 = rand(1,10);
	$charVar10 = rand(1,10);

	$randpass=$var2[$charVar1].$charVar2.$var2[$charVar3].$charVar4.$var2[$charVar5].$charVar6.$var2[$charVar7].$charVar8.$var2[$charVar9].$charVar10;
	return $randpass;
}

// Queries
$result_update=mysql_query('SELECT * FROM `messages` WHERE `board`=1 ORDER BY `id` DESC LIMIT 6');

session_start();
ob_start('ob_gzhandler');
?>
