// JavaScript Document
/*开源qq330729121*/
	var Zheight=document.documentElement.scrollHeight;
	var Zwidth = document.documentElement.scrollWidth;
	var Kheight = document.documentElement.clientHeight;
			function shanchutishi(){
				
					var zhezhao = document.getElementById("zhezhao");
					var tishik = document.getElementById("tishik");
				if(zhezhao){
					document.body.removeChild(zhezhao);
					
					document.body.removeChild(tishik);
					
				}
						if(arguments[0]){
					   		window.location.href=arguments[0];
					   }
					
						
			}
			/*弹出提示框
			img=1是错误图片
			img=2是正确图片
			weizhi是文字说明
			time是持续时间
			*/
				function tishi(img,wenzi,time){
					var zhezhao = document.createElement("div");
				   zhezhao.id="zhezhao";
				   zhezhao.style.height=Zheight+"px";
				   document.body.appendChild(zhezhao);
				var tishik = document.createElement("div");
				   	tishik.id="tishik";
				   	tishik.innerHTML="<div class=\"tsk-img\" align=\"center\">\
		<img src=\"images/icon/"+img+".png\"></div>\
		<div align=\"center\">\
			<p id=\"tsk-p\">"+wenzi+"</p>\
			</div>";
				   document.body.appendChild(tishik);
				    var DHeight= tishik.offsetHeight;
				   var DWidth = tishik.offsetWidth;
				   tishik.style.top=(Kheight-DHeight)/2+"px";	
				    tishik.style.left=(Zwidth-DWidth)/2+"px";	
					if(arguments[3]){
					   var url =arguments[3];
					   }else{
						   var url = "";
					   }
				   setTimeout("shanchutishi('"+url+"')",time);
				}

	function byId(id){
			return typeof(id) ==="string"?document.getElementById(id):id;
		}
	function Newopen(url){
		window.open(url);
	}
	function Dqopen(url){
		window.location.replace(url);
	}