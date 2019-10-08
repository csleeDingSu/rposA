<?php
require_once('../conn/conn.php');
require_once('../conn/function.php');
session_start();
?>
<?php
@$ip=addslashes($onlineip);
@$title=addslashes($_POST['title']);
@$url=addslashes($_POST['url']);
@$bg=addslashes($_POST['bg']);
@$qq=intval($_POST['qq']);
@$pengyou_user=$_SESSION['pengyou_user'];
$quanxian = quanxian($pengyou_user);
if($quanxian==1){
if (!isset($title) || empty($title) ||
   !isset($url) || empty($url) ||
	!isset($bg) || empty($bg)
   ){
	echo '{"success":false,"msg":"不能为空"}'; 
		
}else{
	$cripsql="update pengyou_shezhi set title='$title',url='$url',bg='$bg',qq='$qq'";
			if(mysql_query($cripsql)){
				echo '{"success":true,"msg":"设置成功"}';
			}else{
				echo '{"success":true,"msg":"设置失败"}';
			}

}
}else{
	$raoguojs="insert into pengyou_feifa(ip,time,content) value('$ip','$time','没有权限设置审核')";
			mysql_query($raoguojs);
	echo '<meta charset="utf-8">';
	echo '<link href="../style/yiqi.css" rel="stylesheet" />';
	echo '<script type="text/JavaScript" src="../js/yiqi.js"></script>';
	echo '<body></body>';
	echo '<script type="text/javascript">';
		echo 'tishi(1,"非法操作已记录ip地址",3000);';
	 echo '</script>';
}

?>