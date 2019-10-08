<?php 
	require_once('../../conn/conn.php');
	require_once('function.php');
	session_start();
	@$ip=addslashes($onlineip);
?>
<?php
/*
这样应该是很不安全的 可以传任意QQ号的openid值 当然用这个办法也是迫不得已，这个网站没有进行备案，无法申请QQ网站应用，
所以只有使用备案的域名的接口进行转接，如果有更好的办法，之后进行更换
*/
	header('Content-Type:application/json; charset=utf-8');
	@$openId=addslashes($_GET['id']);
	@$token=addslashes($_GET['token']);
	if(!empty($openId) && !empty($token))
	{
		
		$cxpassword="select * from pengyou_user where openid='$openId'";
		@$cx=mysql_query($cxpassword);
		@$row=mysql_fetch_array($cx);
		
		if(empty($row))
		{
			$url="https://graph.qq.com/user/get_user_info?access_token=$token&oauth_consumer_key=101516388&openid=$openId";
			$html=curl_get_https($url);
			
			//性别 年龄 名称 头像
			$html=json_decode($html,true);
			if($html['ret']==0){
				$xinbie=$html['gender'];
				$age=intval(date('Y'))-intval($html['year']);
				$qqname=$html['nickname'];
				function xhcxname()
				{
					$sjusername=shuiji();
					$cxuser="select * from pengyou_user where username='$sjusername'";
					@$cx1=mysql_query($cxuser);
					@$row1=mysql_fetch_array($cx1);
					if(empty($row1)){
						@$openId=addslashes($_GET['id']);
						$pass=md5("123456");
						$regsql="insert into pengyou_user(username,password,openid,xinbie,zcip,zctime) values('$sjusername','$pass','$openId','$xinbie','$ip','$time') ";
						print_r($regsql);
						  if(mysql_query($regsql)){
							$_SESSION['pengyou_user']=$sjusername;
							$_SESSION['pengyou_tximg']="morentouxiang.png";
							header("location:http://zhijiaoqiang.com/index.php");
						}  
					}else{
						xhcxname();
					}
				};
				$sjusername=addslashes($qqname);
				$cxuser="select * from pengyou_user where username='$sjusername'";
				@$cx1=mysql_query($cxuser);
				@$row1=mysql_fetch_array($cx1);
				if(empty($row1)){
					$pass=md5('123456');
					$regsql="insert into pengyou_user(username,password,openid,xinbie,zcip,zctime) values('$sjusername','$pass','$openId','$xinbie','$ip','$time') ";
					print_r($regsql);
					  if(mysql_query($regsql)){
						$_SESSION['pengyou_user']=$sjusername;
						$_SESSION['pengyou_tximg']="morentouxiang.png";
						header("location:http://zhijiaoqiang.com/index.php");
					} 
					}else{
						xhcxname();
					} 
			}
			
		}else{
			$_SESSION['pengyou_user']=$row['username'];
			$_SESSION['pengyou_tximg']=$row['touxiang'];
			header("location:http://zhijiaoqiang.com/index.php");
		}
	}else{
		echo "啧啧";
	}
	
?>
