<!doctype html>
<?php
require_once("../conn/conn.php");
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>一奇缘分测试后台管理</title>
		<link href="../style/reset.css" rel="stylesheet" />
	  	<link href="./style/lanmu.css" rel="stylesheet" />
		<link href="./sj/yiqi.css" rel="stylesheet" />
</head>
<?php session_start();
	@$user=$_SESSION['user'];
	if($user==""){
		header('Location:login.php');
	}
?>
<script type="text/JavaScript" src="../js/yiqi.js"></script>
<body bgcolor="#F5F5F5" style="background:none;">
	<div class="box">
		<div class="head">
			<div class="lanmu-tianjia" onClick="xstjk()"><p>生成链接</p></div>
		</div>
			<div id="lanmu-content">
			<?php 
			/*	$sql="select * from leibie ORDER BY xuhao";
				$zxsql=mysqli_query($sql);
				$i=0;
				while($hqsql=mysqli_fetch_assoc($zxsql)){
						$dtitle=htmlentities($hqsql['title']);
						$xuhao=$hqsql['xuhao'];
						echo "<div class=\"lanmu-content\" id=\"daohang-buttom-$i\">";
						echo "<div class=\"lanmu-head\" align=\"center\">";
						echo "<h1 onClick=\"daohangss($i)\">$dtitle</h1>";
						echo "<img src=\"../images/icon/xia.png\" onClick=\"daohangss($i)\"></div>";
						echo "<div class=\"lanmu-table\">";
						echo "<table width=\"98%\">";
						echo "<tr bgcolor=\"#f5f5f5\" height=\"50px\">";
						echo "<td width=\"5%\" class=\"yiqi-xuanzhe\"><input type=\"checkbox\" id=\"allcheckbox$i\" onclick=\"ckAll($i)\" /></td>";
						echo "<td width=\"5%\">排序</td>";
						echo "<td width=\"20%\">网址</td>";
						echo "<td width=\"10%\">图标</td>";
						echo "<td width=\"10%\">标题</td>";
						echo "<td>内容</td>";
						echo "<td width=\"15%\">操作</td>";
						echo "</tr>";
						$leibie=$hqsql['Id'];
						$sql2="select * from daohang where leibie=$leibie ORDER BY paixu";
						$zxsql2=mysqli_query($sql2);
				
					while($hqsql2=mysqli_fetch_assoc($zxsql2)){
								$url=htmlentities($hqsql2['url']);
								$ico=htmlentities($hqsql2['ico']);
								$title=htmlentities($hqsql2['title']);
								$content=htmlentities($hqsql2['content']);
								$paixu = $hqsql2['paixu'];
								$lmid=$hqsql2['Id'];
							
						echo "<tr id='z$lmid'>";
						echo "<td  class=\"yiqi-xuanzhe\"><input type=\"checkbox\" class=\"js-check$i\" value=\"$lmid\"/></td>";
						echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$paixu\"></td>";
						echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$url\"></td>";
						echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$ico\"></td>";
						echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$title\"></td>";
						echo "<td class=\"lanmu-input\"><input type=\"text\" value=\"$content\"></td>";
						echo "<td id=\"table-input\"><input type=\"submit\" value=\"保存\" onClick=\"lanmubaocun($lmid)\"><input type=\"submit\" value=\"删除\" onClick=\"lanmushanchu($lmid)\"></td>";
						echo "</tr>";
					
						
					}
						echo "</table>";
						echo "</div></div>";
					$i++;
						
				}*/
			?>
				<div class="lanmu-content" id="daohang-buttom-0">
					<div class="lanmu-head" align="center" onClick="daohangss(0)"><h1>学无止境</h1><img src="../images/icon/xia.png"></div>
					<div class="lanmu-table">
						<table width="98%">
							<tr bgcolor="#f5f5f5" height="50px">
								<td width="5%" class="yiqi-xuanzhe"><input type="checkbox" /></td>
								<td width="5%">排序</td>
								<td width="20%">网址</td>
								<td width="10%">图标</td>
								<td width="10%">标题</td>
								<td>内容</td>
								<td width="15%">操作</td>
							</tr>
							<tr>
								<td  class="yiqi-xuanzhe"><input type="checkbox" checked="true" /></td>
								<td class="lanmu-input"><input type="text" value="1"></td>
								<td class="lanmu-input"><input type="text" value="http://blog.csdn.net/"></td>
								<td class="lanmu-input"><input type="text" value="images/daohang/csdn.ico"></td>
								<td class="lanmu-input"><input type="text" value="CNDS"></td>
								<td class="lanmu-input"><input type="text" value="中国最大的IT社区和服务平台"></td>
								<td id="table-input"><input type="submit" value="保存"><input type="submit" value="删除"></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
		
	
	
	<?php require_once("buttom.php")?>
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
			
			
</script>
</html>