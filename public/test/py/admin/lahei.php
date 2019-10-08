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
		$sql="select * from pengyou_user where Id = '$Id'";
		$zxsql=mysql_query($sql);
		$hqsql=mysql_fetch_assoc($zxsql);
		$guanli = $hqsql['guanli'];
		if($guanli==1){
			echo '{"success":false,"msg":"不能拉黑管理"}';
		};
		if($guanli==3){
			@$cripsql="update pengyou_user set guanli=0 where Id = '$Id'";
			if(mysql_query($cripsql)){
				echo '{"success":true,"msg":"取消拉黑成功"}';
			};
		}elseif($guanli==0){
			@$cripsql="update pengyou_user set guanli=3 where Id = '$Id'";
			if(mysql_query($cripsql)){
				echo '{"success":true,"msg":"拉黑成功"}';
			};
		};
		
	}else{
		raoguo();
	}
		
	

}

?>

