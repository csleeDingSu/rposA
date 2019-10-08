<?php require_once("../conn/conn.php");?>
<?php require_once("../conn/function.php");?>
<?php
	session_start();
	@$user=$_SESSION['pengyou_user'];
	@$quanxian =quanxian($user);
	if($user==""){
		echo '<meta charset="utf-8">';
		echo '<link href="./sj/yiqi.css" rel="stylesheet" />';
		echo '<script type="text/JavaScript" src="../js/yiqi.js"></script>';
		echo '<body></body>';
		echo '<script type="text/javascript">';
		echo 'tishi(1,"非法操作已记录ip地址",3000);';
	 echo '</script>';
	}else{
		@$lmid=intval($_POST['lmid']);
		@$userid=intval($_GET['userid']);
		@$shimingid=intval($_GET['shiming']);
		if($quanxian==1){
			if(@$lmid){
				$sql="delete from pengyou_content where Id=$lmid";
				$zxsql=mysqli_query($sql);
				if($zxsql){
					echo '{"success":true,"msg":"删除成功"}';
				}else{
					echo '{"success":false,"msg":"栏目删除失败"}'; 
				}

			}elseif($userid){
				$sql="delete from pengyou_user where Id=$userid";
				$zxsql=mysqli_query($sql);
				if($zxsql){
					echo '{"success":true,"msg":"删除成功"}';
				}else{
					echo '{"success":false,"msg":"用户删除失败"}'; 
				}
			}
			if($shimingid){
				$sql="delete from pengyou_shiming where Id=$shimingid";
				$zxsql=mysqli_query($sql);
				if($zxsql){
					echo '{"success":true,"msg":"删除成功"}';
				}else{
					echo '{"success":false,"msg":"用户删除失败"}'; 
				}
			}
		}else{
			header('Location:login.php');
			
			
		}
		
		
	}
	
	



	

?>