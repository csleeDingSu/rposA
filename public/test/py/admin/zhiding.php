<?php
require_once("../conn/conn.php");
require_once("../conn/function.php");
session_start();
?>
<?php
@$user=$_SESSION['pengyou_user'];
@$ip=addslashes($onlineip);
@$Id=intval($_POST['Id']);
@$zhidingtime=addslashes($_POST['zhidingtime']);
if (!isset($Id) || empty($Id) ||
	!isset($user) || empty($user)
   ){
		raoguo();
}else{
	@$quanxian=quanxian($user);
	if($quanxian==1){
		$sql="select * from pengyou_content where Id = '$Id'";
		$zxsql=mysql_query($sql);
		$hqsql=mysql_fetch_assoc($zxsql);
		$zhiding = $hqsql['zhiding'];
		if($zhiding==1){
			@$cripsql="update pengyou_content set zhiding=0 where Id = '$Id'";
			mysql_query($cripsql);
			echo '{"success":false,"msg":"取消置顶成功"}';
		}elseif($zhiding==0){
			@$cripsql="update pengyou_content set zhiding=1,zhidingtime='$zhidingtime' where Id = '$Id'";
			mysql_query($cripsql);
			echo '{"success":true,"msg":"置顶成功"}';
		}
	}else{
		raoguo();
	}
		
	

}

?>

