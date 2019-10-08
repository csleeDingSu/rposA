<?php 
require_once("../conn/conn.php");
session_start();
?>
<?php
$pass=md5($_POST["pass"]);
$newpass=md5($_POST["newpass"]);
@$okpass=md5($_POST["okpass"]);
	if(!empty($pass)|| !empty($newpass) || !empty($okpass)){
		
		if(strlen($_POST["newpass"]) > 5 ){

		
			if($newpass==$okpass){
				@$user=$_SESSION['user'];
				$cxsql="select * from yiqi_user where username='$user'";
				$zxsql=mysql_query($cxsql);
				$hqsz=mysql_fetch_array($zxsql);
				$ypass=$hqsz['password'];
				if($pass==$ypass){
					$xgsql="update yiqi_user set password='$newpass' where username='$user'";
					$zxxgsql=mysql_query($xgsql);
					if($zxxgsql){
						echo '{"success":true,"msg":"修改成功"}';
						
					}
					
					
				}else{
					echo '{"success":false,"msg":"原密码不一致"}';
					
				}
				
				
				
			}else{
				echo '{"success":false,"msg":"两次密码不一致"}';
			}
		}else{
			echo '{"success":false,"msg":"密码长度小于六位"}';
		}
		
	}else{
		echo '{"success":false,"msg":"信息填写不完全"}';
	}



?>