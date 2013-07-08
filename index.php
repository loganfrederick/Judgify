<?php
$title="Judgify- Rate and Find Entertainment and Media";
include'layout.html';

/*echo'<div class="homepost"><p><h3>Do you have a favorite <a href="song.php">song</a>? <a href="movie.php">Movie</a>?</h3></p></div>
<div class="homepost"><p><h3>Welcome to Judgify, where you can share your favorites with the public, and judge the views of others.</h3></p></div>
<div class="homepost"><p><h3>Vote the best entries to the top of the list and <a href="register.php">register</a> for free to add your own.</h3></p></div>
<div class="homepost"><p><h3>Click the <a href="random.php">Random</a> link to find new entertainment!</h3></p></div>';*/

echo'<h3>Do you have a favorite <a href="song.php">song</a>? <a href="movie.php">Movie</a>?</h3>
<h3>Welcome to Judgify, where you can share your favorites with the public, and judge the views of others.</h3>
<h3>Vote the best entries to the top of the list and <a href="register.php">register</a> for free to add your own.</h3>
<h3>Click the <a href="random.php">Random</a> link to find new entertainment!</h3>';

/*echo'<div class="split">';

echo'<dl class="splitcenter"><dt>New Members</dt>
<dd><ul>';
$query=mysql_query("SELECT `id`,`username` FROM `user` ORDER BY `id` DESC LIMIT 10;");
while ($user=mysql_fetch_assoc($query)) {
	echo'<li><a href="profile.php?id=',$user['id'],'">',$user['username'],'</a></li>';
}
echo'</ul></dd></dl>';

echo'<table>
<tr><th colspan="2">New Forum Posts</th></tr>';
$query=mysql_query("SELECT a.`message_id`,a.`message`,a.`topic_id`,a.`board_id`,a.`poster_id`,b.`id`,b.`username` FROM `forums_messages` a,`user` b WHERE a.`poster_id`=b.`id` ORDER BY `post_date` DESC LIMIT 10;");
while ($data=mysql_fetch_assoc($query)) {
	echo'<tr><td class="color2"><a href="profile.php?id=',$data['id'],'">',$data['username'],'</a></td><td><a href="forum/posts.php?board_id=',$data['board_id'],'&topic_id=',$data['topic_id'],'#',$data['message_id'],'">'.cutoff(strip_tags(stripslashes($data['message'])),7).'</a></td></tr>';
}
echo'</table>';

echo'</div>';

echo'<div class="split2">';*/

$query=mysql_query('(SELECT `id`,`name`,"movie" AS `record_type`,`date_added`, (`rate`/`votes`) AS `average` FROM `movie`) UNION (SELECT `id`,`name`,"song" AS `record_type`,`date_added`, (`rate`/`votes`) AS `average` FROM `song`) ORDER BY `date_added` DESC LIMIT 10;') or die(mysql_error());
echo'<table>
<tr><th colspan="4">Newest Entries</th></tr>
<tr><td class="color2"><strong>Name</strong></td><td class="color2"><strong>Score</strong></td><td class="color2"><strong>Category</strong></td><td class="color2"><strong>Date Added</strong></td></tr>';
while ($link=mysql_fetch_assoc($query)) {
	echo'<tr><td class="color2"><a href="'.$link['record_type'].'/'.$link['id'].'/">'.stripslashes($link['name']).'</a></td><td>'.$link['average'].'</td><td>'.$link['record_type'].'</td><td>',date("n/j, Y, g:i A", $link['date_added']),'</td></tr>';
}
echo'</table>';

//THIS IS A BREAK

/*$shown=10;
$query=mysql_query('(SELECT COUNT(*) AS `total` FROM `movie`) UNION (SELECT COUNT(*) AS `total` FROM `song`)') or die(mysql_error());
$result=mysql_fetch_array($query) or die(mysql_error());$Total=$result['Total'];

// Create a new SELECT Query with the 
// ORDER BY clause and without the COUNT(*)
$SQL='(SELECT `id`,`name`,"movie" AS `record_type`,`date_added` FROM `movie`) UNION (SELECT `id`,`name`,"song" AS `record_type`,`date_added` FROM `song`) ORDER BY `date_added`';

// Append a LIMIT clause to the SQL statement
if (empty($_GET['Result_Set']))
{ $Result_Set=0; $SQL.=" LIMIT $Result_Set, $Per_Page";}
else
{$Result_Set=$_GET['Result_Set']; $SQL.=" LIMIT $Result_Set, $Per_Page"; }

// Run The Query With a Limit to get result
$SQL_Result=mysql_db_query($dbname, $SQL) or die(mysql_error());
$SQL_Rows=mysql_num_rows($SQL_Result) or die(mysql_error());

// Display Results using a for loop
echo'<table>
<tr><th colspan="3">Newest Entries</th></tr>
<tr><td class="color"><strong>Name</strong></td><td class="color"><strong>Category</strong></td><td class="color"><strong>Date Added</strong></td></tr>';
for ($a=0; $a < $SQL_Rows; $a++)
{
//$SQL_Array=mysql_fetch_array($SQL_Query)  or die(mysql_error());
while ($link=mysql_fetch_assoc($SQL_Query)) {
echo'<tr><td class="color"><a href="'.$link['record_type'].'.php?id='.$link['id'].'">'.stripslashes($link['name']).'</a></td><td>'.$link['record_type'].'</td><td>',date("n/j, Y, g:i A", $link['date_added']),'</td></tr>';
}
echo'</table>';
}

// Create Next / Prev Links and $Result_Set Value
if ($Total>0) {
	if ($Result_Set<$Total && $Result_Set>0) { 
		$Res1=$Result_Set-$Per_Page;
		echo '<a href="index.php?Result_Set=$Res1&Keyword='.$_REQUEST['Keyword'].'"> <;<; Previous Page</a> ';
	}
	// Calculate and Display 
	# Links
	$Pages=$Total/$Per_Page;
	if ($Pages>1)
	{
		for ($b=0,$c=1; $b < $Pages; $b++,$c++)
		{
			$Res1=$Per_Page*$b;
			echo '<a href="test.php?Result_Set=$Res1&Keyword='.$_REQUEST['Keyword'].'">'.$c.'</a> n';
		}
	}
	if ($Result_Set>=0 && $Result_Set<$Total)
	{
		$Res1=$Result_Set+$Per_Page;
		if ($Res1<$Total)
		{
			echo '<a href="test.php?Result_Set=$Res1&Keyword='.$_REQUEST['Keyword'].'"> Next Page >></a>';
		}
	}
}*/

/*    $limit          = 2;               
    $query_count    = "SELECT count(*) FROM `movie`";    
    $result_count   = mysql_query($query_count);    
    $totalrows      = mysql_num_rows($result_count); 

    if(empty($page)){
        $page = 1;
    }
        

    $limitvalue = $page * $limit - ($limit); 
    $query  = "SELECT * FROM `movie` LIMIT $limitvalue, $limit";        
    $result = mysql_query($query) or die("Error: " . mysql_error()); 

    if(mysql_num_rows($result) == 0){
        echo("Nothing to Display!");
    }

    $bgcolor = "#E0E0E0"; // light gray

    echo("<table>");
    
    while($row = mysql_fetch_array($result)){
        if ($bgcolor == "#E0E0E0"){
            $bgcolor = "#FFFFFF";
        }else{
            $bgcolor = "#E0E0E0";
        }

    echo("<tr bgcolor=".$bgcolor.">");
    echo('<td>'.$row["id"].'</td>');
    echo('<td>'.$row["name"].'</td>');
    echo'</tr>';
    }

    echo("</table>");

    if($page != 1){ 
        $pageprev = $page--;
        
        echo("<a href=\"$PHP_SELF&page=$pageprev\">PREV".$limit."</a> "); 
    }else{
        echo("PREV".$limit." ");
    }

    $numofpages = $totalrows / $limit; 
    
    for($i = 1; $i <= $numofpages; $i++){
        if($i == $page){
            echo($i." ");
        }else{
            echo("<a href=\"$PHP_SELF?page=$i\">$i</a> ");
        }
    }


    if(($totalrows % $limit) != 0){
        if($i == $page){
            echo($i." ");
        }else{
            echo("<a href=\"$PHP_SELF?page=$i\">$i</a> ");
        }
    }

    if(($totalrows - ($limit * $page)) > 0){
        $pagenext = $page++;
         
        echo("<a href=\"$PHP_SELF?page=$pagenext\">NEXT".$limit."</a>"); 
    }else{
        echo("NEXT".$limit); 
    }
    
    mysql_free_result($result); */

echo'</div>';
include'footer.html';
?>
