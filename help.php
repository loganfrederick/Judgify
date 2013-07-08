<?php $title="Judgify- Help";
include 'layout.html';
echo'<div class="box">Sections: <a href="help.php">General Help</a> | <a href="help.php?use">Using Judgify</a> | <a href="help.php?forum">Forums</a></div>';// | <a href="help.php?boards">Boards</a></div>';
if (isset($_GET['use'])) {
	echo'<h2>Using Judgify</h2>
	<ol>
	<li><a href="help.php?use#1">How can I create an account?</a></li>
	<li><a href="help.php?use#2">Where do I go to view songs/movies/etc.?</a></li>
	<li><a href="help.php?use#3">Can anyone vote on listings? How do I vote?</a></li>
	</ol>
	<h3 class="headline"><a name="1">How can I create an account?</a></h3>
	<p>Click on the register link on the left to visit the <a href="register.php">registration</a> page. Briefly fill out your desired username, password, and email. You will then be able to sign on and begin submitting to Judgify.</p>
	<h3 class="headline"><a name="2">Where do I go to view songs/movies/etc.?</a></h3>
	<p>The left side has a box titled "<a href="cat.php">Categories</a>" which lists some of our most popular topics. By clicking to the "<a href="cat.php">Categories</a>" page, you will be shown a hub of all our different sections in a thoroughly organized fashion.</p>
	<h3 class="headline"><a name="3">Can anyone vote on listings? How do I vote?</a></h3>
	<p>Anyone can vote on site listings without registering, so as to keep the votes as accurate to public interest as possible. However, by registering and voting, you can take advantage of new site features, such as your own personal favorites lists and the ability to see what your friends are voting for.</p>
	<p>To vote, visit an items page and click on the number in the "Judge" row you feel the entry deserves on a scale from 1-10, with 10 being the highest score possible.</p>';
}
else if (isset($_GET['forum'])) {
	echo'<h2>Forums</h2>
	<ol>
	<li><a href="help.php?forum#1">What is the "TOS"?</a></li>
	</ol>
	<h3 class="headline"><a name="1">What is the "TOS"?</a></h3>
	<p>"TOS" stands for <a href="forum/tos.php">Terms of Service</a>, which is self-explanatory. We require that one skim through the rules of the forums at least once to understand what they can expect from the boards, its users, and the moderation staff.</p>';
}
else {
	echo'<h2>General Help</h2>
	<ol>
	<li><a href="help.php#1">What is Judgify?</a></li>
	<li><a href="help.php#2">Why should I join?</a></li>
	<li><a href="help.php#3">I need help using Judgify!</a></li>
	</ol>
	<h3 class="headline"><a name="1">What is Judgify?</a></h3>
	<p>Judgify is a user-built rating site. Everything from the content to the code is determined by the wants of the users, with a staff present only to pay the hosting fees and facilitate the community.</p>
	<p>Additionally, Judgify is a welcoming community site featuring forums, a comic, podcast, and open-source development projects. We provide all this entertainment content because the staff values and enjoys the company of its visitors.</p>
	<p>Visit the <a href="about.php">about</a> page for more details on who the staff is, what the site does, and how it all began.</p>
	<h3 class="headline"><a name="2">Why should I join?</a></h3>
	<p>To be entertained! Although our main service provides an outlet for you to discover new movies and bands that you may have never seen or heard before, you\'re most likely visiting for some simple entertainment on the internet.
	By joining Judgify, you can participate in our active forums, submit content to our growing database of media, share your interests with others, and play a part in improving the site.</p>
	<h3 class="headline"><a name="3">I need help using Judgify!</a></h3>
	<p>Head over to our "<a href="help.php?use">Using Judgify</a>" help section.</p>';

}
include'footer.html';
?>
