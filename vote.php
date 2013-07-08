<?php include'layout.html';
$vote=intval($_GET['vote']);$id=intval($_GET['id']);$cat=$_GET['cat'];
if (!in_array($cat, $cats)) {
	echo'<p>Incorrect Category</p>';
	echo $cat;
	include'footer.html';
	exit;
}
else if ($vote>=0 && $vote<=10 && $id>0) {
	$return=addVote($id, $_SESSION['id'], $vote, $cat);
	if ($return==1) redirect($cat.'.php?id='.$id.'&msg=Vote%20Added!');
	else if ($return==2) redirect($cat.'.php?id='.$id.'&msg=Vote%20Changed!');
	else redirect($cat.'.php?id='.$id.'&msg=Error%20With%20Vote!');
}
else {redirect('index.php');}
include'footer.html';
?>
