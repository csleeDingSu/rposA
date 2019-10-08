<!doctype html>
<?php require_once("../conn/conn.php");?>
<html>
<?php require_once("head.php")?>
<script type="text/JavaScript" src="./js/yiqi.js"></script>
<body>
	<div id="yiqi-xgpassk">
		<div class="yiqi-login-dingwei" align="center">
			<div align="left"><h1>注册</h1></div>
			<div class="yiqi-login-input">
				<input type="text" placeholder="用户名" id="js-user">
				<p id="js-user-p"></p>
				<input type="password" placeholder="密码" id="js-pass">	
				<input type="text" placeholder="邮箱" id="js-email">
				<p id="js-pass-p"></p>
				<input type="submit" value="确定" id="js-zctj" onClick="zcuser()">
			</div>
			<span style="font-size: 15px; color:#2C80D8; cursor: pointer;" onClick="Dqopen('./login.php')">已有账号点我登录</span>
		</div>
		
	</div>
<?php require_once("buttom.php")?>
</body>
	<script type="text/JavaScript">
					function zcuser(){
							var user = byId("js-user").value,
								pass = byId("js-pass").value,
								email = byId("js-email").value;
						if(user=="" || pass=="" || email==""){
						   		tishi(1,"信息没有填写完不能注册哦",1500);
						   }else{
							   var hello = new XMLHttpRequest;
							   		hello.open("POST","zc.php");
							   		hello.setRequestHeader("Content-type","application/x-www-form-urlencoded");
									hello.send("user=" + user
												+ "&pass=" + pass
											   +"&email=" + email
											  );
									hello.onreadystatechange=function(){
												if(hello.readyState===4){
														if(hello.status===200){
															var fanhui = JSON.parse(hello.responseText);	
															if(fanhui.success){
															tishi(2,fanhui.msg,1500,"./index.php");

															}else{
															tishi(1,fanhui.msg,1500,"zhuce.php");

															}


														}
												}
											}
			   
							   
						   }
						
					}
	</script>
</html>