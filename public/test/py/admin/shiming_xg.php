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
@$xgrz=dtcxsql('pengyou_shiming','Id',$Id);
@$xgUser=$xgrz['username'];
@$xgshenghe=$xgrz['shenghe'];
@$hqzl=dtcxsql('pengyou_user','username',$xgUser);
@$xgId=$hqzl['Id'];
$hello=dtcxsql('pengyou_user','username',$pengyou_user);
if(@$hello['guanli']==1){
	if(!empty($pengyou_user)|| isset($pengyou_user)){
		if($renzheng){
					$xgsql="update pengyou_user set vip='$renzheng' where Id='$xgId'";
								$zxxgsql=mysql_query($xgsql);
			if($renzheng==100){
				$gxsql="update pengyou_shiming set shenhe=0 where Id='$Id'";
			}else{
				$gxsql="update pengyou_shiming set shenhe=1 where Id='$Id'";
			}
					
								mysql_query($gxsql);
								if($zxxgsql){
									echo '{"success":true,"msg":"修改成功"}';
							}else{
									echo '{"success":false,"msg":"修改失败"}';
								}
				
				};
			}
		



}else{
	tishi(1,'你是不是在乱搞',3000,'zx.php');
	die();
}