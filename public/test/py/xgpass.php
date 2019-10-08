<?php
require_once('./conn/conn.php');
require_once('./conn/function.php');
session_start();
@$pengyou_user=$_SESSION['pengyou_user'];
$hello=dtcxsql('pengyou_user','username',$pengyou_user);
if(@$hello['guanli']==3){
	tishi(1,'你的账号被禁止使用,如有疑问联系管理员',3000,'zx.php');
	die();
}
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>修改密码</title>
<link href="style/yiqi.css" rel="stylesheet" type="text/css">
<link href="style/reset.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jQuery.min.js"></script>
<script type="text/javascript" src="js/yiqi.js"></script>
<?php
if(empty($pengyou_user)){
	tishi(1,'非法操作',3000,'index.php');
	die();
}
?>
</head>

<body>
	<div class="yiqi-login-head">
		<a href="index.php"><h3><span>&#8249;</span>返回</h3></a>
	</div>
	<div class="yiqi-login-content">
		<div class="yiqi-login-content-head" align="center">
				<img src="images/icon/pengyouquan1.png">
		</div>
		<div class="yiqi-login-table" align="center">
			<input type="password" placeholder="请输入原始密码" class="yiqi-login-pass-icon" id="reg-username">
			<input type="password" placeholder="请输入新密码" class="yiqi-login-pass-icon" id='reg-pass'>
			<input type="password" placeholder="请确认密码" class="yiqi-login-pass-icon" id='reg-okpass'>
			<p id="regtishi"></p>
			<button type="submit" id="Dregbut">确定</button>
		</div>
	</div>
</body>
	<script type="text/javascript" src="./js/xgpass.js"></script>
</html>
