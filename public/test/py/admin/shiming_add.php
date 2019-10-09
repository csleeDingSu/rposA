<?php 
require_once("../conn/conn.php");
require_once("../conn/function.php");
session_start();
?>

<?php
@$ip=addslashes($onlineip);
@$renzheng=intval($_GET["renzheng"]);
@$Id=intval($_GET["id"]);
@$pengyou_user=$_SESSION['pengyou_user'];
@$hqzl=dtcxsql('pengyou_user','Id',$Id);
@$xgId=$hqzl['Id'];
@$uservip=$hqzl['vip'];
//传过来的添加vip的值  获取用户vip的值 如果等于0直接更新 如果不等于0 转换成数组 追加vip的值再更新
if($renzheng==100){
	$xgsql="update pengyou_user set vip=0 where Id='$xgId'";
	$zxxgsql=mysqli_query($xgsql);
	mysqli_query($zxxgsql);
	if($zxxgsql){
		echo '{"success":true,"msg":"修改成功"}';
	}else{
		echo '{"success":false,"msg":"修改失败"}';
	}
}else{
	if($uservip!==0){
		$uservip=json_decode($uservip);
		if(is_array($uservip)){
			if(in_array($renzheng,$uservip)){
				echo '{"success":false,"msg":"已经有这条认证了"}';
			}else{
				$uservip[]=$renzheng;
				$addvip=json_encode($uservip);
				$xgsql="update pengyou_user set vip='$addvip' where Id='$xgId'";
				$zxxgsql=mysqli_query($xgsql);
				echo '{"success":true,"msg":"添加成功"}';
			}
		}else{
				if($renzheng==$uservip){
					echo '{"success":false,"msg":"已经有这条认证了"}';
				}else{
					$addvip=json_encode(array($uservip,$renzheng));
					$xgsql="update pengyou_user set vip='$addvip' where Id='$xgId'";
					$zxxgsql=mysqli_query($xgsql);
					echo '{"success":true,"msg":"添加成功"}';
				}
		}
	}else{
				$xgsql="update pengyou_user set vip='$renzheng' where Id='$xgId'";
				$zxxgsql=mysqli_query($xgsql);
				echo '{"success":true,"msg":"添加成功"}';
	}
}
