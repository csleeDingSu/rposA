<?php require_once("conn/conn.php");?>
<?php require_once("conn/function.php");?>
<?php
	session_start();
	@$pengyou_user=$_SESSION['pengyou_user'];
	@$quanxian =quanxian($user);
	if($pengyou_user==""){
		echo '<meta charset="utf-8">';
		echo '<link href="./sj/yiqi.css" rel="stylesheet" />';
		echo '<script type="text/JavaScript" src="../js/yiqi.js"></script>';
		echo '<body></body>';
		echo '<script type="text/javascript">';
		echo 'tishi(1,"非法操作已记录ip地址",3000);';
	 echo '</script>';
	}else{
		@$plid=intval($_GET['zjid']);
		@$hqzl=dtcxsql('pengyou_pinglun','Id',$plid);
		@$biaoshi=$hqzl['weiyibiaoshi'];
		@$pluser=$hqzl['username'];
		@$hqcent=dtcxsql('pengyou_content','Id',$biaoshi);
		@$centuser=$hqcent['username'];
		@$userplid=intval($_GET['uplid']);
		if($quanxian==3){
			
					echo '{"success":false,"msg":"你的账号已经被拉黑，禁止使用"}'; 

			}else{
				if($pluser==$pengyou_user){
					$sql="delete from pengyou_pinglun where Id=$plid";
						$zxsql=mysqli_query($sql);
						if($zxsql){
							echo '{"success":true,"msg":"删除成功"}';
						}else{
							echo '{"success":false,"msg":"删除失败"}'; 
						}
			
				}elseif($centuser==$pengyou_user){
					$sql="delete from pengyou_pinglun where Id=$plid";
						$zxsql=mysqli_query($sql);
						if($zxsql){
							echo '{"success":true,"msg":"删除成功"}';
						}else{
							echo '{"success":false,"msg":"删除失败"}'; 
						}
			
				}
				
				
		
		}
	}
	
	



	

?>