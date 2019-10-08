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
		$finallyvip=$hqsql1['finallyvip'];
	}
	@$saixuan=intval($_GET['sx']);
?>
<script type="text/javascript" src="../js/jQuery.min.js"></script>
<script type="text/JavaScript" src="./js/yiqi.js"></script>
<body bgcolor="#F5F5F5" style="background:none;">
	<div class="box">
		<div class="head">
			<div class="lanmu-deleteall" onclick="scall()"><p>删除选中</p></div>
			<div class="lanmu-tianjia" onclick="Dqopen('content.php?sx=1')"><p>筛选已拉黑</p></div>
		</div>
			<div id="lanmu-content">
			
				<?php
				if($hqsql1['guanli']==1){
					if($saixuan){
						$sql="select * from pengyou_user where guanli=3 ORDER BY zctime desc limit $page,20";	
					}else{
						$sql="select * from pengyou_user ORDER BY zctime desc limit $page,20";	
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
						echo "<td width=\"15%\">实名认证</td>";
						echo "<td width=\"15%\">名称</td>";
						echo "<td width=\"20%\">邮箱</td>";
						echo "<td width=\"20%\">登陆ip</td>";
						echo "<td width=\"20%\">操作</td>";
						echo "</tr>";
						if($hqsql1['guanli']==1){
							while($hqsql=mysql_fetch_assoc($zxsql)){
								@$lmid=$hqsql['Id'];
								@$username=$hqsql['username'];
									@$name=htmlentities($hqsql['name']);
									if(empty($name)){
										$name='无';
									}
									@$useremail=htmlentities($hqsql['email']);
									@$dlip=$hqsql['dlip'];
									@$shiming=$hqsql['vip'];
									@$guanli=$hqsql['guanli'];
									echo "<tr id='z$lmid'>";
									echo "<td  class=\"yiqi-xuanzhe\"><input type=\"checkbox\" class=\"js-check$i\" value=\"$lmid\"/></td>";
									echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$username\"></td>";
									echo "<td class=\"lanmu-input\">";
									htvip($shiming);
									echo "</td>";
									echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$name\"></td>";
									echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$useremail\"></td>";
									echo "<td class=\"lanmu-input\"><p>$dlip</p></td>";
									echo "<td id=\"table-input\">";
									echo "<input type=\"submit\" value=\"修改密码\" onClick=\"xguserpass($lmid)\" class='bg-blu'>";
									echo "<input type=\"submit\" value=\"添加实名\" onClick=\"tjshiming($lmid)\" class='bg-gre'>";
								if($finallyvip==1){
									if($guanli==1){
										echo "<input type=\"submit\" value=\"取消管理\" onClick=\"addguanli($lmid)\" class='bg-cred'>";
									}else{
										echo "<input type=\"submit\" value=\"设置管理\" onClick=\"addguanli($lmid)\" class='bg-hui'>";
									}
									
								}	
								if($guanli==3){
									echo "<input type=\"submit\" value=\"已拉黑\" onClick=\"lahei($lmid)\" class='bg-hui' id='lahei_$lmid'>";
								}else{
									echo "<input type=\"submit\" value=\"拉黑\" onClick=\"lahei($lmid)\" class='bg-black' id='lahei_$lmid'>";
								}
								echo "<input type=\"submit\" value=\"删除\" onClick=\"usershanchu($lmid)\" class='bg-red'>";
									
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
							$page_sql="select count(*) from pengyou_user";			
							@$pagejg_sql=mysql_fetch_array(mysql_query($page_sql));
							$zpage=ceil($pagejg_sql[0]/$pageYi);//总页数
							if($zpage!=0){
								if($getpage>$zpage){
									
										echo "<script type=\"text/javascript\">";
										echo "tishi(1,'没有这一页哦，我得拿个小本子记下来',2000,'usergl.php');";
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
					/*全选和反选*/
						function ckAll(id){
							var check = byId("allcheckbox"+id).checked;
							var qtcheck = byId("daohang-buttom-"+id).getElementsByClassName("js-check"+id);
								id++;
							for(var i=0;i<=qtcheck.length;i++){
								qtcheck[i].checked=check;
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