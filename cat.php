<?php include'layout.html';
if (isset($_GET['cat'])) {
	$cat=intval($_GET['cat']);
}
else {
	echo'<dl class="center"><dt>Category Listing</dt>
	<dd><ul><li><a href="song.php">Songs</a></li>
	<li><a href="movie.php">Movie</a></li></ul>';
}
include'footer.html';
?>
