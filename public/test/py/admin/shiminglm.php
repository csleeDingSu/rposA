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
	  	<link href="./style/lanmu.css" rel="stylesheet" />
		<link href="./sj/yiqi.css" rel="stylesheet" />
</head>
<style>
	::-webkit-scrollbar{width:0px}
	body{
	overflow-y: scroll;
	-webkit-overflow-scrolling:touch;
	}	
</style>
<?php session_start();
	$pageYi=20;
	@$getpage=intval($_GET['page']);
	if($getpage=="" || $getpage<0){
		$getpage=1;
	}
	@$page=($getpage-1)*$pageYi;
	@$user=$_SESSION['pengyou_user'];
	if($user==""){
		header('Location:login.php');
	}else{
		$sql1="select * from pengyou_user where username='$user'";
		$zxsql1=mysqli_query($sql1);
		$hqsql1=mysqli_fetch_assoc($zxsql1);
		$biaoshi=$hqsql1['Id'];
	}
	@$saixuan=intval($_GET['sx']);
?>
<script type="text/javascript" src="../js/jQuery.min.js"></script>
<script type="text/JavaScript" src="./js/yiqi.js"></script>
<body bgcolor="#F5F5F5" style="background:none;">
	<div class="box">
		<div class="head">
			
			<div class="lanmu-tianjia" onclick="shimingaddlm()"><p>添加</p></div>
		</div>
			<div id="lanmu-content">
			
				<?php
				if($hqsql1['guanli']==1){
					
				$sql="select * from pengyou_renzheng";	
					
				$zxsql=mysqli_query($sql);
				$i=0;
				echo "<div class=\"lanmu-content\" id=\"daohang-buttom-0\">";
						echo "<div class=\"lanmu-head\" align=\"center\" onClick=\"daohangss(0)\"><h1>管理</h1></div>";
						echo "<div class=\"lanmu-table\">";
						echo "<table width=\"98%\">";
						echo "<tr bgcolor=\"#f5f5f5\" height=\"50px\">";
						echo "<td width=\"5%\" class=\"yiqi-xuanzhe\"><input type=\"checkbox\" id=\"allcheckbox0\" onclick=\"ckAll(0)\" /></td>";
						echo "<td width=\"10%\">实名项目名称</td>";
						echo "<td width=\"40%\">图标地址</td>";
						echo "<td width=\"40%\">背景颜色</td>";
						echo "<td width=\"20%\">操作</td>";
						echo "</tr>";
							while($hqsql=mysqli_fetch_assoc($zxsql)){
								@$lmid=$hqsql['Id'];
								@$username=htmlentities($hqsql['name']);
								@$icon=htmlentities($hqsql['icon']);
								@$color=htmlentities($hqsql['color']);
									echo "<tr id='z$lmid'>";
									echo "<td  class=\"yiqi-xuanzhe\"><input type=\"checkbox\" class=\"js-check$i\" value=\"$lmid\"/></td>";
									echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$username\"></td>";
									echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$icon\"></td>";
									echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$color\"></td>";
									echo "<td id=\"table-input\">";
								
								echo "<input type=\"submit\" value=\"保存\" onClick=\"shiminglmbc($lmid)\" class='bg-blu'>";
								echo "<input type=\"submit\" value=\"删除\" onClick=\"shimingsc($lmid)\" class='bg-red'>";
								echo "</td>";
							echo "</tr>";
							}
						
						echo "</table>";
						echo "</div></div>";
				}else{
					header('Location:login.php');
				}
				?>
	
		</div>
	</div>
	
	<?php /*require_once("buttom.php")*/?>
</body>

<script type="text/javascript" src="js/lanmu.js"></script>
<script type="text/javascript">
	function wcimg(){
				$('#zhezhao2').remove();
				$('#pengyou-fdimg').remove();
			}
				function csa(){
					wcimg();
				}
					/*全选和反选*/
						function ckAll(id){
							var check = byId("allcheckbox"+id).checked;
							var qtcheck = byId("daohang-buttom-"+id).getElementsByClassName("js-check"+id);
								id++;
							for(var i=0;i<=qtcheck.length;i++){
								qtcheck[i].checked=check;
							}
							}
			var qjurl="";
			function shengchengsrc(id){
						var wz = byId("js-shengchengwz");
						var	url="http://www.q05.cc/yuanfen/index.php?id="+id;
						var hello = new XMLHttpRequest;
							hello.open("GET","url.php?url="+url);
							hello.send();
					hello.onreadystatechange=function(){
								if(hello.readyState===4){
										if(hello.status===200){
											var fanhui = JSON.parse(hello.responseText);	
											if(fanhui.success){
												/*	wz.innerHTML="生成成功:"+fanhui.url;
														qjurl=fanhui.url;
														var yulan = byId("js-yulan");
															yulan.style.display="block";
															yulan.onclick=function(){
																Newopen(""+fanhui.url+"");
															}*/
												tishi2(2,"网址生成成功:"+fanhui.url+"",""+fanhui.url+"");
												
											}
										}
									}	
								}
			}
		function tzpage(){
				var page = byId('js-page').value;
					if(isNaN(page)){
					   tishi(1,'不是正确的页码',1500,'zlanmu.php');
					   }else{
						   Dqopen("zlanmu.php?page=" + page);
					   }
		}
</script>

</html>