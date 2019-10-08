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
		@$xuanzhe=intval($_POST['xuanzhe']);
		@$paixu=intval($_POST['xuhao']);
		@$url=addslashes($_POST['url']);
		@$ico=addslashes($_POST['ico']);
		@$title=addslashes($_POST['title']);
		@$content=addslashes($_POST['content']);
		if($url){		
		
			if (!isset($xuanzhe) || empty($xuanzhe) ||
				!isset($title) || empty($title)
				){
				$raoguojs="insert into yiqi_feifa(ip,time,content) value('$ip','$time','绕过前端添加子栏目数据')";
				mysql_query($raoguojs);
				echo '<meta charset="utf-8">';
				echo '<link href="./sj/yiqi.css" rel="stylesheet" />';
				echo '<script type="text/JavaScript" src="../js/yiqi.js"></script>';
				echo '<body></body>';
				echo '<script type="text/javascript">';
				echo 'tishi(1,"非法操作已记录ip地址",3000);';
				echo '</script>';
			}else{

				$sql="insert into daohang(leibie,url,ico,title,content,paixu) values($xuanzhe,'$url','$ico','$title','$content',$paixu)";
				$zxsql=mysql_query($sql);
				if($zxsql){
					echo '{"success":true,"msg":"添加成功"}';
				}else{
					echo '{"success":false,"msg":"添加失败"}'; 

					}
		
			}	
		}else{
			if (!isset($title) || empty($title)){
				$raoguojs="insert into yiqi_feifa(ip,time,content) value('$ip','$time','绕过前端添加主栏目数据')";
				mysql_query($raoguojs);
				echo '<meta charset="utf-8">';
				echo '<link href="./sj/yiqi.css" rel="stylesheet" />';
				echo '<script type="text/JavaScript" src="../js/yiqi.js"></script>';
				echo '<body></body>';
				echo '<script type="text/javascript">';
				echo 'tishi(1,"非法操作已记录ip地址",3000);';
				echo '</script>';
			}else{
				$sql="insert into leibie(title,xuhao) values('$title',$paixu)";
				$zxsql=mysql_query($sql);
				if($zxsql){
					echo '{"success":true,"msg":"添加成功"}';
				}else{
					echo '{"success":false,"msg":"添加失败"}'; 

					}
			
		

			}
		
		}
		
		
		
	}