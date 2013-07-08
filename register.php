<?php
$title="Judgify- Register";
include'layout.html';
if(isset($_GET['username']) || isset($_GET['password']))  {
	echo'<p>This is likely a hacker attempt, and that is not appreciated.</p>';
	include'footer.html';exit();
}
if(isset($_POST['name'])) {
	$name=$escape_string(strip_tags(trim($_POST['name'], ENT_QUOTES)));$f_name=$escape_string(strip_tags(trim($_POST['f_name'], ENT_QUOTES)));$l_name=$escape_string(strip_tags(trim($_POST['l_name'], ENT_QUOTES)));
	$password=$escape_string(strip_tags(trim($_POST['password'])));$password=hash('whirlpool',$password);
	$password2=$escape_string(strip_tags(trim($_POST['password2'])));$password2=hash('whirlpool',$password2);
	$joined=time();$pri_email=strip_tags(trim($_POST['pri_email'], ENT_QUOTES));$pub_email=strip_tags(trim($_POST['pri_email'], ENT_QUOTES));
	$count=mysql_query('SELECT COUNT(*) FROM `user` WHERE `username`="'.$name.'"') or die(mysql_error());$result=mysql_fetch_row($count);
	$randpass=passgen().passgen();$pass=hash('whirlpool',$randpass);
	if ($result[0]>=1) {$page='register.php?msg=This%20username%20is%20already%20in%20use.';redirect($page);}
	if(empty($name) || empty($password)) {$page='register.php?msg=You%20must%20fill%20in%20your%20name%20and%20password.';redirect($page);}
	if($password!=$password2) {$page='register.php?msg=Your%20passwords%20did%20not%20match.';redirect($page);}
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['pri_email']) /*|| !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['pub_email'])*/) {$page='register.php?msg=The%20email%20was%20not%20valid.';redirect($page);}
	mysql_query("INSERT INTO `user` (`username`,`password`,`pri_email`,`pub_email`,`first_name`,`last_name`,`level`,`joined`,`last_visit`,`passkey`) VALUES ('$name','$password','$pri_email','$pub_email','$f_name','$l_name',1,'$joined','$joined','$pass')") or die(mysql_error());
	echo'<p>Your account has been registered. Head over to the <a href="login.php">login page</a> to use your account.</p>';
}
else if (isset($login_cookie)) echo'<p>You are logged in already.</p>';
else {
	if (isset($_GET['msg']) && in_array($_GET['msg'],$msgs)) echo'<span class="req">',$_GET['msg'],'</span>';
	echo('<form action="register.php" method="post">
	<fieldset>
	<legend>Register For Free</legend>
	<p><span class="req">*</span>=<span class="par">Required Info</span>
	<p>Username<span class="req">*</span>:<input type="text" name="name" maxlength="30" /></p>
	<p>Password<span class="req">*</span>:<input type="password" name="password" maxlength="30" /></p>
	<p>Password Again<span class="par">(Verify)</span><span class="req">*</span>:<input type="password" name="password2" maxlength="30" />
	<p>Private Email<span class="req">*</span>:<input type="text" name="pri_email" maxlength="30" /></p>
	<p>Public Email:<input type="text" name="pub_email" maxlength="30" /></p>
	<p>First name:<input type="text" name="f_name" maxlength="30" /></p>
	<p>Last name:<input type="text" name="l_name" maxlength="30" /></p>
	<p><input type="submit" value="Submit" /></p></fieldset></form>');
}
include'footer.html';
?>
