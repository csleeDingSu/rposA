<!doctype html>
<?php require_once("../conn/conn.php");
session_start();
@$user=$_SESSION['pengyou_user'];
if($user==""){
		header('Location:login.php');
	}

?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>一奇缘分后台管理</title>
		<link href="../style/reset.css" rel="stylesheet" />
	  	<link href="./style/main.css" rel="stylesheet" />
		<link href="./sj/yiqi.css" rel="stylesheet" />
</head>
<script type="text/JavaScript" src="./js/yiqi.js"></script>
<body>
	<div id="yiqi-xgpassk">
		<div class="yiqi-login-dingwei" align="center">
			<div align="left"><h1>修改密码</h1></div>
			<div class="yiqi-login-input">
				<input type="text" placeholder="初始密码" id="js-pass">
				<p id="js-pass-p"></p>
				<input type="password" placeholder="新密码" id="js-newpass">
				<input type="password" placeholder="确认密码" id="js-okpass">
				<p id="js-newpass-p"></p>
				<input type="submit" value="确定" id="js-xgpasstj">
			</div>
		</div>
	</div>
<?php require_once("buttom.php")?>
</body>
	<script type="text/JavaScript">
		var pass = byId("js-pass"),
		newpass = byId("js-newpass"),
		okpass = byId("js-okpass"),
		newpassts = byId("js-newpass-p"),
		passts = byId("js-pass-p"),
		logintj = byId("js-xgpasstj");
	logintj.onclick=function(){
				if(pass.value=="" || newpass.value=="" || okpass.value==""){
		   	passts.innerHTML="所有需要填写的不能为空";
		   }else{
				if(newpass.value!==okpass.value){
							newpassts.innerHTML="两次密码不一致";			   
				   
				   
				   }else{
					   	if(newpass.value.length<5){
		   					newpassts.innerHTML="密码位数不足";
						}else{
							 passts.innerHTML="";
							newpassts.innerHTML="";
					   var hello = new XMLHttpRequest;
							hello.open("POST","xg.php");
							hello.setRequestHeader("Content-type","application/x-www-form-urlencoded");
							hello.send("pass=" + pass.value
										+ "&newpass=" + newpass.value
									   + "&okpass=" + okpass.value
									  );
							hello.onreadystatechange=function(){
										if(hello.readyState===4){
												if(hello.status===200){
													var fanhui = JSON.parse(hello.responseText);	
													if(fanhui.success){
													tishi(2,fanhui.msg,1500,"xzx.php");
													
													}else{
													tishi(1,fanhui.msg,1500,"xgpass.php");

													}


												}
										}
									}
					
					
				}
					   
					   
					   
					   
					   
					   
					   
					   
				   }
			   
			   
			   
			   
			 }
			   
			  
			   
			   
			   
			   
			}
	</script>
</html>