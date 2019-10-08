<?php
require_once('./conn/conn.php');
require_once('./conn/function.php');
session_start();
?>
<?php
@$ip=addslashes($onlineip);
@$Id=intval($_GET['Id']);
@$pengyou_user=$_SESSION['pengyou_user'];
@$hello=dtcxsql('pengyou_user','username',"$pengyou_user");
if($hello['guanli']==3){
	echo '{"success":false,"msg":"你的账号被禁止使用,如有疑问联系管理员"}'; 
}else{
@$pengyou_name=$_SESSION['pengyou_name'];
if($pengyou_user){
if($pengyou_name!=""){
	@$name=$_SESSION['pengyou_name'];
}else{
	@$name=$_SESSION['pengyou_user'];
}
if(!empty($Id)){
	$cxsql="select * from pengyou_zan where weiyibiaoshi = '$Id' and username = '$pengyou_user'";
	$zxcxsql=mysql_query($cxsql);
	$hqcxsql=mysql_fetch_assoc($zxcxsql);
	if($hqcxsql<1){
			$zansql="insert into pengyou_zan(ip,weiyibiaoshi,time,username) values('$ip','$Id','$time','$pengyou_user')";
			$zxsql=mysql_query($zansql);
		if($zxsql){
			echo '{"success":true,"msg":"点赞成功！","name":"'.$name.'"}';
		}else{
			echo '{"success":false,"msg":"点赞失败！"}';
		}
	}else{
		$sql="delete from pengyou_zan where weiyibiaoshi=$Id and username='$pengyou_user'";
		$zxsql=mysql_query($sql);
		$cxhqsql="select * from pengyou_zan where weiyibiaoshi = '$Id'";
		$cxzxhqsql=mysql_query($cxhqsql);
		$sz=array();
		while($hqxsql=mysql_fetch_assoc($cxzxhqsql)){
			$dzName=$hqxsql['username'];
			@$dzname=dtcxsql('pengyou_user','username',"$dzName");
			if($dzname['name']){
				$sz[]=$dzname['name'];
			}else{
				$sz[]=$hqxsql['username'];
			}
			
		};
		$sz=json_encode($sz);
		echo '{"success":"qx","msg":"取消赞成功","name":'.$sz.'}';
	}
	
}
}else{
	echo '{"success":false,"msg":"请登录账号！"}';
}
	}
?>