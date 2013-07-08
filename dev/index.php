<?php $title="Judgify- Developers";
include '../layout.html';
echo'<div class="box">Sections: <a href="dev/index.php">Dev Home</a> | <a href="dev/index.php?source">Source Code</a></div>';
if (isset($_GET['source'])) echo'<h2>Open Source Projects</h2>
	<p>Coming Soon: Judgify will be releasing various code we\'ve developed for the site as open source projects for
	the community to jack around with. Check the Judgify Blog for further announcements.';
else { 
	echo'<h2>Developer Home</h2>
	<ol><li><a href="dev/index.php#1">What is this section of the site?</a></li>
	<li><a href="dev/index.php#2">What languages are used in Judgify?</a></li>
	</ol>
	
	<h3 class="headline"><a name="1">What is this section of the site?</a></h3>
	<p>This is the developer section of Judgify, where programmers and web designers can interact with the Judgify dev team and download any projects released
	to the community as open source experiments.</p>

	<h3 class="headline"><a name="2">What languages/databases/servers are used in Judgify?</a></h3>
	<p>Judgify is written in the XHTML markup language and uses Cascading Style Sheets to beautify the site, and we strive to properly validate
	in both languages. The backend uses PHP 5.2.0 and MySQL 4.1.21-standard. The staff\'s current text editor of choice is <a href="http://jedit.org/">jEdit</a>.</p>';
}
include'../footer.html';
?>
