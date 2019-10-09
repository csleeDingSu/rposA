<!doctype html>
<?php
require_once("../conn/conn.php");
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>一奇缘分后台管理</title>
		<link href="../style/reset.css" rel="stylesheet" />
	  	<link href="./style/lanmu.css" rel="stylesheet" />
		<link href="./sj/yiqi.css" rel="stylesheet" />
</head>
<?php session_start();
	$pageYi=20;
	@$getpage=intval($_GET['page']);
	if($getpage=="" || $getpage<0){
		$getpage=1;
	}
	@$page=($getpage-1)*$pageYi;
	@$user=$_SESSION['user'];
	if($user==""){
		header('Location:login.php');
	}else{
		$sql1="select * from yiqi_user where username='$user'";
		$zxsql1=mysqli_query($sql1);
		$hqsql1=mysqli_fetch_assoc($zxsql1);
		$biaoshi=$hqsql1['Id'];
	}
?>
<script type="text/JavaScript" src="./js/yiqi.js"></script>
<body bgcolor="#f5f5f5">
	<div class="box">
		<div class="head">
			<div class="lanmu-deleteall" onclick="zscall()"><p>删除选中</p></div>
			<div class="lanmu-tianjia" onClick="shengchengsrc(<?php echo $biaoshi; ?>)"><p>生成链接</p></div>
			<div class="lanmu-tianjia" onClick="Newopen('https://jq.qq.com/?_wv=1027&k=5dmtrav')"><p>点我加交流群</p></div>
		</div>
			<div id="lanmu-content">
			
				<?php
				if($hqsql1['vip']==1){
					$sql="select * from yuanfen_content ORDER BY time desc limit $page,20";	
				}else{
					$sql="select * from yuanfen_content where biaoshi=$biaoshi ORDER BY time desc limit $page,20";
				}
				$zxsql=mysqli_query($sql);
				$i=0;
				echo "<div class=\"lanmu-content\" id=\"daohang-buttom-0\">";
						echo "<div class=\"lanmu-head\" align=\"center\" onClick=\"daohangss(0)\"><h1>管理</h1></div>";
						echo "<div class=\"lanmu-table\">";
						echo "<table width=\"98%\">";
						echo "<tr bgcolor=\"#f5f5f5\" height=\"50px\">";
						echo "<td width=\"5%\" class=\"yiqi-xuanzhe\"><input type=\"checkbox\" id=\"allcheckbox0\" onclick=\"ckAll(0)\" /></td>";
						if($hqsql1['vip']==1){
							echo "<td width=\"10%\">用户</td>";
						}
						echo "<td width=\"20%\">第一个名字</td>";
						echo "<td width=\"20%\">第二个名字</td>";
						echo "<td width=\"20%\">查询时间</td>";
						echo "<td>缘分指数</td>";
						echo "<td width=\"20%\">操作</td>";
						echo "</tr>";
						if($hqsql1['vip']==1){
							while($hqsql=mysqli_fetch_assoc($zxsql)){
								@$lmid=$hqsql['Id'];
								@$xbiaoshi=$hqsql['biaoshi'];
								$sql2="select * from yiqi_user where Id=$xbiaoshi";
								$zxsql2=mysqli_query($sql2);
								$hqsql2=mysqli_fetch_assoc($zxsql2);
								@$username=$hqsql2['username'];
								if($username==""){
									$username="空";
								}
									@$myname=htmlentities($hqsql['myname']);
									@$youname=htmlentities($hqsql['youname']);
									@$cxtime=htmlentities($hqsql['time']);
									@$yuanfen=htmlentities($hqsql['yuanfen']);
									
									echo "<tr id='z$lmid'>";
									echo "<td  class=\"yiqi-xuanzhe\"><input type=\"checkbox\" class=\"js-check$i\" value=\"$lmid\"/></td>";
									echo "<td class=\"lanmu-input\"><p>$username</p></td>";
									echo "<td class=\"lanmu-input\"><p>$myname</p></td>";
									echo "<td class=\"lanmu-input\"><p>$youname</p></td>";
									echo "<td class=\"lanmu-input\"><p>$cxtime</p></td>";
									echo "<td class=\"lanmu-input\"><p>$yuanfen</p></td>";
									echo "<td id=\"table-input\"><input type=\"submit\" value=\"删除\" onClick=\"zlanmushanchu($lmid)\"></td>";
							echo "</tr>";
							}
						}else{
							while($hqsql=mysqli_fetch_assoc($zxsql)){
									@$myname=htmlentities($hqsql['myname']);
									@$youname=htmlentities($hqsql['youname']);
									@$cxtime=htmlentities($hqsql['time']);
									@$yuanfen=htmlentities($hqsql['yuanfen']);
									$lmid=$hqsql['Id'];
									echo "<tr id='z$lmid'>";
									echo "<td  class=\"yiqi-xuanzhe\"><input type=\"checkbox\" class=\"js-check$i\" value=\"$lmid\"/></td>";
									echo "<td class=\"lanmu-input\"><p>$myname</p></td>";
									echo "<td class=\"lanmu-input\"><p>$youname</p></td>";
									echo "<td class=\"lanmu-input\"><p>$cxtime</p></td>";
									echo "<td class=\"lanmu-input\"><p>$yuanfen</p></td>";
									echo "<td id=\"table-input\"><input type=\"submit\" value=\"删除\" onClick=\"zlanmushanchu($lmid)\"></td>";
							echo "</tr>";
							}
						}
					
							$pages=$getpage-1;
							$pagex=$getpage+1;
							if($pages<1){
								$pages=1;
							}elseif($pagex<1){
								$pagex=1;
							}
						if($hqsql1['vip']==1){
							$page_sql="select count(*) from yuanfen_content";
						}else{
							$page_sql="select count(*) from yuanfen_content where biaoshi=$biaoshi";
						}
							
							$pagejg_sql=mysql_fetch_array(mysqli_query($page_sql));
							$zpage=ceil($pagejg_sql[0]/$pageYi);//总页数
							if($zpage!=0){
								if($getpage>$zpage){
									
										echo "<script type=\"text/javascript\">";
										echo "tishi(1,'没有这一页哦，我得拿个小本子记下来',2000,'zlanmu.php');";
										echo "</script>";
									
								}
							}else{
									echo "你还没有数据，生成一个链接发送给好友试试吧";
								}
							echo "<tr><td colspan='7' align=\"center\">";
							echo "<div class='yiqi-page'>";
							echo "<a href=\"".$_SERVER['PHP_SELF']."?page=$pages\">&lt;</a>";
						if($zpage>3){
							if($getpage<3){
									if($getpage==1){
										
									}else{
										echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage-1)."\">".($getpage-1)."</a>";
									}
									
									echo "<a style=\"border:1px solid #45ACF7;\" href=\"".$_SERVER['PHP_SELF']."?page=".($getpage)."\">".($getpage)."</a>";
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage+1)."\">".($getpage+1)."</a>";
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage+2)."\">".($getpage+2)."</a>";
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage+3)."\">".($getpage+3)."</a>";
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage+4)."\">".($getpage+4)."</a>";
							}else{
								if(($getpage+2)<$zpage){
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage-2)."\">".($getpage-2)."</a>";
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage-1)."\">".($getpage-1)."</a>";
									echo "<a style=\"border:1px solid #45ACF7;\" href=\"".$_SERVER['PHP_SELF']."?page=".($getpage)."\">".($getpage)."</a>";
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage+1)."\">".($getpage+1)."</a>";
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage+2)."\">".($getpage+2)."</a>";
								}elseif(($getpage+1)<$zpage){
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage-2)."\">".($getpage-2)."</a>";
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage-1)."\">".($getpage-1)."</a>";
									echo "<a style=\"border:1px solid #45ACF7;\" href=\"".$_SERVER['PHP_SELF']."?page=".($getpage)."\">".($getpage)."</a>";
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage+1)."\">".($getpage+1)."</a>";
								}else{
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage-2)."\">".($getpage-2)."</a>";
									echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage-1)."\">".($getpage-1)."</a>";
									echo "<a style=\"border:1px solid #45ACF7;\" href=\"".$_SERVER['PHP_SELF']."?page=".($getpage)."\">".($getpage)."</a>";
								}
							}
						}else{
							$p=0;
							while($p<=$zpage){
								echo "<a href=\"".$_SERVER['PHP_SELF']."?page=".($getpage+$p)."\">".($getpage+$p)."</a>";
								$p++;
							}
							
						}
						
							echo "<a href=\"".$_SERVER['PHP_SELF']."?page=$pagex\">&gt;</a>";
							echo "<input type='text' id='js-page'>";
							echo "<input type='buttom' value='跳转' onclick='tzpage()'>";
							echo "一共".$zpage."页";
							echo "</div>";
							echo "</td></tr>";
						
						echo "</table>";
						echo "</div></div>";
				?>
	
		</div>
	</div>
	
	
	<?php /*require_once("buttom.php")*/?>
</body>

<script type="text/javascript" src="js/lanmu.js"></script>
<script type="text/javascript">
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