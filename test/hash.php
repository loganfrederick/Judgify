<?php
//$string="deathcoil";
//echo hash('whirlpool',$string);

include'../security/config.php';
$randpass=passgen().passgen();
$pass=hash('whirlpool',$randpass);
echo $pass;
?>
