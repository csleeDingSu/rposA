<?php 
$host='103.14.102.42';		//数据库地址
$sqlname='dev1';		//数据库账号
$sqlpass='Abc@1234Abc@1234';		//数据库密码
$sqldb='py';        //数据库名

// $con = mysql_connect($host,$sqlname,$sqlpass);		//连接数据库
// mysql_select_db($sqldb);						//选择数据库
// mysqli_query("set names 'utf8'");					//设置编码格式

$con=mysqli_connect($host,$sqlname,$sqlpass,$sqldb)or die("ERROR".mysqli_error($con));
if (mysqli_connect_error()){
	echo "Could not connect to MySql. Please try again";
	exit();
}
?>