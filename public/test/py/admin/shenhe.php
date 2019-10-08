<?php
require_once("../conn/conn.php");
require_once("../conn/function.php");
session_start();
?>
<?php
@$user=$_SESSION['pengyou_user'];
@$ip=addslashes($onlineip);
@$Id=intval($_GET['Id']);
if (!isset($Id) || empty($Id) ||
	!isset($user) || empty($user)
   ){
		raoguo();
}else{
	@$quanxian=quanxian($user);
	if($quanxian==1){
		$sql="select * from pengyou_content where Id = '$Id'";
		$zxsql=mysqli_query($sql);
		$hqsql=mysqli_fetch_assoc($zxsql);
		$Shenhe = $hqsql['shenhe'];
		if($Shenhe==1){
			@$cripsql="update pengyou_content set shenhe=0 where Id = '$Id'";
			mysqli_query($cripsql);
			echo '{"success":true,"msg":"取消审核成功"}';
		}elseif($Shenhe==0){
			@$cripsql="update pengyou_content set shenhe=1 where Id = '$Id'";
			mysqli_query($cripsql);
			echo '{"success":true,"msg":"审核成功"}';
		}
	}else{
		raoguo();
	}
		
	

}

?>

