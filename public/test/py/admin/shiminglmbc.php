<?php 
require_once("../conn/conn.php");
require_once("../conn/function.php");
session_start();
?>
<?php
@$ip=addslashes($onlineip);
@$Id=intval($_POST["Id"]);
@$name=addslashes($_POST["name"]);
@$icon=addslashes($_POST["icon"]);
@$color=addslashes($_POST["color"]);
@$user=$_SESSION['pengyou_user'];
@$quanxian =quanxian($user);
if($quanxian==1){

	if(!empty($Id)|| isset($Id) ||
	!empty($name)|| isset($name) ||
	!empty($icon)|| isset($icon) ||
	!empty($color)|| isset($color)){
		
					$xgsql="update pengyou_renzheng set name='$name',icon='$icon',color='$color' where Id='$Id'";
					$zxxgsql=mysqli_query($xgsql);
					if($zxxgsql){
						echo '{"success":true,"msg":"修改成功"}';
						
				}else{
						echo '{"success":false,"msg":"修改失败"}';
					}
		
	}else{
		echo '{"success":false,"msg":"信息填写不完全"}';
	}


	
}else{
	httishi();
}
?>