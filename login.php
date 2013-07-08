<?php 
$title="Judgify- Login";
include'layout.html';
if(isset($_GET['username']) || isset($_GET['password']))  {
	echo'<p>This is likely a hacker attempt, and that is not appreciated.</p>';
	include'footer.html';exit();
}
else if(isset($_GET['logout'])) {
	setcookie("judgify_login", $password, time()-33333333, '/');
	setcookie("judgify_login_name", $name, time()-33333333, '/');
	session_destroy();
	redirect();
}
else if(isset($_COOKIE['judgify_login'])) echo'<p>You are logged in. <a href="index.php">Return home</a> or <a href="login.php?logout">log out</a>.</p>';
else if(isset($_GET['key']))  {
	$randpass=passgen();
	$pass=hash('whirlpool',$randpass);
	mysql_query("UPDATE `user` SET `password`='".$pass."' WHERE `passkey`='".$_GET['key']."'") or die(mysql_error());
	$query=mysql_query("SELECT `username`,`pri_email`,`password` FROM `user` WHERE `passkey`='".$_GET['key']."'") or die(mysql_error());
	$user=mysql_fetch_assoc($query);
	$email=$user['pri_email'];
	$subject="Judgify- Password Reset";
	$message='Hello '.$email.', this is an automated message from Judgify including your password key. You are required to first
	
	Your username: '.$user['username'].'
	Your new password: '.$randpass.'
	
	You can change your password again at your profile page: http://judgify.com/profile.php
	If you have any problems or concerns, message us on our contact page: http://judgify.com/contact.php
	Thank you for using Judgify,
	Logan Frederick
	http://judgify.com';
	mail($email, $subject, $message);
	echo'<p>Your password has been changed. An email with your new password has been sent to the address you\'ve provided. 
	You can change your password again at your <a href="http://judgify.com/profile.php">profile page</a>.
	If you have any problems or concerns, message us on our <a href="http://judgify.com/contact.php">contact</a> page.</p>';
	mysql_query("UPDATE `user` SET `passkey`='".passgen()."' WHERE `pri_email`='$email'") or die(mysql_error());
}
else if(isset($_POST['email']) && isset($_GET['forgot']))  {
	$email=strip_tags(trim($_POST['email'], ENT_QUOTES));
	$query=mysql_query("SELECT `username`,`passkey` FROM `user` WHERE `pri_email`='$email'") or die(mysql_error());
	$user=mysql_fetch_assoc($query);
	$subject="Judgify- Password Key";
	$message='Hello '.$email.', this is an automated message from Judgify including your new password key.
	
	Your username: '.$user['username'].'
	Your password key link: http://www.gamesource.biz/judgify/login.php?key='.$user['passkey'].'
	
	By clicking on the above link, you will be sent another email with your new password.
	
	Thank you for using Judgify,
	Logan Frederick
	http://judgify.com';
	mail($email, $subject, $message);
	echo'<p>Your password key has been sent. Please open up your email and click the link included in the message we have sent. 
	You will then receive a new password.</p>';
}
else if(isset($_POST['username']) && isset($_POST['password'])) {
	$name=$escape_string($_POST['username']);$password=hash('whirlpool',$escape_string($_POST['password']));
	if(isset($name) && isset($password)) {
		if(!isset($login_cookie)) {
			$user=mysql_query("SELECT `username`,`password` FROM `user` WHERE `username`='".$name."' AND `password`='".$password."'") or die(mysql_error());
			if (mysql_num_rows($user)==1) {
				setcookie("judgify_login", $password, time()+33333333, '/');
				setcookie("judgify_login_name", $name, time()+33333333, '/');
				redirect();
			}
			else echo'<p>Your username and/or password was incorrect.</p>';
		}
		else echo'<p>You are logged in.</p>';
	}
	else echo'<p>You did not fill in the proper form to reach this page.</p>';
}
else {
	echo('<form action="login.php" method="post" class="form">
	<fieldset>
	<legend>Login</legend>
	<p>Username:<input type="text" name="username" maxlength="30" /></p>
	<p>Password:<input type="password" name="password" maxlength="30" /></p>
	<p><input type="submit" value="Submit" /></p></fieldset></form>
	
	<form action="login.php?forgot" method="post" class="form">
	<fieldset>
	<legend>Forgot Password?</legend>
	<p>Please enter your private email address: <input type="text" name="email" maxlength="30" /></p>
	<p><input type="submit" value="Submit" /></p></fieldset></form>');	
}
include'footer.html';
?>
