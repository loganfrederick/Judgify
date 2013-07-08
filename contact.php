<?php 
$title="Judgify- Contact";
include'layout.html';
if (isset($_POST['category']) && isset($_POST['from']) && isset($_POST['message']) && isset($_POST['subject'])) {
	$subject=$_POST['category']."- ".$_POST['subject'];
	mail("judgify@gmail.com", $subject, $_POST['message'], $_POST['from']);
	echo'<p>Your message has been sent.</p>';
}
else {
	echo'<h1>Contact</h1>
	<div class="homepost"><p>This is the contact page. Below are the various reasons you may want to contact GameSource. If any of them apply, use the form below to contact us.</p></div>
	<form action="contact.php" method="POST" class="contactform">
	<p>Your Email:<br><input type="text" name="from" size="50" maxlength="30" /></p>
	<p>Subject:<br><input type="text" name="subject" size="50" maxlength="30" /></p>
	<p>Category: <select name="category"><option value="Suggestion">Suggestion</option><option value="Biz">Business/Press</option><option value="Help">Help</option></select></p>
	Message:<br><textarea cols="50" rows="10" name="message"></textarea></p>
	<p><input type="submit" value="Send Message" /></p>
	</form>';
}
include'footer.html';
?>
