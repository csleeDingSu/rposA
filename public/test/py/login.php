<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>登录</title>
<link href="style/yiqi.css" rel="stylesheet" type="text/css">
<link href="style/reset.css" rel="stylesheet" type="text/css">
<script src="js/jQuery.min.js"></script>
<script type="text/javascript" src="js/yiqi.js"></script>
</head>
<body>
	<div class="yiqi-login-head" style="border-bottom:none;">
	</div>
	<div class="yiqi-login-content">
		<div class="yiqi-login-content-head" align="center">
				<img src="images/icon/pengyouquan1.png">
		</div>
		<div class="yiqi-login-table" align="center">
			<input type="text" placeholder="请输入账号" class="yiqi-login-user-icon" id="yiqi-js-user" maxlength="20">
			<input type="password" placeholder="请输入密码" class="yiqi-login-pass-icon" id="yiqi-js-pass" maxlength="30">
			<p id="yiqi-js-wz"></p>
			<button type="submit" onClick="yiqilogin()">登录</button>
			<button type="submit" onClick="Dqopen('php/api/1.php')" style="margin-bottom: 15px;
	background-color: #2fd436;
    border: none;">QQ快捷登陆</button>
			<span onClick="Dqopen('./register.php')">点我注册</span><span>忘记密码？</span>
		</div>
		<!--<div class="yiqi-login-buttom" align="center">
			<div class="yiqi-login-hr"></div>
			<span>选择其他方式登录</span>
			<div class="yiqi-login-hr"></div>
			<div class="yiqi-login-buttom-icon">
				<img src="images/icon/qq.png" onclick='Dqopen("php/api/1.php")'>
				<img src="images/icon/weixin.png">
				<img src="images/icon/weibo.png">
			</div>
		</div>
		-->
	</div>
</body>
<script>
 function toLogin()
 {
   //以下为按钮点击事件的逻辑。注意这里要重新打开窗口
   //否则后面跳转到QQ登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口
   var A=window.open("php/api/1.php","TencentLogin","width=450,height=320,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
 };
 /* function hquserSession(){
	 $.get("./php/api/session_pd.php", {
		 },
		  function(data){
				if(data.success){
					Dqopen('index.php');
				}else{
					setTimeout(function(){hquserSession()},1000);
				}
		  },"json");
 };
  setTimeout(function(){hquserSession()},1000); */
</script>
</html>
