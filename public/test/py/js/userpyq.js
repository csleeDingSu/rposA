// JavaScript Document
			var zthight = byId('dingwei').scrollHeight,
				zwidth = byId('dingwei').scrollWidth,
				kheight = byId('dingwei').offsetHeight;
	function tcdzpl(id){
		var Zid='#pengyou-lm'+id;
		if ($(Zid).css('right')=='-150px'){
			$(Zid).css('right','0');
		}else{
			$(Zid).css('right','-150px');
		}
	}
	var tccebianlan = function(){
		var cebianlan=$('#pengyou-cebianlan'),
			xscbl=$('#pengyou-cebianlandingwei');	
		if(cebianlan.css('left')=='-300px'){
				xscbl.css('z-index','0');
		   		cebianlan.css('left','0px');
		   }else{
			   cebianlan.css('left','-300px');
			   setTimeout(function(){xscbl.css('z-index','-1');},500);
		   }
	}
	$('.pengyou-cebianlan-touxiang').click(function(){
		tccebianlan();
	});
	var tcpinglunk = function(id,px){
		if($('#pinglun-pinglun').css('display')=='none'){
			tcdzpl(px);
			$('#pinglunk').attr('plid',id);
			$('#pinglunk').attr('plpx',px);
			$('#pinglun-pinglun').css('display','block');
		}else{
			tcdzpl(px);
			$('#pinglun-pinglun').css('display','none');
		}
	}
	$('#pinglunk').keyup(function(event){
		var anxia = event.keyCode;
		if(anxia==13){
			var content = $('#pinglunk').val(),
				toId = $('#pinglunk').attr('plid'),
				paixu = $('#pinglunk').attr('plpx');
				$.post("pinglun.php", { 
					"content":content,
					"biaoshi":toId
				},
				   function(data){
					if(data.success){
					 tishi(2,data.msg,1500); // John
					 var pl = $('#sspinglun'+paixu),
						 pl1=document.createElement("div");
						pl1.className='pengyou-shuoshuo-right-pinglun-wz';
						pl1.innerHTML='<div class="pengyou-shuoshuo-right-pinglun-wz-left"><span onclick="Dqopenuser('+data.user+')">'+data.name+'</span></div><div class="pengyou-shuoshuo-right-pinglun-wz-right"><span>'+data.content+'</span></div>';
					pl.append(pl1);
					$('#pinglunk').val('');
					$('#pinglun-pinglun').css("display",'none');
					}else{
						 tishi(1,data.msg,1500,'zx.php');
						$('#pinglun-pinglun').css("display",'none');
					}
				   }, "json");
		   }
		
	});
	var dianzan = function(id,px){
		 $.get("dianzan.php", {
			 Id:id
		 },
		  function(data){
			tcdzpl(px);
			var zanlie = $('#zanlie'+px);
			if(data.success==true){
					var pl1=document.createElement("span");
					pl1.innerText=data.name;
					zanlie.append(pl1);
					if(zanlie.css("display")=='none'){
						zanlie.css("display","block")
					   }
					$('#pengyou-lm'+px).children('.pengyou-shuoshuo-right-time-lm-nr-left').children('span').text('取消');
			}else{
				tishi(1,data.msg,'login.php');
			};
			if(data.success=="qx"){
				zanlie.children('span').remove();
				var z=0;
				for(var i in data.name){
					var pl1=document.createElement("span");
					pl1.innerText=data.name[i];
					zanlie.append(pl1);
					z++;
				}
				if(z==0){
					$('#zanlie'+px).css("display",'none');
				}
				$('#pengyou-lm'+px).children('.pengyou-shuoshuo-right-time-lm-nr-left').children('span').text('赞');
			}
		  },"json");
	};
		
			var fdimg = function(Id){
			var hqzhezhao = byId('zhezhao2');
			if(hqzhezhao){
				$('#zhezhao2').remove();
				$('#pengyou-fdimg').remove();
			}else{
				var zhezhao = document.createElement('div'),
				fdimg = document.createElement('div');
				zhezhao.id='zhezhao2';
				$('#dingwei').append(zhezhao);
				fdimg.id='pengyou-fdimg';
				var imgsrc =byId('fdimg'+Id).src;
				fdimg.innerHTML='<img onclick="fdimg('+Id+')" src="'+imgsrc+'" style="width:'+zwidth+'px;" id="pyimg-'+Id+'">'
				$('#dingwei').append(fdimg);
				var pyimghight =byId('pyimg'+Id);
			}
			
		}
		var openvip=function(id){
			$("#name-vip"+id).toggle();
			
		}
$(document).ready(function(){
		var pege=1;
            $('#dingwei').scroll(function(){
				var dwzHeight = document.getElementById('dingwei').scrollHeight,
					dwSoroll= $('#dingwei').scrollTop(),
					dwHeight=parseInt($('#dingwei').css('height'));
              if(dwSoroll>=dwzHeight-dwHeight){
                var div1tem = $('#container').height();
                var str ='',
					id=$('#dingwei').attr('hello');
				pege++;
                $.ajax({
                    type:"GET",
                    url:'userpyqhq.php?page='+pege+'&&id='+id,
                    dataType:'text',
                    beforeSend:function(){
                      $('.ajax_loading').show() //显示加载时候的提示
                    },
                    success:function(ret){
							var alldiv = $(".pengyou-shuoshuo:last");
							var firstdiv = alldiv[0];
							var lastdiv = alldiv[alldiv.length-1];
							alldiv.after(ret); 
                     $('.ajax_loading').hide() //请求成功,隐藏加载提示
						$('.sltfd').click(function(){
			var hqzhezhao = byId('zhezhao2');
				var zhezhao = document.createElement('div'),
				fdimg = document.createElement('div');
				zhezhao.id='zhezhao2';
				zhezhao.style.height=zthight+'px';
				zhezhao.setAttribute("onClick", "csa()");
				$('#dingwei').append(zhezhao);
				fdimg.id='pengyou-fdimg';
				fdimg.setAttribute("onClick", "csa()");
				var imgsrc =this.src;
				fdimg.innerHTML='<img src="'+imgsrc+'" style="width:'+zwidth+'px;" onclick="wcimg()">'
				$('#dingwei').append(fdimg);
				});
                    }
                })
              }
            });

			$('.sltfd').click(function(){
			var hqzhezhao = byId('zhezhao2');
				var zhezhao = document.createElement('div'),
				fdimg = document.createElement('div');
				zhezhao.id='zhezhao2';
				zhezhao.style.height=zthight+'px';
				zhezhao.setAttribute("onClick", "csa()");
				$('#dingwei').append(zhezhao);
				fdimg.id='pengyou-fdimg';
				fdimg.setAttribute("onClick", "csa()");
				var imgsrc =this.src;
				fdimg.innerHTML='<img src="'+imgsrc+'" style="width:'+zwidth+'px;" onclick="wcimg()">'
				$('#dingwei').append(fdimg);
				});

	

});

	var userxgxingbie = function(){
		var xingbie = $('#pengyou_usergl_xingbie').val();
		 $.get("usergl_xg.php", {
			 "xingbie":xingbie
		 },
		  function(data){
			if(data.success){
				 	tishi(2,data.msg,1000,'userzl.php');
					
			}else{
				tishi(1,data.msg,1500,'userzl.php');
			}
		  },"json");
	}
	
	//用户删除自己发布的说说
	var rmvcentent = function(id,wz){
		var xingbie = $('#pengyou_usergl_xingbie').val();
		
		 $.get("rmvcontent.php", {
			 "id":id
		 },
		  function(data){
			if(data.success){
				 	tishi(2,data.msg,1000);
					$('#pengyou-content').children('.pengyou-shuoshuo')[wz].remove();
			}else{
				tishi(1,data.msg,1500);
			}
		  },"json");
	};
	var userxgqx = function(){
		if($('#yiqi-xgpass')){
			$('#yiqi-xgpass').remove();
			$('#zhezhao').remove();
			$('#zhezhao').remove();
		}
	}
var plSc = function(id){
		 $.get("scpl.php", {
			 "zjid":id
		 },
		  function(data){
			if(data.success){
				 	tishi(2,data.msg,1000);
					$('#plcaidan'+id).remove();
					$('#yiqi-xgpass').remove();
					$('#zhezhao').remove();
					$('#zhezhao').remove();
			}else{
				tishi(1,data.msg,1500);
			}
		  },"json");

}
var plshanchu = function(id){
		if(isNaN(id)){ 
			tishi(1,"小伙子 非法传参数，我要记录你ip",3000);
				   }else{
			   var Id=parseInt(id);
					cjzhezhao();
				
				   	var hello = document.createElement('div');
					   	hello.id='yiqi-xgpass';
					   	hello.setAttribute('align','center');
					   	hello.innerHTML="<div class=\"yiqi-xgpass-head\">\
			<p>评论管理</p>\
		</div>\
		<div class=\"yiqi-xgpass-dingwei\">\
			<p>你确定要删除这条评论吗</p>\
		</div>\
		<div class=\"yiqi-xgpass-bottom\">\
			<div class=\"yiqi-xgpass-bottom-left\" onClick=\"userxgqx()\"><p>取消</p></div>\
			<div class=\"yiqi-xgpass-bottom-right\" onClick=\"plSc("+id+")\"><p>确定</p></div>\
		</div>";
					   $('body').append(hello);
					    var DHeight= hello.offsetHeight;
					   var DWidth = hello.offsetWidth;
						hello.style.left=(Zwidth-DWidth)/2+"px";
	
				   }
}
var plcaidan = function(id){
	$('#plcaidan'+id).children('.pengyou-shuoshuo-pl-caidan').toggle();
}
