<?php require_once("../conn/conn.php");?>
<?php
	session_start();
	@$user=$_SESSION['user'];
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
		@$lmzid=intval($_POST['lmzid']);
		if(@$lmid){
			@$paixu=intval($_POST['paixu']);
			@$title=addslashes($_POST['title']);
			$sql="update leibie set xuhao=$paixu,title='".$title."' where Id=$lmid";
			$zxsql=mysqli_query($sql);
			if($zxsql){
			
				echo '{"success":true,"msg":"保存成功"}';
			}else{
				echo '{"success":false,"msg":"主栏目保存失败"}'; 
			}
			
		}elseif(@$lmzid){
			@$paixu=intval($_POST['paixu']);
			@$url=addslashes($_POST['url']);
			@$ico=addslashes($_POST['ico']);
			@$title=addslashes($_POST['title']);
			@$content=addslashes($_POST['content']);
			$sql="update daohang set paixu=$paixu,url='".$url."',ico='".$ico."',title='".$title."',content='".$content."' where Id=$lmzid";
			$zxsql=mysqli_query($sql);
			if($zxsql){
			
				echo '{"success":true,"msg":"保存成功"}';
			}else{
				
				echo '{"success":false,"msg":"子栏目保存失败"}'; 
			}
		}
		
		
		
		
	}
	
	



	

?>