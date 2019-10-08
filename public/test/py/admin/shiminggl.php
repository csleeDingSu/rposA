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
		$zxsql1=mysql_query($sql1);
		$hqsql1=mysql_fetch_assoc($zxsql1);
		$biaoshi=$hqsql1['Id'];
	}
	@$saixuan=intval($_GET['sx']);
?>
<script type="text/javascript" src="../js/jQuery.min.js"></script>
<script type="text/JavaScript" src="./js/yiqi.js"></script>
<body bgcolor="#F5F5F5" style="background:none;">
	<div class="box">
		<div class="head">
			<div class="lanmu-deleteall" onclick="zscall()"><p>删除选中</p></div>
			<div class="lanmu-tianjia" onclick="Dqopen('content.php?sx=1')"><p>筛选未审核</p></div>
		</div>
			<div id="lanmu-content">
			
				<?php
				if($hqsql1['guanli']==1){
					if($saixuan){
						$sql="select * from pengyou_shiming where shenhe=0 ORDER BY time desc limit $page,20";	
					}else{
						$sql="select * from pengyou_shiming ORDER BY time desc limit $page,20";	
					}
					
				$zxsql=mysql_query($sql);
				$i=0;
				echo "<div class=\"lanmu-content\" id=\"daohang-buttom-0\">";
						echo "<div class=\"lanmu-head\" align=\"center\" onClick=\"daohangss(0)\"><h1>管理</h1></div>";
						echo "<div class=\"lanmu-table\">";
						echo "<table width=\"98%\">";
						echo "<tr bgcolor=\"#f5f5f5\" height=\"50px\">";
						echo "<td width=\"5%\" class=\"yiqi-xuanzhe\"><input type=\"checkbox\" id=\"allcheckbox0\" onclick=\"ckAll(0)\" /></td>";
						if($hqsql1['guanli']==1){
							echo "<td width=\"10%\">用户</td>";
						}
						echo "<td width=\"40%\">发布内容</td>";
						echo "<td width=\"40%\">图片</td>";
						echo "<td width=\"20%\">发布时间</td>";
						echo "<td width=\"20%\">操作</td>";
						echo "</tr>";
						if($hqsql1['guanli']==1){
							while($hqsql=mysql_fetch_assoc($zxsql)){
								@$lmid=$hqsql['Id'];
								@$xbiaoshi=$hqsql['username'];
								$sql2="select * from pengyou_user where username='$xbiaoshi'";
								@$zxsql2=mysql_query($sql2);
								@$hqsql2=mysql_fetch_assoc($zxsql2);
								@$username=$hqsql2['username'];
								@$userid=$hqsql2['Id'];
								@$img_1=$hqsql['images_1'];
								@$img_2=$hqsql['images_2'];
									@$content=htmlentities($hqsql['content']);
									@$cxtime=htmlentities($hqsql['time']);
									@$shenhe=$hqsql['shenhe'];
									echo "<tr id='z$lmid'>";
									echo "<td  class=\"yiqi-xuanzhe\"><input type=\"checkbox\" class=\"js-check$i\" value=\"$lmid\"/></td>";
									echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$xbiaoshi\"></td>";
									echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$content\"></td>";
									echo "<td class=\"lanmu-input\">";
										if($img_1){
											echo "<img src=\"../images/shiming/$img_1\" class=\"sltfd\" style=\"width:50px;height:50px;\">";
										}
										if($img_2){
											echo "<img src=\"../images/shiming/$img_2\" class=\"sltfd\" style=\"width:50px;height:50px;\">";
										}
									echo "</td>";
									echo "<td class=\"lanmu-input\"><p>$cxtime</p></td>";
									echo "<td id=\"table-input\">";
								if($shenhe==0){
									echo "<input type=\"submit\" value=\"未审核\" onClick=\"smshenhe($lmid)\" class='bg-hui' id=\"shenhe$lmid\">";
								}else{
									echo "<input type=\"submit\" value=\"已审核\" onClick=\"smshenhe($lmid)\" class='bg-blu' id=\"shenhe$lmid\">";
								}
								
								echo "<input type=\"submit\" value=\"删除\" onClick=\"shimingsc($lmid)\" class='bg-red'>";
									
								echo "</td>";
							echo "</tr>";
							}
						}else{
								header('Location:login.php');
						}
					
							$pages=$getpage-1;
							$pagex=$getpage+1;
							if($pages<1){
								$pages=1;
							}elseif($pagex<1){
								$pagex=1;
							}
							$page_sql="select count(*) from pengyou_shiming";			
							@$pagejg_sql=mysql_fetch_array(mysql_query($page_sql));
							$zpage=ceil($pagejg_sql[0]/$pageYi);//总页数
							if($zpage!=0){
								if($getpage>$zpage){
									
										echo "<script type=\"text/javascript\">";
										echo "tishi(1,'没有这一页哦，我得拿个小本子记下来',2000,'content.php');";
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