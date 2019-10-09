<?php
global $HTTP_SERVER_VARS;
$HTTP_SERVER_VARS = $_SERVER;

	function dtcxsql($table,$ziduan,$neirong){//单条查询
		@$sql1='select * from '.$table.' where '.$ziduan.'="'.$neirong.'"';
		@$zxsql1=mysqli_query($sql1);
		@$hqsql1=mysqli_fetch_assoc($zxsql1);	
		return($hqsql1);
	}
	function xhcxsql($table,$ziduan,$neirong,$huoqu){//循环查询
		@$sql1='select * from '.$table.' where '.$ziduan.'="'.$neirong.'"';
		@$zxsql1=mysqli_query($sql1);
		while (@$hqsql1=mysqli_fetch_assoc($zxsql1)){
			return($hqsql1[$huoqu]);
		}
	}

  	date_default_timezone_set('PRC');
    $time=addslashes(date('Y-m-d H:i:s'));

if(getenv('HTTP_CLIENT_IP')) {
    $onlineip = getenv('HTTP_CLIENT_IP');
} elseif(getenv('HTTP_X_FORWARDED_FOR')) {
    $onlineip = getenv('HTTP_X_FORWARDED_FOR');
} elseif(getenv('REMOTE_ADDR')) {
    $onlineip = getenv('REMOTE_ADDR');
} else {
    $onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
}
  
	function tishi($tubiao,$shuoming,$time,$tiaozhuan){
			echo '<meta charset="utf-8">';
			echo '<link href="./style/yiqi.css" rel="stylesheet" />';
			echo '<script type="text/JavaScript" src="./js/yiqi.js"></script>';
			echo '<body></body>';
			echo '<script type="text/javascript">';
			echo 'tishi('.$tubiao.',"'.$shuoming.'",'.$time.',"'.$tiaozhuan.'");';
			 echo '</script>';
	}

	function Vip($vip,$id){
					$vip=json_decode($vip);
				if(is_array($vip)){
					for($i=0;$i<count($vip);$i++){
						@$sql1='select * from pengyou_renzheng where Id ='.$vip[$i].'';
						@$zxsql1=mysqli_query($sql1);
						while(@$hqsql1=mysqli_fetch_assoc($zxsql1)){
							@$vipname=$hqsql1['name'];
							@$vipicon=$hqsql1['icon'];
							@$vipcolor=$hqsql1['color'];
								echo '<img src="'.$vipicon.'" onclick="Newopenvip('.$id.','.$vip[$i].',\''.$vipcolor.'\',\''.$vipname.'\')">';
						};
					}
						echo '<div class="pengyou-shuoshuo-vip" align="center" style="display: none;" id="name-vip'.$id.'">';
						echo '<span class="vip-wz-wht"></span>';
						echo '</div>';
				}else{
					@$sql1='select * from pengyou_renzheng where Id ='.$vip.'';
					@$zxsql1=mysqli_query($sql1);
					while(@$hqsql1=mysqli_fetch_assoc($zxsql1)){
						@$vipname=$hqsql1['name'];
						@$vipicon=$hqsql1['icon'];
						@$vipcolor=$hqsql1['color'];
							echo '<img src="'.$vipicon.'" onclick="openvip('.$id.','.$vip.')">';
							echo '<div class="pengyou-shuoshuo-vip" align="center" style="background-color:'.$vipcolor.';display: none;" id="name-vip'.$id.'">';
							echo '<span class="vip-wz-wht">'.$vipname.'</span>';
							echo '</div>';
					};

				}
				
	}
function cxvip($vip){
	$vip=json_decode($vip);
	if (in_array("5", $vip))
	{
		return 5;
	}
	elseif(in_array("6", $vip)){
		return 6;
	}else 
	{
		return false;
	}
}
function quanxian($user){
		$sql1="select * from pengyou_user where username='$user'";
		$zxsql1=mysqli_query($sql1);
		$hqsql1=mysqli_fetch_assoc($zxsql1);
		return($hqsql1['guanli']);
}
function raoguo(){
	@$raoguojs="insert into pengyou_feifa(ip,time,content) value('$ip','$time','绕过前端提交数据')";
			mysqli_query($raoguojs);
	echo '<meta charset="utf-8">';
	echo '<link href="style/yiqi.css" rel="stylesheet" />';
	echo '<script type="text/JavaScript" src="js/yiqi.js"></script>';
	echo '<body></body>';
	echo '<script type="text/javascript">';
		echo 'tishi(1,"非法操作已记录ip地址",3000);';
	 echo '</script>';
}
function htvip($vip){
	$vip=json_decode($vip);
				if(is_array($vip)){
					for($i=0;$i<count($vip);$i++){
						@$sql1='select * from pengyou_renzheng where Id ='.$vip[$i].'';
						@$zxsql1=mysqli_query($sql1);
						while(@$hqsql1=mysqli_fetch_assoc($zxsql1)){
							@$vipname=$hqsql1['name'];
							@$vipicon=$hqsql1['icon'];
							@$vipcolor=$hqsql1['color'];
							echo '<img src="'.$vipicon.'" class="htvipimg">';
								//echo '<img src="'.$vipicon.'" onclick="Newopenvip('.$id.','.$vip[$i].',\''.$vipcolor.'\',\''.$vipname.'\')">';
						};
					}
				}else{
					@$sql1='select * from pengyou_renzheng where Id ='.$vip.'';
					@$zxsql1=mysqli_query($sql1);
					while(@$hqsql1=mysqli_fetch_assoc($zxsql1)){
						@$vipname=$hqsql1['name'];
						@$vipicon=$hqsql1['icon'];
						@$vipcolor=$hqsql1['color'];
							echo '<img src=".'.$vipicon.'" class="htvipimg">';
					};

				}
				if($vip==0){
					echo "无";
				}
};
function httishi(){
		echo '<meta charset="utf-8">';
	echo '<link href="../style/yiqi.css" rel="stylesheet" />';
	echo '<script type="text/JavaScript" src="../js/yiqi.js"></script>';
	echo '<body></body>';
	echo '<script type="text/javascript">';
		echo 'tishi(1,"非法操作,如有疑问联系管理员",3000,"../index.php");';
	 echo '</script>';
}

?>