<?php
require_once("./conn/conn.php");
require_once("./conn/function.php");
session_start();
?>
<?php
@$ip=addslashes($onlineip);
@$user=addslashes($_POST['user']);
@$pass=md5($_POST['pass']);
@$xtime=date('Y-m-d H:i:s',strtotime("-30 min"));
if (!isset($user) || empty($user) ||
   !isset($pass) || empty($pass)
   ){
	$raoguojs="insert into pengyou_feifa(ip,time,content) value('$ip','$time','绕过前端提交数据')";
			mysqli_query($raoguojs);
	echo '<meta charset="utf-8">';
	echo '<link href="style/yiqi.css" rel="stylesheet" />';
	echo '<script type="text/JavaScript" src="js/yiqi.js"></script>';
	echo '<body></body>';
	echo '<script type="text/javascript">';
		echo 'tishi(1,"非法操作已记录ip地址",3000);';
	 echo '</script>';
}else{
			$cxlogin="select * from pengyou_user_login_info where time>='$xtime' and ip='$ip' and username='$user'";
				$zxcxlogin=mysqli_query($cxlogin);
				$cxloginsz=mysql_fetch_array($zxcxlogin);
				if($cxloginsz['cishu']>=5){
					echo '{"success":false,"msg":"错误次数超过5次已禁止登录，请30分钟后重试"}'; 
				}else{
	
	$cxpassword="select * from pengyou_user where username='$user' and password='$pass'";
	@$cx=mysqli_query($cxpassword);
	@$row=mysql_fetch_array($cx);
	$yonghu=$row['username'];
	@$yonghuname=$row['name'];
	if($yonghu){
		if($row['guanli']==3){
			echo '{"success":false,"msg":"你的账号被禁止使用,如有疑问联系管理员"}'; 
	}else{
		if($cxloginsz<1){
				$loginsb="insert into pengyou_user_login_info(username,ip,time,ok,cishu) value('$user','$ip','$time','1','0')";
				$zxloginsb=mysqli_query($loginsb);
			}else{
				$gxdl="update pengyou_user_login_info set time='$time',ok='1' where username='$user' and time>='$xtime'";
				mysqli_query($gxdl);
			}
		$cripsql="update pengyou_user set dlip='$ip',dltime='$time' where username = '$yonghu'";
			mysqli_query($cripsql);
		 $_SESSION['pengyou_user']=$row['username'];
		$_SESSION['pengyou_name']=$yonghuname;
		$_SESSION['pengyou_tximg']=$row['touxiang'];
		echo '{"success":true,"msg":"登录成功"}';
		}
	}else{
			if($cxloginsz<1){
				$loginsb="insert into pengyou_user_login_info(username,ip,time,ok,cishu) value('$user','$ip','$time','0','0')";
				$zxloginsb=mysqli_query($loginsb);
			}else{
				$gxdl="update pengyou_user_login_info set time='$time',ok='0',ip='$ip',cishu=cishu+1 where username='$user' and time>='$xtime'";
				$gengxincishu=mysqli_query($gxdl);
			}

        echo '{"success":false,"msg":"登录失败，一共五次机会哦"}'; 

	};
	
	
	
				}
}

?>

