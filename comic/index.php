<?php $title="The Jury: The Judgify Comic";
include'../layout.html';

echo'<select name="comic">';
$query=mysql_query("SELECT `title`,`comic` FROM `comics` LIMIT 1;");
while ($data=mysql_fetch_assoc($query)) {
	echo'<option';
}
echo'</select>';

echo'<h1>The Jury: The Judgify Comic</h1>';
echo'<h2>',$data['title'],'</h2>';

$data=mysql_fetch_assoc($query);
echo'<img src="',$data['comic'],'" />';

include '../footer.html';?>
