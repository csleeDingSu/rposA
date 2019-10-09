<?php 
require_once("../conn/conn.php");
require_once("../conn/function.php");
session_start();
?>
<?php
@$ip=addslashes($onlineip);
@$pass=md5($_POST["pass"]);
@$Id=intval($_POST["id"]);
@$user=$_SESSION['pengyou_user'];
@$quanxian =quanxian($user);
if($quanxian==1){

	if(!empty($pass)|| isset($pass)){
		
		if(strlen($_POST["pass"]) > 5 ){
					$xgsql="update pengyou_user set password='$pass' where Id='$Id'";
					$zxxgsql=mysqli_query($xgsql);
					if($zxxgsql){
						echo '{"success":true,"msg":"修改成功"}';
						
				}else{
						echo '{"success":false,"msg":"修改失败"}';
					}

		}else{
			echo '{"success":false,"msg":"密码长度小于六位"}';
		}
		
	}else{
		echo '{"success":false,"msg":"信息填写不完全"}';
	}


	
}else{
	httishi();
}
?>