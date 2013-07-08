<?php
include'config.php';

$a = mysql_query ('SELECT `user`.`id`, COUNT(`forums_messages`.`message_id`)
                   FROM `user` JOIN `forums_messages` ON `user`.`id` = `forums_messages`.`poster_id`
                   WHERE `user`.`last_visit`>=UNIX_TIMESTAMP()-60*60*24 AND `user`.`level`>\'0\' AND `forums_messages`.`post_date`>=UNIX_TIMESTAMP()-60*60*24
                   GROUP BY `user`.`id`
                   ORDER BY `user`.`id` ASC');

for ($b = '', $d = mysql_num_rows ($a), $e = 0; $c = mysql_fetch_row ($a); ) {
	if ($c[1] > 0) {
		$b.='`id`='.$c[0].(++$e<$d ? ' OR ' : '');
	}
}

if ($b) {
 mysql_query ('UPDATE `user` SET `points`=`points`+1 WHERE '.$b);
}

?>
