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
		<link href="./style/pengyou.css" rel="stylesheet" />
		<link href="./sj/yiqi.css" rel="stylesheet" />
</head>
<?php session_start();
	@$user=$_SESSION['pengyou_user'];
	$quanxian = quanxian($user);
	if($quanxian!=1){
		
		header('Location:login.php');
		die();
	}
?>
	<?php
	if($quanxian==1){
		$sql1="select * from pengyou_shezhi";
		$zxsql1=mysqli_query($sql1);
		$hqsql1=mysqli_fetch_assoc($zxsql1);
		@$title=$hqsql1['title'];
		@$url=$hqsql1['url'];
		@$bg=$hqsql1['bg'];
		@$qq=$hqsql1['qq'];
		@$shenhe=$hqsql1['shenhe'];
	}
		
	?>
<script type="text/javascript" src="../js/jQuery.min.js"></script>
<script type="text/javascript" src="../js/yiqi.js"></script>
<body bgcolor="#F5F5F5" style="background:none;">
	<div id='box'>
		<div class="pengyou_wk">
			<div class="pengyou_wk_head" align="center"><p>设置</p></div>
			<div class="pengyou_wk_set">
				<div class="pengyou_set_input"><p>网站标题:</p><input type="text" value="<?php echo $title ?>" id='pengyou_js_title'></div>
			</div>
			<div class="pengyou_wk_set">
				<div class="pengyou_set_input"><p>网站首页:</p><input type="text" value="<?php echo $url ?>"  id='pengyou_js_url'></div>
			</div>
			<div class="pengyou_wk_set">
				<div class="pengyou_set_input"><p>首页背景:</p><input type="text" value="<?php echo $bg ?>"  id='pengyou_js_bg'></div>
			</div>
			<div class="pengyou_wk_set">
				<div class="pengyou_set_input"><p>社交账号:</p><input type="text" value="<?php echo $qq ?>"  id='pengyou_js_qq'></div>
			</div>
			<div class="pengyou_wk_set">
				<div class="pengyou_set_left"><p>开启审核模式:</p></div>
				<div class="pengyou_set_right">
					<?php 
							if($shenhe==1){
								echo "<div class=\"pengyou_openk bg-green\" id='pengyou_set_openshk'>";
								echo "<div class=\"pengyou_open_qiu-open\" id=\"pengyou_set_opensh\"></div>";
								echo "</div>";
							}else{
								echo "<div class=\"pengyou_openk\" id='pengyou_set_openshk'>";
								echo "<div class=\"pengyou_open_qiu\" id=\"pengyou_set_opensh\"></div>";
								echo "</div>";
							}
					
					?>
					
				</div>
			</div>
			<div class="pengyou_wk_set">
				<div class="pengyou_set_sut">
					<div class="pengyou_set_sut_left" align="center" id='pengyou_set_baocun'>
						<p>保存</p>
					</div>
					<div class="pengyou_set_sut_right" align="center">
						<p>取消</p>
					</div>
				</div>
			</div>
		</div>
	
	</div>
		
</body>

	<script type="text/JavaScript" src="./js/pengyou.js"></script>
	<script type="text/JavaScript">
			

	</script>
</html>