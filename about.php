<?php 
$title="Judgify- About";
include'layout.html';
if(isset($_GET['staff'])) echo'<h1>Staff</h1>';
else echo'<h1>About Judgify</h1>';
echo'<div class="box">Pages: <a href="about.php">About</a> | <a href="about.php?staff">Staff</a></div>';
if(isset($_GET['staff'])) {
	echo'<div class="homepost">
	<h1>Logan "Madgamer" Frederick</h1>
	<span>Founder, Webmaster</span>
	<span>AIM: judgify</span>
	<span>Email: loganfrederick@gmail.com</span>
	<p>Logan is the 16 year old founder and webmaster of <a href="">Judgify</a>. His days are a mixture of tedious schoolwork and the fast-paced, high-rolling life of a Silicon Valley web developer.
	Madgamer began his development journey back in 2004 using the old Geocities tools, but has since moved on to the typical upstart dev toolset: HTML, CSS, PHP, and MySQL, all coded in <a href="http://jedit.org/">jEdit</a>. Logan also serves as a news reporter for <a href="http://escapistmagazine.com">The Escapist</a>, a weekly video game e-zine covering industry issues.
	Other interests include video games, Dr. Pepper, and economics.</p>
	</div>';
	
	echo'<h2>Jurors</h2>
	<ul>
	<li><a href="http://gamesource.biz/judgify/profile.php?id=7">"ApolloIV"</a>- There\'s not really much to tell you about him. A 15 year old living in the good old state of South Carolina. Nothing really that good to tell about the state besides the beaches are nice...and dirty. I\'m not really biased against a lot of music. Some of my favorites are Coheed and cambria, Bloc Party, Iced Earth, The Number 12 Looks Like You, SYL, The Mars Volta, Interpol, Dragonforce, Turbonegro, and The Flaming lips. On the movie side of things, I\'m probably not the person to ask.</li>
	<li><a href="http://gamesource.biz/judgify/profile.php?id=12">"Karma"</a>- He legally changed his middle name to "Danger".</li>
	</ul>';
	
	echo'<h2>Special Thanks</h2>
	<ul><li>Nick Presta- PHP/MySQL, Database Optimization</li>
	<li>Jesse Lentz- PHP Functions</li>
	<li>Mike Helton- PHP/MySQL</li>
	</ul>';
}
else {
	echo'<p>We all have our favorites, our own personal style. But we all enjoy more than discussing our tastes is judging the views of others.</p>
	<p><a href="index.php">Judgify</a> allows anyone to do just that. You can find the interests of others, rate them, discuss them, and degrade them. 
	Then ';
	if(isset($_COOKIE["judgify_login"]) && isset($_SESSION['level'])) echo'<a href="submit.php">impose your views</a>';
	else echo'<a href="register.php">impose your views</a>';
	echo' on the general populous and defend them to the death in our <a href="forum/">forums</a>.</p>
	<p>Judgify is a database of user submitted items that are ranked by the users, creating a community-driven "top 10" listing of the current hot items in various industries.</p>';
}
include'footer.html';
?>
