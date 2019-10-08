<?php
require_once("../conn/conn.php");
require_once("../conn/function.php");
session_start();
?>
<?php
@$pengyou_user=$_SESSION['pengyou_user'];
@$ip=addslashes($onlineip);
@$Id=intval($_GET['Id']);
if (!isset($Id) || empty($Id) ||
	!isset($pengyou_user) || empty($pengyou_user)
   ){
		raoguo();
}else{
	@$hello=dtcxsql('pengyou_user','username',"$pengyou_user");
	$quanxian=$hello['finallyvip'];
	if($quanxian==1){
		$sql="select * from pengyou_user where Id = '$Id'";
		$zxsql=mysqli_query($sql);
		$hqsql=mysqli_fetch_assoc($zxsql);
		$guanli = $hqsql['guanli'];
		if($guanli==1){
			@$cripsql="update pengyou_user set guanli=0 where Id = '$Id'";
			if(mysqli_query($cripsql)){
				echo '{"success":true,"msg":"取消管理成功"}';
			}else{
				echo '{"success":false,"msg":"取消管理失败"}';
			}
		}elseif($guanli!==0){
			@$cripsql="update pengyou_user set guanli=1 where Id = '$Id'";
			if(mysqli_query($cripsql)){
				echo '{"success":true,"msg":"设置成功"}';
			}else{
				echo '{"success":false,"msg":"设置失败"}';
			}
			
		}
	}else{
		echo "no";
	}
		
	

}

?>

