<?php 
require_once("./conn/conn.php");
require_once("./conn/function.php");
session_start();
?>
<?php
@$ip=addslashes($onlineip);
@$Id=intval($_GET["id"]);
@$user=$_SESSION['pengyou_user'];
@$hqzl=dtcxsql('pengyou_content','Id',$Id);
@$ssid=$hqzl['username'];
if(!empty($Id)|| isset($Id)){
	if($ssid==$user){
			$sql="delete from pengyou_content where Id=$Id";
				$zxsql=mysqli_query($sql);
				if($zxsql){
					echo '{"success":true,"msg":"删除成功"}';
				}else{
					echo '{"success":false,"msg":"删除失败"}'; 
				}
	}else{
		$raoguojs="insert into pengyou_feifa(ip,time,content) value('$ip','$time','绕过前端提交删除数据')";
			mysqli_query($raoguojs);
	echo '<meta charset="utf-8">';
	echo '<link href="style/yiqi.css" rel="stylesheet" />';
	echo '<script type="text/JavaScript" src="js/yiqi.js"></script>';
	echo '<body></body>';
	echo '<script type="text/javascript">';
		echo 'tishi(1,"非法操作已记录ip地址",3000);';
	 echo '</script>';
	}
	
	
	
}else{
	$raoguojs="insert into pengyou_feifa(ip,time,content) value('$ip','$time','绕过前端提交删除数据')";
			mysqli_query($raoguojs);
	echo '<meta charset="utf-8">';
	echo '<link href="style/yiqi.css" rel="stylesheet" />';
	echo '<script type="text/JavaScript" src="js/yiqi.js"></script>';
	echo '<body></body>';
	echo '<script type="text/javascript">';
		echo 'tishi(1,"非法操作已记录ip地址",3000);';
	 echo '</script>';
}
