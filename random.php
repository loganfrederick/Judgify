<?php include'layout.html';
shuffle($cats);
$query=mysql_query("SELECT `id` FROM ".$cats[0]." ORDER BY `id` ASC LIMIT 1");
$query2=mysql_query("SELECT `id` FROM ".$cats[0]." ORDER BY `id` DESC LIMIT 1");
$result=mysql_fetch_assoc($query);
$result2=mysql_fetch_assoc($query2);
$range=rand($result['id'],$result2['id']);

$query=mysql_query("SELECT `id`,`name` FROM ".$cats[0]." WHERE `id`=".$range." ORDER BY `id` ASC LIMIT 1");
$result=mysql_fetch_assoc($query);
if(!$result['name']) {$page="random.php";redirect($page);}

$page=$cats[0].'/'.$range.'/';
redirect($page);
include'footer.html';
?>
