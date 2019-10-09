<?php
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
			echo '<script type="text/JavaScript" src="./js/jQuery.min.js"></script>';
			echo '<script type="text/JavaScript" src="./js/yiqi.js"></script>';
			echo '<body></body>';
			echo '<script type="text/javascript">';
			echo 'tishi('.$tubiao.',"'.$shuoming.'",'.$time.',"'.$tiaozhuan.'");';
			 echo '</script>';
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
function httishi(){
		echo '<meta charset="utf-8">';
	echo '<link href="../style/yiqi.css" rel="stylesheet" />';
	echo '<script type="text/JavaScript" src="../js/yiqi.js"></script>';
	echo '<body></body>';
	echo '<script type="text/javascript">';
		echo 'tishi(1,"非法操作,如有疑问联系管理员",3000,"../index.php");';
	 echo '</script>';
}
function panduan(){
	@session_start();
	@$user=$_SESSION['pengyou_user'];
		if($user){
			
		}else{
			 header("location:./login.php");
			die();
		}
}
//翻译意思
function cxfy($q){
			$appKey="2b1e973729b07e46";
			$salt=rand(1,10);
			$miyao ="uQxbCc3Zh2DIM5VQzQQkKRJtGqOc6PJl";
			$sign=md5($appKey.$q.$salt.$miyao);
			$url="http://openapi.youdao.com/api?q=$q&from=EN&to=zh_CHS&appKey=$appKey&salt=$salt&sign=$sign";
			$html = file_get_contents($url);
			$res = json_decode($html,true);
			@$explains=$res['basic']['explains'];
			if($explains){
				$fanyi = "";
				for($i=0;$i<count($explains);$i++){
						$fanyi=$fanyi.' '.$explains[$i];
					}
				return $fanyi=addslashes($fanyi);
				
			}
			
}

function shuiji()
{
	$ztime=date('His');
	$sjusername=rand(100000,10000000)+$ztime;
	return intval($sjusername);
}
function curl_get_https($url){
    $curl = curl_init(); // 启动一个CURL会话
    @curl_setopt($curl, CURLOPT_URL, $url);
    @curl_setopt($curl, CURLOPT_HEADER, 0);
    @curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    @curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    @curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
    @$tmpInfo = curl_exec($curl);     //返回api的json对象
    //关闭URL请求
    curl_close($curl);
    return $tmpInfo;    //返回json对象
}
/* PHP CURL HTTPS POST */
function curl_post_https($url,$data){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据，json格式
}
?>