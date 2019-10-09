<?php
require_once('./conn/conn.php');
require_once('./conn/function.php');
session_start();
?>

<?php 
@$ip=addslashes($onlineip);
@$content=addslashes($_POST['content']);
@$touser=intval($_POST['biaoshi']);
@$pengyou_user=$_SESSION['pengyou_user'];
@$pengyou_name=$_SESSION['pengyou_name'];
@$hello=dtcxsql('pengyou_user','username',"$pengyou_user");
if($hello['guanli']==3){
	tishi(1,"你的账号被禁止使用,如有疑问联系管理员",1500,'zx.php'); 
}else{
	if($pengyou_user){
	if($pengyou_name!=""){
		@$name=$_SESSION['pengyou_name'];
	}else{
		@$name=$_SESSION['pengyou_user'];
	}
		$Id=$hello['Id'];
	$plsql="insert into pengyou_pinglun(name,content,time,ip,weiyibiaoshi,username) values('$name','$content','$time','$ip','$touser','$pengyou_user') ";
	$zxsql=mysqli_query($plsql);
	if($zxsql){
		echo '{"success":true,"msg":"评论成功！","name":"'.$name.'","content":"'.$content.'","user":"'.$pengyou_user.'","Id":"'.$Id.'"}';
	}else{
		echo '{"success":false,"msg":"评论失败！"}';

	}
	}else{
		echo '{"success":false,"msg":"请登录账号！"}';
	}

}










?>