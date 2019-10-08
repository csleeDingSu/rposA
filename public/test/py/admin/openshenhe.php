<?php
require_once('../conn/conn.php');
require_once('../conn/function.php');
session_start();
?>
<?php
@$ip=addslashes($onlineip);
@$Id=intval($_GET['shenhe']);
@$pengyou_user=$_SESSION['pengyou_user'];
$quanxian = quanxian($pengyou_user);
if($quanxian==1){
	$cxsql="select * from pengyou_shezhi";
	$zxcxsql=mysqli_query($cxsql);
	$hqcxsql=mysqli_fetch_assoc($zxcxsql);
	if($hqcxsql['shenhe']==1){
		$cripsql="update pengyou_shezhi set shenhe=0";
			if(mysqli_query($cripsql)){
				echo '{"success":true,"msg":"设置成功"}';
			}else{
				echo '{"success":true,"msg":"设置失败"}';
			}
	}else{
		$cripsql="update pengyou_shezhi set shenhe=1";
			if(mysqli_query($cripsql)){
				echo '{"success":true,"msg":"设置成功"}';
			}else{
				echo '{"success":true,"msg":"设置失败"}';
			}
	};
	
}else{
	$raoguojs="insert into pengyou_feifa(ip,time,content) value('$ip','$time','没有权限设置审核')";
			mysqli_query($raoguojs);
	echo '<meta charset="utf-8">';
	echo '<link href="../style/yiqi.css" rel="stylesheet" />';
	echo '<script type="text/JavaScript" src="../js/yiqi.js"></script>';
	echo '<body></body>';
	echo '<script type="text/javascript">';
		echo 'tishi(1,"非法操作已记录ip地址",3000);';
	 echo '</script>';
}

?>