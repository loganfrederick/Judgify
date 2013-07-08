<?php include'../layout.html';
if ($_SESSION['level']>=40 && isset($_COOKIE["judgify_login"])) {
	echo'<h1>Admin Panel</h1>
	<ul>
	<li><a href="admin/modqueue.php">Mod Queue</a></li>
	<li><a href="admin/forumqueue.php">Forum Queue</a></li>';
	if($_SESSION['level']>=50) {
		echo'<li><a href="admin/createcat.php">Create Category</a></li>
		<li><a href="admin/createboard.php">Create Board</a></li>
		<li><a href="admin/createcomic.php">Upload a Comic</a></li>';
	}
	echo'</ul>';
}
include'../footer.html';
?>
