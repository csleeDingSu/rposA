<?php
require_once("./conn/conn.php");
require_once("./conn/function.php");
session_start();
@$pengyou_user=$_SESSION['pengyou_user'];
// 允许上传的图片后缀
if(empty($pengyou_user)){
	$raoguojs="insert into pengyou_feifa(ip,time,content) value('$ip','$time','绕过前端提交数据')";
			mysqli_query($raoguojs);
	echo '<meta charset="utf-8">';
	echo '<link href="style/yiqi.css" rel="stylesheet" />';
	echo '<script type="text/JavaScript" src="js/yiqi.js"></script>';
	echo '<body></body>';
	echo '<script type="text/javascript">';
		echo 'tishi(1,"非法操作已记录ip地址",3000);';
	 echo '</script>';
	die();
}else{
	@$hello=dtcxsql('pengyou_user','username',"$pengyou_user");
if($hello['guanli']==3){
	tishi(1,"你的账号被禁止使用,如有疑问联系管理员",1500,'zx.php');
}else{
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
//echo $_FILES["file"]["size"];
//echo $_FILES["file"]["type"];
$extension = strtolower(end($temp));     // 获取文件后缀名
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 1145728)   // 小于 200 kb
&& in_array($extension, $allowedExts))
{
	if ($_FILES["file"]["error"] > 0)
	{
		echo "错误：: " . $_FILES["file"]["error"] . "<br>";
	}
	else
	{
		//echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
		//echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
		//echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		//echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";
		
		// 判断当期目录下的 upload 目录是否存在该文件
		// 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
		@$date=date('Ymdhis');//得到当前时间,如;20070705163148
		@$fileName=$_FILES["file"]["name"];//得到上传文件的名字
		$name=explode('.',$fileName);//将文件名以'.'分割得到后缀名,得到一个数组
		$newPath=$date.'.'.$name[1];//得到一个新的文件为'20070705163148.jpg',即新的路径
		$oldPath=$_FILES['file']['tmp_name'];//临时文件夹,即以前的路径
		if (file_exists("images/bg" . $newPath))
		{
			//echo $_FILES["file"]["name"] . " 文件已经存在。 ";
		}
		else
		{
			// 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
			move_uploaded_file($_FILES["file"]["tmp_name"], "images/bg/" . $newPath);
			//echo "文件存储在: " . "images/touxiang/" . $newPath;
			@$sql="update pengyou_user set bg ='images/bg/$newPath' where username ='$pengyou_user'";
			mysqli_query($sql);
			$_SESSION['pengyou_tximg']=$newPath;
			echo '<meta charset="utf-8">';
			echo '<link href="style/yiqi.css" rel="stylesheet" />';
			echo '<script type="text/JavaScript" src="js/yiqi.js"></script>';
			echo '<body></body>';
			echo '<script type="text/javascript">';
			echo 'tishi(2,"更换成功",3000,"index.php");';
			 echo '</script>';
		}
	}
}
else
{
			echo '<meta charset="utf-8">';
			echo '<link href="style/yiqi.css" rel="stylesheet" />';
			echo '<script type="text/JavaScript" src="js/yiqi.js"></script>';
			echo '<body></body>';
			echo '<script type="text/javascript">';
			echo 'tishi(2,"图片文件必须小于1MB",3000,"index.php");';
			 echo '</script>';
}
	
}
}
?>