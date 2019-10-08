<?php
require_once("./conn/conn.php");
header('Content-Type:application/json; charset=utf-8');
$name=$_GET['name'];
$sql='select * from student where name = "'.$name.'"';
$zxsql=mysqli_query($sql);
$a=array();
while(@$hqsql=mysqli_fetch_assoc($zxsql)){
	$a[]=$hqsql;
};
print_r(json_encode($a));
?>