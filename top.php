<?php 
$title="Judgify- Top Entries";
include'layout.html';
echo'<h1>Top 25 Lists</h1>';

echo'<table>
<tr><th colspan="3">Top Entries</th></tr>';
$query=mysql_query('(SELECT `id`,`name`,(`rate`/`votes`) AS `average`,"movie" AS `record_type`,`date_added` FROM `movie` WHERE `votes`>=3) UNION (SELECT `id`,`name`,(`rate`/`votes`) AS `average`,"song" AS `record_type`,`date_added` FROM `song` WHERE `votes`>=3) ORDER BY `average` DESC LIMIT 50;') or die(mysql_error());
while ($data=mysql_fetch_assoc($query)) {
echo'<tr><td class="color"><a href="'.$data['record_type'].'/',$data['id'],'/">',stripslashes($data['name']),'</a></td><td>',$data['record_type'],'</td><td>Score: ',$data['average'],'</td></tr>';
}
echo'</table>';

echo'<div class="split">';

/*echo'<table>
<tr><th colspan="2">Top 25 Movies</th></tr>';
$query=mysql_query("SELECT `id`,`name`,(`rate`/`votes`) AS `average` FROM `movie` WHERE `votes`>=3 ORDER BY `average` DESC LIMIT 25");
while ($data=mysql_fetch_assoc($query)) { echo'<tr><td class="color"><a href="movie.php?id=',$data['id'],'">',stripslashes($data['name']),'</a></td><td>Score: ',$data['average'],'</td></tr>';}
echo'</table>';

echo'</div>';

echo'<div class="split2">';

echo'<table>
<tr><th colspan="2">Top 25 Songs</th></tr>';
$query=mysql_query("SELECT `id`,`name`,(`rate`/`votes`) AS `average` FROM `song` WHERE `votes`>=3 ORDER BY `average` DESC LIMIT 25");
while ($data=mysql_fetch_assoc($query)) { echo'<tr><td class="color"><a href="song.php?id=',$data['id'],'">',stripslashes($data['name']),'</a></td><td>Score: ',$data['average'],'</td></tr>';}
echo'</table>';*/

echo'</div>';
include'footer.html';
?>
