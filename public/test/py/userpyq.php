<!doctype html>
<?php
require_once('./conn/conn.php');
require_once('./conn/function.php');
session_start();
@$pengyou_user=$_SESSION['pengyou_user'];
$hello=dtcxsql('pengyou_user','username',$pengyou_user);
$myId=$hello['Id'];
if(@$hello['guanli']==3){
	tishi(1,'你的账号被禁止使用,如有疑问联系管理员',3000,'zx.php');
	die();
}
?>
<?php
				$shenhesql='select * from pengyou_shezhi';
				$zxshenhe=mysqli_query($shenhesql);
				$hqshenhe=mysqli_fetch_assoc($zxshenhe);
				$shenhe=$hqshenhe['shenhe'];
				@$title=$hqshenhe['title'];
				@$url=$hqshenhe['url'];
				@$qq=$hqshenhe['qq'];
				@$User=intval($_GET['id']);
				@$cxUserName=dtcxsql('pengyou_user','Id',$User);
				@$UserName=$cxUserName['username'];
				@$user_name=$cxUserName['name'];
				@$bg=$cxUserName['bg'];
				@$user_touxiang =$cxUserName['touxiang'];
				if(empty($user_name)){
					$user_name=$UserName;
				}
?>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="style/reset.css">
<link rel="stylesheet" href="style/yiqi.css">
<link rel="stylesheet" href="style/main.css">
</head>
<script type="text/javascript" src="js/jQuery.min.js"></script>
<script type="text/javascript" src="js/yiqi.js"></script>
<body id='Body'>
	<div id='box'>
		<div id='dingwei' hello='<?php echo $User;?>'>
			<div class="pengyou-head">
				<div class="pengyou-head-left"><img src="images/icon/caidan2.png" onClick="tccebianlan()"></div>
				<?php
					if($pengyou_user==$UserName){
						echo "<div class=\"pengyou-head-right\"><img src=\"images/icon/photo.png\" onClick=\"Dqopen('shuoshuo.php')\"></div>";
					}
				?>
				
			</div>
			<div class="pengyou-headimg" style="background-image:url(<?php echo $bg ?>);background-repeat:no-repeat;background-size:100% 86%;" >
				<div class="pengyou-headimg-ghbg" onClick="uploaduserbg()">
					<img src="./images/icon/tuku.png">
				</div>
				<div class="pengyou-touxiang">
					<div class="pengyou-touxiang-name" align="center">
						<p><?php echo $user_name ?></p>
					</div>
					<div class="pengyou-touxiang-img">
					<?php 
						@$pengyou_tximg=$_SESSION['pengyou_tximg'];
						if($user_touxiang){
							echo '<img src="images/touxiang/'.$user_touxiang.'" onclick="uploadtouxiang()">';
						}else{
							echo '<img src="images/icon/pengyouquan.jpg">';
						}
					?>
						
					</div>
				</div>
			</div>
			<div id="pengyou-content">
			
	<?php 			

				if($shenhe==1){
					$sql='select * from pengyou_content where shenhe=1 and username = "'.$UserName.'" ORDER BY time desc limit 10';
				}else{
					$sql='select * from pengyou_content where username = "'.$UserName.'" ORDER BY time desc limit 10';
				}
					
					$zxsql=mysqli_query($sql);
					$z=0;
					while($hqsql=mysqli_fetch_assoc($zxsql)){
						//print_r($hqsql);
						$username=$hqsql['username'];
						$content=$hqsql['content'];
						$time=$hqsql['time'];
						$weiyibiaoshi=$hqsql['Id'];
						@$hqsql1=dtcxsql(pengyou_user,username,$username);
						$name=$hqsql1['name'];
						$hqplzid=$hqsql1['Id'];
						$vip=$hqsql1['vip'];
						@$images_1=$hqsql['images_1'];
						@$images_2=$hqsql['images_2'];
						@$images_3=$hqsql['images_3'];
						@$images_4=$hqsql['images_4'];
						@$images_5=$hqsql['images_5'];
						@$images_6=$hqsql['images_6'];
						@$images_7=$hqsql['images_7'];
						@$images_8=$hqsql['images_8'];
						@$images_9=$hqsql['images_9'];
						$touxiang=$hqsql1['touxiang'];
						echo '<div class="pengyou-shuoshuo">';
						echo '<div class="pengyou-shuoshuo-left" align="center">';
						echo '<img src="images/touxiang/'.$touxiang.'">';
						echo '</div>';
						echo '<div class="pengyou-shuoshuo-right">';
						echo '<div class="pengyou-shuoshuo-right-name">';
						if($name){
							echo '<p title="" onclick="Dqopenuser('.$hqplzid.')">'.$name.'</p>';
						}else{
							echo '<p title="" onclick="Dqopenuser('.$hqplzid.')">'.$username.'</p>';
						}
						echo '<div class="pengyou-shuoshuo-right-name-vip">';
							Vip($vip,$z);
						echo '</div>';
						if($username==$pengyou_user){
							echo '<div class="pengyou-shuoshuo-caidan" onclick="rmvcentent('.$weiyibiaoshi.','.$z.')">
							</div>';
							
						}
						echo '</div>';
						echo '<div class="pengyou-shuoshuo-right-wz">';
						echo '<span>'.$content.'</span>';
						if($images_2){
							echo '<div class="pengyou-photo">';
							
						}else{
							echo '<div class="pengyou-photo-one">';
						}
							if($images_1){
								echo '<img src="images/upload/'.$images_1.'" class="sltfd">';
							}
						if($images_2){
								echo '<img src="images/upload/'.$images_2.'" class="sltfd">';
							}
						if($images_3){
								echo '<img src="images/upload/'.$images_3.'" class="sltfd">';
							}
						if($images_4){
								echo '<img src="images/upload/'.$images_4.'" class="sltfd">';
							}
						if($images_5){
								echo '<img src="images/upload/'.$images_5.'" class="sltfd">';
							}
						if($images_6){
								echo '<img src="images/upload/'.$images_6.'" class="sltfd">';
							}
						if($images_7){
								echo '<img src="images/upload/'.$images_7.'" class="sltfd">';
							}
						if($images_8){
								echo '<img src="images/upload/'.$images_8.'" class="sltfd">';
							}
						if($images_9){
								echo '<img src="images/upload/'.$images_9.'" class="sltfd">';
							}
						echo '</div>';
						echo '</div>';
						echo '<div class="pengyou-shuoshuo-right-time">';
						echo '<span>'.$time.'</span>';
						echo '<div class="pengyou-shuoshuo-right-time-lm">';
						echo '<div class="pengyou-shuoshuo-right-time-lm-nr"  id="pengyou-lm'.$z.'">';
						echo '<div class="pengyou-shuoshuo-right-time-lm-nr-left" align="center" onclick="dianzan('.$weiyibiaoshi.','.$z.')">';
						echo '<img src="images/icon/xin2.png">';
						echo '<span>赞</span>';
						echo '</div>';
						echo '<div class="pengyou-shuoshuo-right-time-lm-nr-right" align="center" onClick="tcpinglunk('.$weiyibiaoshi.','.$z.')">';
						echo '<img src="images/icon/pinglun2.png">';
						echo '<span>评论</span>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
						echo '<div class="pengyou-shuoshuo-right-time-img" onClick="tcdzpl('.$z.')">';
						echo '<img src="images/icon/pinglun.png">';
						echo '</div>';
						echo '</div>';
						echo '<div class="pengyou-shuoshuo-right-pinglun" id="sspinglun'.$z.'">';
						
							@$sql2='select * from pengyou_zan where weiyibiaoshi="'.$weiyibiaoshi.'" ORDER BY time asc';
							@$zxsql2=mysqli_query($sql2);
							$zanName=array();
							while (@$hqsql2=mysqli_fetch_assoc($zxsql2)){
								if(!empty($hqsql2)){
									$zanuser=$hqsql2['username'];
									@$sql3='select * from pengyou_user where username="'.$zanuser.'"';
									@$zxsql3=mysqli_query($sql3);
									while (@$hqsql3=mysqli_fetch_assoc($zxsql3)){
										@$zanname=$hqsql3['name'];
										@$zanId=$hqsql3['Id'];
										if(empty($zanname)){
											$zanname=$zanuser;
										}else{
											$zanname=$hqsql3['name'];
										}
										$zanName[]=$zanname;
									}
									
								}
									
							}
									if(count($zanName)>0){
										echo '<div class="pengyou-shuoshuo-right-pinglun-zan" id="zanlie'.$z.'">';
										echo '<img src="images/icon/xin.png">';
										
										foreach ($zanName as $lname){
											echo '<span>'.$lname.'</span>';
											
										
										}
										echo '</div>';
									}else{
										echo '<div class="pengyou-shuoshuo-right-pinglun-zan" id="zanlie'.$z.'" style="display:none">';
										echo '<img src="images/icon/xin.png">';
										echo '</div>';
									}
						
						$sql4='select * from pengyou_pinglun where weiyibiaoshi='.$weiyibiaoshi.' ORDER BY time asc';
						$zxsql4=mysqli_query($sql4);
						while(@$hqsql4=mysqli_fetch_assoc($zxsql4)){
							$hqname1=$hqsql4['name'];
							$hqusername1=$hqsql4['username'];
							$hqcontent=$hqsql4['content'];
							$pinglunId=$hqsql4['Id'];
							@$hqplid=dtcxsql(pengyou_user,username,$hqusername1);
							$plid=$hqplid['Id'];
							$pluser=$hqplid['username'];
							if($username==$pengyou_user){
								echo '<div class="pengyou-shuoshuo-right-pinglun-wz" onclick="plcaidan('.$pinglunId.',1)" id="plcaidan'.$pinglunId.'">';
							}elseif($hqusername1==$pengyou_user){
								echo '<div class="pengyou-shuoshuo-right-pinglun-wz" onclick="plcaidan('.$pinglunId.',2)" id="plcaidan'.$pinglunId.'">';
							}else{
								echo '<div class="pengyou-shuoshuo-right-pinglun-wz">';
							}
							echo '<div class="pengyou-shuoshuo-pl-caidan" style="display:none;">';
								echo '<div class="pl-img-dingwei">';
								echo "<img src=\"./images/icon/xx1.png\" onclick=\"plshanchu($pinglunId)\">";
							//	echo "<img src=\"./images/icon/pinglun.png\" onclick=\"plhfuser($pinglunId)\">";
								echo '</div>';
								echo '</div>';
							
							@$touser=$hqsql4['touser'];
							if(empty($touser)){
								echo '<div class="pengyou-shuoshuo-right-pinglun-wz-left">';
								echo '<span onclick="Dqopenuser('.$plid.')">'.$hqname1.'</span>';
							}else{
								@$hqname3=dtcxsql(pengyou_user,username,$touser);
								@$hqname4=$hqname3['name'];
								echo '<div class="pengyou-shuoshuo-huifu">';
								echo '<span onclick="Dqopenuser('.$$plid.')">'.$hqname1.'</span>';
								if(empty($hqname3['name'])){
									echo '<span onclick="Dqopenuser('.$plid.')">'.$touser.'</span>';
								}else{
									echo '<span onclick="Dqopenuser('.$plid.')">'.$hqname4.'</span>';
								}
							}
							echo '</div>';
							echo '<div class="pengyou-shuoshuo-right-pinglun-wz-right">';
							echo '<span>'.$hqcontent.'</span>';
							
							echo '</div>';
							echo '</div>';
						}
						echo '</div>';
						echo '</div>';
						echo '<div class="clear"></div> ';
						echo '</div>';
						$z++;
					}
				mysql_close($con);
				?>


				<div id='pinglun-pinglun' style="display: none;">
					<div class="pinglun-dingwei" align="center">
						<input type="text" placeholder="评论" maxlength="300" id="pinglunk">
					</div>
				</div>
			</div>
			<div id="zhezhao" style="display: none;"></div>
			<form action="upload_file.php" method="post"
enctype="multipart/form-data" id="touxiang-upload-form" style="display: none;">
				
			<div class='pengyou-upload-k-touxiang'>
				<div class="pengyou-upload-k-head">
					<span>更换头像</span>
				</div>
				<div class="penyou-upload-k-input" id="penyou-upload-k-input">上传头像</div>
				<div class="pengyou-upload-k-yulan">
					<?php 
					if($pengyou_tximg){
					echo '<img src="images/touxiang/'.$pengyou_tximg.'" id="pengyou-upload-img">';
						}else{
							echo '<img src="images/icon/pengyouquan.jpg" id="pengyou-upload-img">';
						}
					?>
				</div>
				<div class="pengyou-upload-k-bottom" align="center">
					<input class="vip-bg-blu2" type="submit" value="确定">
					<input class="vip-bg-red" type="button" value="取消" onclick="qxupload()">
					<input type="file" name="file" id="file" style="display: none"/> 
				</div>
			</div>
			</form>
			<form action="upload_file2.php" method="post"
enctype="multipart/form-data" id="bg-upload-form" style="display: none;">
				
			<div class='pengyou-upload-k-touxiang'>
				<div class="pengyou-upload-k-head">
					<span>更换背景</span>
				</div>
				<div class="penyou-upload-k-input" id="penyou-upload-k-input2">上传头像</div>
				
				<div class="pengyou-upload-k-bottom" align="center">
					<input class="vip-bg-blu2" type="submit" value="确定">
					<input class="vip-bg-red" type="button" value="取消" onclick="qxupload()">
					<input type="file" name="file" id="file" style="display: none"/> 
				</div>
			</div>
			</form>
		</div>
		<?php 
			require_once('cebianlan.php');
		?>
	</div>
</body>
	<script type="text/javascript" src="js/userpyq.js"></script>
	<script type="text/javascript">
			function wcimg(){
				byId('zhezhao2').remove();
				byId('pengyou-fdimg').remove();
			}
				function csa(){
					wcimg();
				}
			function imgerrorfun(){ 
				 var img=event.srcElement; 
				 img.src="images/touxiang/morentouxiang.png"; 
				 img.onerror=null;
				} 
		$('#penyou-upload-k-input').click(function(){
			$('#file').click();
		});
					$("#file").change(function (e) {
				//获取目标文件
				var file = e.target.files || e.dataTransfer.files;
				//如果目标文件存在
				if (file) {
				//定义一个文件阅读器
				var reader = new FileReader();
				//文件装载后将其显示在图片预览里
				reader.onload = function () {

				$("#pengyou-upload-img").attr("src", this.result);
				}

				//装载文件
				reader.readAsDataURL(file[0]);
				}
			});
		var qxupload = function(){
			$('#zhezhao').hide();
			$('#touxiang-upload-form').hide();
			$('#bg-upload-form').hide();
		}
		var uploadtouxiang = function(){
			$('#zhezhao').show();
			$('#touxiang-upload-form').show();
		}
		var uploaduserbg = function(){
			$('#zhezhao').show();
			$('.pengyou-headimg-ghbg').children('img').show();
			$('#bg-upload-form').show();
		}
		$('#penyou-upload-k-input2').click(function(){
			$('#file').click();
		});
	</script>
</html>