// JavaScript Document
var Zheight=document.documentElement.scrollHeight;
	var Zwidth = document.documentElement.scrollWidth;
	var Kheight = document.documentElement.clientHeight;
var scxgk = function(){
	$('#zhezhao').remove();
	$('#yiqi-xgpass').remove();
}
var zhidingqx =function(id){
	if(isNaN(id)){ tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					 var Id=parseInt(id);
				  $.post("zhiding.php", {
					"Id":Id
				},
				   function(data){
					 if(data.success){ 
						 tishi(2,data.msg,1500,'content.php');
						 scxgk();
					 }else{
						 tishi(1,data.msg,1500,'content.php');
						 scxgk();
					 }
					 
				   }, "json");
	 }
};
var zhidingtj = function(id){
	if(isNaN(id)){ tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					 var Id=parseInt(id),
						zhidingtime=byId('xgpass-value').value;
				  $.post("zhiding.php", {
					"zhidingtime": zhidingtime,
					"Id":Id
				},
				   function(data){
					 if(data.success){ 
						 tishi(2,data.msg,1500);
						 scxgk();
						 if($('#zhiding'+Id).attr('class')=='bg-blu'){
						   	$('#zhiding'+Id).attr('class','bg-gre');
							$('#zhiding'+Id).attr('value','已置顶');
						   }else{
							   $('#zhiding'+Id).attr('class','bg-gre');
							   $('#zhiding'+Id).attr('value','置顶');
						   }
					 }else{
						 tishi(1,data.msg,1500);
						 scxgk();
					 }
					 
				   }, "json");
	 }
};
var zhiding = function(id){
	if(isNaN(id)){ tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					var Id=parseInt(id);
					cjzhezhao();
					var hello = document.createElement('div');
					   	hello.id='yiqi-xgpass';
					   	hello.setAttribute('align','center');
					   	hello.innerHTML="<div class=\"yiqi-xgpass-head\">\
			<p>置顶消息</p>\
		</div>\
		<div class=\"yiqi-xgpass-dingwei\">\
			<input type=\"text\" placeholder=\"置顶截止时间,如2018-09-06 15:30\" id=\"xgpass-value\" value=\"2018-10-10 15:30\">\
		</div>\
		<div class=\"yiqi-xgpass-bottom\">\
			<div class=\"yiqi-xgpass-bottom-left\" onClick=\"userxgqx()\"><p>取消</p></div>\
			<div class=\"yiqi-xgpass-bottom-right\" onClick=\"zhidingtj("+Id+")\"><p>确定</p></div>\
		</div>";
					   $('body').append(hello);
					    var DHeight= hello.offsetHeight;
					   var DWidth = hello.offsetWidth;
						hello.style.left=(Zwidth-DWidth)/2+"px";	
					  
				   }
};
var shenhe = function(id){
	if(isNaN(id)){ tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					 var Id=parseInt(id);
				  $.ajax({
                    type:"GET",
                    url:'shenhe.php?Id='+Id,
                    dataType:'text',
                    success:function(ret){
						if($('#shenhe'+Id).attr('class')=='bg-blu'){
						   	$('#shenhe'+Id).attr('class','bg-hui');
							$('#shenhe'+Id).attr('value','未审核');
						   }else{
							   $('#shenhe'+Id).attr('class','bg-blu');
							   $('#shenhe'+Id).attr('value','已审核');
						   }
							
						
                    }
                });
	 }
}
//拉黑
var lahei = function(id){
if(isNaN(id)){ tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					   var Id=parseInt(id);
					   $.ajax({
                    type:"GET",
                    url:'lahei.php?Id='+Id,
                    dataType:'json',
                    success:function(ret){
						if(ret.success){
							if($('#lahei_'+Id).attr('class')=='bg-black'){
						   	$('#lahei_'+Id).attr('class','bg-hui');
							$('#lahei_'+Id).attr('value','已拉黑');
						   }else{
							   $('#lahei_'+Id).attr('class','bg-black');
							 	$('#lahei_'+Id).attr('value','拉黑');
						   }
						   }else{
							   tishi(1,ret.msg,1500);
						   }
						
                    }
                });
				   }
		
}
//设置管理
	var addguanli = function(Id){
		$.ajax({
			type:"GET",
			url:'setguanli.php?Id='+Id,
			dataType:'json',
			success:function(ret){
				if(ret.success){
					tishi(2,ret.msg,1500,'usergl.php');
				   }else{
					   tishi(1,ret.msg,1500);
				   }
				
			}
		});
	}
//实名审核删除
 function shimingsc(id){
	if(isNaN(id)){ tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					 var Id=parseInt(id);
				 $.ajax({
                    type:"GET",
                    url:'sc.php?shiming='+Id,
                    dataType:'json',
                    success:function(ret){
						if(ret.success){
							tishi(2,ret.msg,1500,'usergl.php');
						   }else{
							   tishi(1,ret.msg,1500,'usergl.php');
						   }
						
                    }
                });
				   }
 }
//用户删除
function usershanchu(id){
	if(isNaN(id)){ tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					 var Id=parseInt(id);
				 $.ajax({
                    type:"GET",
                    url:'sc.php?userid='+Id,
                    dataType:'json',
                    success:function(ret){
						if(ret.success){
							tishi(2,ret.msg,1500,'usergl.php');
						   }else{
							   tishi(1,ret.msg,1500,'usergl.php');
						   }
						
                    }
                });
				   }
}
//修改用户密码弹窗
	var xguserpass = function(id){
		if(isNaN(id)){ tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					var Id=parseInt(id);
					cjzhezhao();
					var hello = document.createElement('div');
					   	hello.id='yiqi-xgpass';
					   	hello.setAttribute('align','center');
					   	hello.innerHTML="<div class=\"yiqi-xgpass-head\">\
			<p>修改密码</p>\
		</div>\
		<div class=\"yiqi-xgpass-dingwei\">\
			<input type=\"text\" placeholder=\"请输入修改的密码\" id=\"xgpass-value\">\
		</div>\
		<div class=\"yiqi-xgpass-bottom\">\
			<div class=\"yiqi-xgpass-bottom-left\" onClick=\"userxgqx()\"><p>取消</p></div>\
			<div class=\"yiqi-xgpass-bottom-right\" onClick=\"userxgpass("+Id+")\"><p>确定</p></div>\
		</div>";
					   $('body').append(hello);
					    var DHeight= hello.offsetHeight;
					   var DWidth = hello.offsetWidth;
						hello.style.left=(Zwidth-DWidth)/2+"px";	
					  
				   }
	}
//修改用户密码
	var userxgpass = function(id){
		if(isNaN(id)){
				   	tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					 var Id=parseInt(id),
						 pass=$('#xgpass-value').val();
					  	
				$.post("admin_xg.php", {
					"pass": pass,
					"id":Id
				},
				   function(data){
					 if(data.success){ 
						 tishi(2,data.msg,1500);
						 scxgk();
					 }else{
						 tishi(1,data.msg,1500);
						 scxgk();
					 }
					 
				   }, "json");
				   }
	}


//取消修改密码
	var userxgqx = function(){
		if($('#yiqi-xgpass')){
			$('#yiqi-xgpass').remove();
			$('#zhezhao').remove();
		}
	}
	//实名认证提交
	var shimingtj = function(id){
		var renzheng = $('#pengyou_usergl_xingbie').val();
		$.get("shiming_xg.php", {
			 "renzheng":renzheng,
			"id":id
		 },
		  function(data){
			if(data.success){
				 	tishi(2,data.msg,1000,'shiminggl.php');
					
			}else{
				tishi(1,data.msg,1500);
			}
		  },"json");
	}
	//实名认证添加提交
	var shimingadd = function(id){
		var renzheng = $('#pengyou_usergl_xingbie').val();
		$.get("shiming_add.php", {
			 "renzheng":renzheng,
			"id":id
		 },
		  function(data){
			if(data.success){
				 	tishi(2,data.msg,1000,'usergl.php');
					
			}else{
				tishi(1,data.msg,1500,'usergl.php');
			}
		  },"json");
	}
	//审核实名认证
var smshenhe = function(id){
		if(isNaN(id)){ 
			tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
		}else{
			var Id=parseInt(id);
			cjzhezhao();
			$.get("hqshiming.php", {
					"id":Id
			},
			function(data){
				nshuzu = "";
					for(var i=0;i<data.length;i++){
						var zuhe = " <option value ="+data[i]['Id']+">"+data[i]['name']+"</option>\\";
						nshuzu=nshuzu+zuhe;			//写到这里了 吃饭去了
						
					}
					console.log(nshuzu);
				var hello = document.createElement('div');
					   	hello.id='yiqi-xgpass';
					   	hello.setAttribute('align','center');
					   	hello.innerHTML="<div class=\"yiqi-xgpass-head\">\
			<p>认证管理</p>\
		</div>\
		<div class=\"yiqi-xgpass-dingwei\">\
			<select id=\"pengyou_usergl_xingbie\">\
				"+nshuzu+"\
				<option value =\"100\">取消认证</option>\
			</select>\
		</div>\
		<div class=\"yiqi-xgpass-bottom\">\
			<div class=\"yiqi-xgpass-bottom-left\" onClick=\"userxgqx()\"><p>取消</p></div>\
			<div class=\"yiqi-xgpass-bottom-right\" onClick=\"shimingtj("+Id+")\"><p>确定</p></div>\
		</div>";
					   $('body').append(hello);
					    var DHeight= hello.offsetHeight;
					   var DWidth = hello.offsetWidth;
						hello.style.left=(Zwidth-DWidth)/2+"px";	
			},"json");
				   	
		}
				  
	}
	//添加实名认证
	var tjshiming = function(id){
		if(isNaN(id)){ 
			tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
		}else{
			var Id=parseInt(id);
			cjzhezhao();
			$.get("hqshiming.php", {
					"id":Id
			},
			function(data){
				nshuzu = "";
					for(var i=0;i<data.length;i++){
						var zuhe = " <option value ="+data[i]['Id']+">"+data[i]['name']+"</option>\\";
						nshuzu=nshuzu+zuhe;			//写到这里了 吃饭去了
						
					}
					console.log(nshuzu);
				var hello = document.createElement('div');
					   	hello.id='yiqi-xgpass';
					   	hello.setAttribute('align','center');
					   	hello.innerHTML="<div class=\"yiqi-xgpass-head\">\
			<p>认证管理</p>\
		</div>\
		<div class=\"yiqi-xgpass-dingwei\">\
			<select id=\"pengyou_usergl_xingbie\">\
				"+nshuzu+"\
				<option value =\"100\">取消认证</option>\
			</select>\
		</div>\
		<div class=\"yiqi-xgpass-bottom\">\
			<div class=\"yiqi-xgpass-bottom-left\" onClick=\"userxgqx()\"><p>取消</p></div>\
			<div class=\"yiqi-xgpass-bottom-right\" onClick=\"shimingadd("+Id+")\"><p>确定</p></div>\
		</div>";
					   $('body').append(hello);
					    var DHeight= hello.offsetHeight;
					   var DWidth = hello.offsetWidth;
						hello.style.left=(Zwidth-DWidth)/2+"px";	
			},"json");
				   	
		}
	}
	//保存实名项目
	var shiminglmbc = function(id){
		var name=$('#z'+id).children('td:eq(1)').find('input').val();
		var icon=$('#z'+id).children('td:eq(2)').find('input').val();
		var color=$('#z'+id).children('td:eq(3)').find('input').val();
		$.post("shiminglmbc.php", {
					"Id":id,
					"name":name,
					"icon":icon,
					"color":color
				},
				   function(data){
					 if(data.success){ 
						 tishi(2,data.msg,1500);
						  setTimeout("$('#tishik').remove();",1500);
					 }else{
						 tishi(1,data.msg,1500);
							setTimeout("$('#tishik').remove();",1500);
					 }
					 
		}, "json");
	};
	var szfdwidth = function(){
		var imgWidth=parseInt($('#fdimgA').css('width'));
		var imgwidth=(Zwidth-imgWidth)/2;
		$('#fdimgA').css('left',imgwidth);
	}
	//实名删除
	var shimingsc = function(Id){
		$.get("shimingremove.php", {
					"id":Id
			},
			function(data){
					if(data.success){ 
						 tishi(2,data.msg,1500,'shiminglm.php');
						  setTimeout("$('#tishik').remove();",1500);
					 }else{
						 tishi(1,data.msg,1500);
							setTimeout("$('#tishik').remove();",1500);
					 }
			},"json");	
	};
	//取消实名添加
	var qxsmadd = function(){
		$('#zhezhao').remove();
		$('#yiqi-addWind').remove();
	};
	//实名项目添加提交
	var smxmadd = function(){
		var name = $('.yiqi-addWind-content').children('input:eq(0)').val(),
			icon = $('.yiqi-addWind-content').children('input:eq(1)').val(),
			color = $('.yiqi-addWind-content').children('input:eq(2)').val();
		$.post("shiminglmtj.php", {
					"name":name,
					"icon":icon,
					"color":color
				},
				   function(data){
					 if(data.success){ 
						qxsmadd();
						 tishi(2,data.msg,1500,'shiminglm.php');
						  setTimeout("$('#tishik').remove();",1500);
					 }else{
						 tishi(1,data.msg,1500);
							setTimeout("$('#tishik').remove();",1500);
					 }
					 
		}, "json");
	};
	//添加实名认证
	var shimingaddlm =function(){
		var smtjk="<div id=\"zhezhao\"></div>\
		<div id=\"yiqi-addWind\">\
		<div class=\"yiqi-addWind-head\" align=\"center\">\
			<p>添加</p>\
		</div>\
		<div class=\"yiqi-addWind-content\">\
			<input type=\"text\" placeholder=\"认证名称\">\
			<input type=\"text\" placeholder=\"认证图标\">\
			<input type=\"text\" placeholder=\"认证颜色\">\
			<div class=\"yiqi-addWind-content-btn\">\
				<input type=\"button\" value=\"确定\" onclick=\"smxmadd()\">\
				<input type=\"button\" value=\"取消\" onclick=\"qxsmadd()\">\
			</div>\
		</div>\
	</div>";
		$('body').append(smtjk);
		var addKwidth=(Zwidth-parseInt($('#yiqi-addWind').css('width')))/2,
			addHight=(Kheight-parseInt($('#yiqi-addWind').css('height')))/2;
		$('#yiqi-addWind').css('left',addKwidth+'px')
		$('#yiqi-addWind').css('top',addHight+'px')
		console.log(addHight);
	}
	$('.sltfd').click(function(){
				var zhezhao = document.createElement('div'),
				fdimg = document.createElement('div');
				zhezhao.id='zhezhao2';
				zhezhao.setAttribute("onClick", "csa()");
				$('.box').append(zhezhao);
				fdimg.id='pengyou-fdimg';
				fdimg.setAttribute("onClick", "csa()");
				var imgsrc =this.src;
				fdimg.innerHTML='<img src="'+imgsrc+'" onclick="wcimg()" id="fdimgA">';
				$('.box').append(fdimg);
		szfdwidth();
				});

	

	
	
	
//以下内容为早期使用代码 节约时间直接使用
				function jiluqx(){
					var xsk = byId("yiqi-tijiaok");
					 xsk.style.display="none";
				}
			
/*主栏目删除*/
			function zlanmushanchu(id){
				if(isNaN(id)){ tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					 var Id=parseInt(id);
					  	var hello = new XMLHttpRequest;
			   		hello.open("POST","sc.php");
			   		hello.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			   		hello.send("lmid=" + Id);
			   		hello.onreadystatechange=function(){
								if(hello.readyState===4){
										if(hello.status===200){
											var fanhui = JSON.parse(hello.responseText);	
											if(fanhui.success){
											tishi(2,fanhui.msg,1500,"content.php");

											}else{
											tishi(1,fanhui.msg,3000);
												
											}
											
											
										}
								}
							}
   
				   }
		}	


			
				/*子栏目删除*/
			function lanmushanchu(id){
				if(isNaN(id)){ tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					   var Id=parseInt(id);
					  	var hello = new XMLHttpRequest;
			   		hello.open("POST","sc.php");
			   		hello.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			   		hello.send("lmzid=" + Id);
			   		hello.onreadystatechange=function(){
								if(hello.readyState===4){
										if(hello.status===200){
											var fanhui = JSON.parse(hello.responseText);	
											if(fanhui.success){
											var trs =byId("z"+Id);
									
											trs.innerHTML = "";
											tishi(2,fanhui.msg,1500);

											}else{
											tishi(1,fanhui.msg,3000);
												
											}
											
											
										}
								}
							}
   
				   }
		}	
/*主栏目保存*/
					function zlanmubaocun(id){
								if(isNaN(id)){ tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
								   }else{
									  parseInt(id);
										var hqinput = byId("z"+id).getElementsByTagName("input"),
											paixu=hqinput[1].value,
											title=hqinput[2].value;
										var hello = new XMLHttpRequest;
									hello.open("POST","bc.php");
									hello.setRequestHeader("Content-type","application/x-www-form-urlencoded");
									hello.send("lmid=" + id
											  +"&paixu=" + paixu
											  +"&title=" + title
											  );
									hello.onreadystatechange=function(){
												if(hello.readyState===4){
														if(hello.status===200){
															var fanhui = JSON.parse(hello.responseText);	
															if(fanhui.success){

															tishi(2,fanhui.msg,1500);

															}else{
															tishi(1,fanhui.msg,3000,"zlanmu.php");

															}


														}
												}
											}

								   }
		}





/*子栏目保存*/
					function lanmubaocun(id){
				if(isNaN(id)){ tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
					  parseInt(id);
					 	var hqinput = byId("z"+id).getElementsByTagName("input"),
							paixu=hqinput[1].value,
							url=hqinput[2].value,
							ico=hqinput[3].value,
							title=hqinput[4].value,
							content=hqinput[5].value;
					  	var hello = new XMLHttpRequest;
			   		hello.open("POST","bc.php");
			   		hello.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			   		hello.send("lmzid=" + id
							  +"&paixu=" + paixu
							  +"&url=" + url
							  +"&ico=" + ico
							  +"&title=" + title
							  +"&content=" + content
							  );
			   		hello.onreadystatechange=function(){
								if(hello.readyState===4){
										if(hello.status===200){
											var fanhui = JSON.parse(hello.responseText);	
											if(fanhui.success){
										
											tishi(2,fanhui.msg,1500);

											}else{
											tishi(1,fanhui.msg,3000,"lanmu.php");
												
											}
											
											
										}
								}
							}
   
				   }
		}
	/*主栏目删除所有*/
		function zscall(){
					var daohangquanbu = byId("lanmu-content").getElementsByClassName("lanmu-content"),
						daohanglen = daohangquanbu.length;
					for(var d=0;d<=daohanglen;d++){
							var qtcheck = byId("daohang-buttom-"+d).getElementsByClassName("js-check"+d);
							var z=0;
						while(qtcheck[z]){
							if(qtcheck[z].checked){
										var id=qtcheck[z].value;
										
												var hello = new XMLHttpRequest;
													hello.open("POST","sc.php");
													hello.setRequestHeader("Content-type","application/x-www-form-urlencoded");
													hello.send("lmid=" + id);
													hello.onreadystatechange=function(){
																if(hello.readyState===4){
																		if(hello.status===200){
																			var fanhui = JSON.parse(hello.responseText);	
																			if(fanhui.success){
																			tishi(2,fanhui.msg,1500,"content.php");

																			}else{
																			tishi(1,fanhui.msg,3000);

																			}


																		}
																}
															}
								
								
								
							}
							z++;
							  } 
						}

					}




/*子栏目删除所有*/
		function scall(){
					var daohangquanbu = byId("lanmu-content").getElementsByClassName("lanmu-content"),
						daohanglen = daohangquanbu.length;
					for(var d=0;d<=daohanglen;d++){
							var qtcheck = byId("daohang-buttom-"+d).getElementsByClassName("js-check"+d);
							var z=0;
						while(qtcheck[z]){
							if(qtcheck[z].checked){
										var id=qtcheck[z].value;
										
												var hello = new XMLHttpRequest;
													hello.open("GET","sc.php?userid="+id);
													hello.send();
													hello.onreadystatechange=function(){
																if(hello.readyState===4){
																		if(hello.status===200){
																			var fanhui = JSON.parse(hello.responseText);	
																			if(fanhui.success){
																			tishi(2,fanhui.msg,1500,"usergl.php");

																			}else{
																			tishi(1,fanhui.msg,3000);

																			}


																		}
																}
															}
								
								
								
							}
							z++;
							  } 
						}

					}
		/*主栏目添加*/
				
				function zjilutj(){
							var xuhao = byId("yiqi-js-xuhao").value,
								title = byId("yiqi-js-title").value;
						if(title==""){
						   		tishi(1,"标题都不填，添加个啥",2000);
						   }else{
							var tj = new XMLHttpRequest;
								tj.open("POST","tianjia.php");
								tj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
								tj.send("xuhao=" + xuhao
										+"&title=" + title
									   );
								tj.onreadystatechange=function(){
																if(tj.readyState===4){
																		if(tj.status===200){
																			var fanhui = JSON.parse(tj.responseText);	
																			if(fanhui.success){
																			tishi(2,fanhui.msg,1500,"zlanmu.php");

																			}else{
																			tishi(1,fanhui.msg,3000);

																			}


																		}
																}
															}
					
					
					
					
					
					
					
					
						   }
					
					
					
					
				}






/*子栏目添加*/
				
				function jilutj(){
							var xuhao = byId("yiqi-js-xuhao").value,
								url = byId("yiqi-js-url").value,
								ico = byId("yiqi-js-ico").value,
								title = byId("yiqi-js-title").value,
								content = byId("yiqi-js-content").value,
								xuanzhe = byId("yiqi-js-xuanze").value;
						if(title==""){
						   		tishi(1,"标题都不填，添加个啥",2000);
						   }else{
							var tj = new XMLHttpRequest;
								tj.open("POST","tianjia.php");
								tj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
								tj.send("xuhao=" + xuhao
									   	+"&url=" + url
										+"&ico=" + ico
										+"&title=" + title
										+"&content=" + content
										+"&xuanzhe=" + xuanzhe
									   );
								tj.onreadystatechange=function(){
																if(tj.readyState===4){
																		if(tj.status===200){
																			var fanhui = JSON.parse(tj.responseText);	
																			if(fanhui.success){
																			tishi(2,fanhui.msg,1500,"lanmu.php");

																			}else{
																			tishi(1,fanhui.msg,3000);

																			}


																		}
																}
															}
					
					
					
					
					
					
					
					
						   }
					
					
					
					
				}