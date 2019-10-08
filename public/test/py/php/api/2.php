<meta charset="utf-8">
<?php 
	require_once('../../conn/conn.php');
	require_once('../../conn/function.php');
	session_start();
?>
<?php
function shuiji()
{
	$ztime=date('His');
	$sjusername=rand(100000,10000000)+$ztime;
	return $sjusername;
}

			echo shuiji();
?>
