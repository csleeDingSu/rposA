<!doctype html>
<?php 
	require_once("../conn/conn.php");
	require_once("../conn/function.php");
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>一奇朋友圈后台管理</title>
		<link href="../style/reset.css" rel="stylesheet" />
	  	<link href="./style/main.css" rel="stylesheet" />
		<link href="./sj/yiqi.css" rel="stylesheet" />
</head>
	<link href="./sj/main.css" rel="stylesheet" />
<?php session_start();
	@$user=$_SESSION['pengyou_user'];
	$quanxian = quanxian($user);
	if($quanxian!=1){
		
		header('Location:login.php');
		die();
	}
?>
<script type="text/javascript" src="../js/jQuery.min.js"></script>
<script type="text/JavaScript" src="./sj/yiqi.js"></script>
	
<body bgcolor="#F5F5F5" style="background:none;">
	<div id="box">
				<div class="bottom">
			<div id="left">
				<div class="touxiang" align="center">
					<!--http://q2.qlogo.cn/headimg_dl?dst_uin=330729121&spec=5-->
					<img src="../images/touxiang/20180831070543.jpg"  id="touxiang">
					<p>欢迎你<?php if(@$user){echo $user;}else{echo "游客";}?></p>
				</div>
				<div align="left" class="cebianlan">
					<ul>
						<li  onClick="Dqopen('http://www.q05.cc/')"><img src="../images/icon/zy.png"><a href="#">首页</a></li>
						<li onClick="iFrame('content.php')"><img src="../images/icon/geren2.png"><a href="#">说说管理</a></li>
						<li onClick="iFrame('usergl.php')"><img src="../images/icon/chat.png"><a href="#">用户管理</a></li>
						<li onClick="iFrame('shiminggl.php')"><img src="../images/icon/jieshao.png"><a href="#">实名审核</a></li>
						<li onClick="iFrame('shiminglm.php')"><img src="../images/icon/xg.png"><a href="#">实名栏目</a></li>
						<li onClick="iFrame('webset.php')"><img src="../images/icon/jieshao.png"><a href="#">网站设置</a></li>
					</ul>
				</div>
			</div>
			<div id="right">
				<iframe src='content.php' width='100%' height='100%' frameborder='0' name="_blank" id="iFrame-content" ></iframe>
					
			</div>
		</div>
		<div class="head">
			<h1>一奇朋友圈后台管理</h1>
			<div class="openclose" id="Cebianlan">
				<img id="xiangleftright" src="../images/icon/candan.png">
			</div>
			<div class="head-right" align="center">
				<?php 
				if($user){
						echo "<p>$user</p>";
					}else{
					echo "<p onClick=\"iFrame('./login.php')\">登录</p>";
				}
				?>
				
				<img src="../images/icon/xia.png" onclick="xialadj()">
			</div>
			<div id="head-right-xiala" align="left" style="display: none;">
				
				<ul>
					<?php
						if($user){
							echo "<li onclick=\"Dqopen('./index.php');\">后台管理</li>";
							echo "<li onClick=\"iFrame('./xgpass.php');\">修改密码</li>";
							echo "<li onClick=\"Dqopen('./zx.php');\">注销</li>";
						}else{
							header('Location:login.php');
						}
					?>
					
					
					
				</ul>
				
			</div>
		</div>

		</div>
		
</body>

	<script type="text/JavaScript" src="./sj/main.js"></script>
	<script type="text/JavaScript">
			var xialaheight = 0;
				xialadianji = byId("head-right-xiala");
				function xialadj(){
					if(xialadianji.style.display=="none"){
					   			xialadianji.style.display="block";
								xialaheight=byId("head-right-xiala").scrollHeight,
								xialadianji.style.height=0+"px";
								xialadianji.style.height=xialaheight+"px";
					   }else if(xialadianji.style.height=="0px"){
								xialadianji.style.height=xialaheight+"px";
						}else{
								xialaheight=byId("head-right-xiala").scrollHeight,
								xialadianji.style.height=0+"px";
					   }
					
				}
				

	</script>
</html>