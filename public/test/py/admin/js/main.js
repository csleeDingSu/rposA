// JavaScript Document

window.onload=function(){
	/*验证登陆框*/
	var user = byId("js-user"),
		pass = byId("js-pass"),
		userts = byId("js-user-p"),
		passts = byId("js-pass-p"),
		logintj = byId("js-logintj");
	logintj.onclick=function(){
		if(user.value=="" || pass.value==""){
		   	userts.innerHTML="账号密码不能为空";
		   }else{
				/*if(user.value.length<5){
		   			userts.innerHTML="用户名位数不足";
				}else if(pass.value.length<5){
							passts.innerHTML="密码位数不足";
						 }*/
			   
			   userts.innerHTML="";
			   var hello = new XMLHttpRequest;
			   		hello.open("POST","denglu.php");
			   		hello.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			   		hello.send("user=" + user.value
							  	+ "&pass=" + pass.value
							  );
			   		hello.onreadystatechange=function(){
								if(hello.readyState===4){
										if(hello.status===200){
											var fanhui = JSON.parse(hello.responseText);	
											if(fanhui.success){
											tishi(2,fanhui.msg,1500,"./index.php");

											}else{
											tishi(1,fanhui.msg,1500,"login.php");
												
											}
											
											
										}
								}
							}
			   
			   
			   
			   
			}
	}
	
}

			function lanmushanchu(id){
				if(isNaN(id)){
				   	tishi(2,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					  parseInt(id);
					  	var hello = new XMLHttpRequest;
			   		hello.open("POST","sc.php");
			   		hello.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			   		hello.send("lmzid=" + id);
			   		hello.onreadystatechange=function(){
								if(hello.readyState===4){
										if(hello.status===200){
											var fanhui = JSON.parse(hello.responseText);	
											if(fanhui.success){
											
											document.getElementById("tr").innerText = "";
											tishi(2,fanhui.msg,1500);

											}else{
											tishi(1,fanhui.msg,3000);
												
											}
											
											
										}
								}
							}
					   
					   
					   
					   
					   
					   
					   
				   }
		}
