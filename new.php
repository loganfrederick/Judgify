<?php 
$title="Judgify- New Entries";
include'layout.html';
echo'<h1>New Entries</h1>';
if ($_GET['cat']=="song") {
	$limit=$_GET['limit'];
	$page=$_GET['page'];
	$query=mysql_query('SELECT `id` FROM `song` ORDER BY `id` DESC');
	if(!$query) die(mysql_error());  
	$total_items=mysql_num_rows($query);
	
	if((!$limit)  || (is_numeric($limit) == false) || ($limit < 10) || ($limit > 50)) $limit=10; //default
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) $page=1;//default
	
	$total_pages=ceil($total_items / $limit);
	$set_limit=$page*$limit-($limit);
	$query=mysql_query('SELECT `id`,`name`,`date_added` FROM `song` ORDER BY `id` DESC LIMIT '.$set_limit.', '.$limit.'');
	
	if(!$query) die(mysql_error());
	$err=mysql_num_rows($query);
	if($err==0) die("No matches met your criteria.");
	
	//show data matching query:
	echo'<table>
	<tr><th colspan="2">Newest Songs:  
	<a href="'.$_SERVER['SCRIPT_NAME'].'?cat=song&limit=10&page=1">10</a> | 
	<a href="'.$_SERVER['SCRIPT_NAME'].'?cat=song&limit=25&page=1">25</a> | 
	<a href="'.$_SERVER['SCRIPT_NAME'].'?cat=song&limit=50&page=1">50</a></th></tr>';
	while($row=mysql_fetch_assoc($query)) { 
		echo'<tr><td class="color"><a href="song.php?id=',$row['id'],'">',stripslashes($row['name']),'</a></td><td>',date("n/j, Y, g:i A", $row['date_added']),'</td></tr>';	
	}
	echo'</table>';
	
	$prev_page=$page-1;
	if($prev_page>=1) echo('<b><<</b> <a href="'.$_SERVER['SCRIPT_NAME'].'?limit='.$limit.'&page='.$prev_page.'"><b>Prev.</b></a>'); 

	for($a=1;$a<=$total_pages;$a++)
	{
		if($a == $page) echo('<b> '.$a.'</b> | '); //no link
		else echo('<a href="'.$_SERVER['SCRIPT_NAME'].'?limit='.$limit.'&page='.$a.'"> '.$a.' </a> | ');
	} 
	$next_page=$page+1;
	if($next_page<=$total_pages) echo('<a href="'.$_SERVER['SCRIPT_NAME'].'?limit='.$limit.'&page='.$next_page.'"><b>Next</b></a> > >');
}
else if ($_GET['cat']=="movie") {
	$limit=$_GET['limit'];
	$page=$_GET['page'];
	$query=mysql_query('SELECT `id` FROM `movie` ORDER BY `id` DESC');
	if(!$query) die(mysql_error());  
	$total_items=mysql_num_rows($query);
	
	if((!$limit)  || (is_numeric($limit) == false) || ($limit < 10) || ($limit > 50)) $limit=10; //default
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) $page=1;//default
	
	$total_pages=ceil($total_items / $limit);
	$set_limit=$page*$limit-($limit);
	$query=mysql_query('(SELECT `id`,`name`,"movie" AS `cat`,`date_added` FROM `movie`) UNION (SELECT `id`,`name`,"song" AS `cat`,`date_added` FROM `song`) ORDER BY `date_added` DESC LIMIT '.$set_limit.', '.$limit.'');
	
	if(!$query) die(mysql_error());
	$err=mysql_num_rows($query);
	if($err==0) die("No matches met your criteria.");
	
	//show data matching query:
	echo'<table>
	<tr><th colspan="2">Newest Movies:  
	<a href="'.$_SERVER['SCRIPT_NAME'].'?cat=movie&limit=10&page=1">10</a> | 
	<a href="'.$_SERVER['SCRIPT_NAME'].'?cat=movie&limit=25&page=1">25</a> | 
	<a href="'.$_SERVER['SCRIPT_NAME'].'?cat=movie&limit=50&page=1">50</a></th></tr>';
	while($row=mysql_fetch_assoc($query)) { 
		echo'<tr><td class="color"><a href="movie.php?id=',$row['id'],'">',stripslashes($row['name']),'</a></td><td>',date("n/j, Y, g:i A", $row['date_added']),'</td></tr>';	
	}
	echo'</table>';
	
	$prev_page=$page-1;
	if($prev_page>=1) echo('<b><<</b> <a href="'.$_SERVER['SCRIPT_NAME'].'?limit='.$limit.'&page='.$prev_page.'"><b>Prev.</b></a>'); 

	for($a=1;$a<=$total_pages;$a++)
	{
		if($a == $page) echo('<b> '.$a.'</b> | '); //no link
		else echo('<a href="'.$_SERVER['SCRIPT_NAME'].'?limit='.$limit.'&page='.$a.'"> '.$a.' </a> | ');
	} 
	$next_page=$page+1;
	if($next_page<=$total_pages) echo('<a href="'.$_SERVER['SCRIPT_NAME'].'?limit='.$limit.'&page='.$next_page.'"><b>Next</b></a> > >');
}
else {
	$query=mysql_query('(SELECT `id`,"movie" AS `cat` FROM `movie`) UNION (SELECT `id`,"song" AS `cat` FROM `song`)');
	if(!$query) die(mysql_error());  
	$total_items=mysql_num_rows($query);
	
	$limit=$_GET['limit'];
	$page=$_GET['page'];
	if((!$limit)  || (is_numeric($limit) == false) || ($limit < 10) || ($limit > 50)) $limit=10; //default
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) $page=1;//default
	
	$total_pages=ceil($total_items / $limit);
	$set_limit=$page*$limit-($limit);
	$query=mysql_query('(SELECT `id`,`name`,"movie" AS `cat`,`date_added` FROM `movie`) UNION (SELECT `id`,`name`,"song" AS `cat`,`date_added` FROM `song`) ORDER BY `date_added` DESC LIMIT '.$set_limit.', '.$limit.'');
	
	if(!$query) die(mysql_error());
	$err=mysql_num_rows($query);
	if($err==0) die("No matches met your criteria.");
	
	//show data matching query:
	echo'<table>
	<tr><th colspan="3">Newest Entries:  
	<a href="'.$_SERVER['SCRIPT_NAME'].'?limit=10&page=1">10</a> | 
	<a href="'.$_SERVER['SCRIPT_NAME'].'?limit=25&page=1">25</a> | 
	<a href="'.$_SERVER['SCRIPT_NAME'].'?limit=50&page=1">50</a></th></tr>';
	while($row=mysql_fetch_assoc($query)) { 
		echo'<tr><td class="color"><a href="'.$row['cat'].'/',$row['id'],'/">',stripslashes($row['name']),'</a></td><td>'.$row['cat'].'</td><td>',date("n/j, Y, g:i A", $row['date_added']),'</td></tr>';	
	}
	echo'</table>';
	
	$prev_page=$page-1;
	if($prev_page>=1) echo('<b><<</b> <a href="'.$_SERVER['SCRIPT_NAME'].'?limit='.$limit.'&page='.$prev_page.'"><b>Prev.</b></a>'); 

	for($a=1;$a<=$total_pages;$a++)
	{
		if($a == $page) echo('<b> '.$a.'</b> | '); //no link
		else echo('<a href="'.$_SERVER['SCRIPT_NAME'].'?limit='.$limit.'&page='.$a.'"> '.$a.' </a> | ');
	} 
	$next_page=$page+1;
	if($next_page<=$total_pages) echo('<a href="'.$_SERVER['SCRIPT_NAME'].'?limit='.$limit.'&page='.$next_page.'"><b>Next</b></a> > >');
}
include'footer.html';
?>
