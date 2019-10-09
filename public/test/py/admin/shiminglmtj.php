<?php 
require_once("../conn/conn.php");
require_once("../conn/function.php");
session_start();
?>
<?php
@$ip=addslashes($onlineip);
@$name=addslashes($_POST["name"]);
@$icon=addslashes($_POST["icon"]);
@$color=addslashes($_POST["color"]);
@$user=$_SESSION['pengyou_user'];
@$quanxian =quanxian($user);
if($quanxian==1){

	if(!empty($name)|| isset($name) ||
	!empty($icon)|| isset($icon) ||
	!empty($color)|| isset($color)){
		
					$sql="insert into pengyou_renzheng(name,icon,color) values('$name','$icon','$color')";
					$zxxgsql=mysqli_query($sql);
					if($zxxgsql){
						echo '{"success":true,"msg":"添加成功"}';
						
				}else{
						echo '{"success":false,"msg":"添加失败"}';
						
					}
		
	}else{
		echo '{"success":false,"msg":"信息填写不完全"}';
	}


	
}else{
	httishi();
}
?>