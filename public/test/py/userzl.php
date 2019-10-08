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
				@$title=htmlspecialchars($hqshenhe['title']);
				@$url=htmlspecialchars($hqshenhe['url']);
				@$bg=htmlspecialchars($hqshenhe['bg']);
				@$qq=htmlspecialchars($hqshenhe['qq']);
				@$pengyou_tximg=$_SESSION['pengyou_tximg'];
				$name=htmlspecialchars($hello['name']);
				if(empty($name)){
					$name='-';
				}
			
				@$phone=htmlspecialchars($hello['phone']);
				@$email=htmlspecialchars($hello['email']);
				@$age=htmlspecialchars($hello['age']);
				@$xinbie=htmlspecialchars($hello['xinbie']);
				@$lianxi = htmlspecialchars($hello['qq']);
				if($xinbie==1){
					$xinbie='女';
				}else{
					$xinbie='男';
				}
				if(empty($phone)){
					$phone='-';
				}elseif(empty($email)){
					$email='-';
				}elseif(empty($age)){
					$age='-';
				}elseif(empty($xinbie)){
					$xinbie='-';
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
		<div id='dingwei'>
			<div class="pengyou-head">
				<div class="pengyou-head-left"><img src="images/icon/left3.png" onClick="Dqopen('index.php')"></div>
				<div class="pengyou-head-right"><img src="images/icon/photo.png" onClick="uploadtouxiang()"></div>
			</div>
			<div class="pengyou-headimg" style="background-image:url(<?php echo "'./images/touxiang/$pengyou_tximg'" ?>);background-repeat:no-repeat;background-size:100% 86%;">
				<div class="pengyou-usergl-touxiang">
					<div class="pengyou-usergl-xgimg" align="center" onClick="Dqopen('userpyq.php?id=<?php echo $myId ?>')">
						<img src="images/icon/pengyouquan4.png">
					</div>
				</div>
			</div>
			<div class="pengyou-usergl-content" align="center">
				<div class="usergl-name">
					<h1><?php echo $name; ?></h1>
				</div>
				<div class="usergl-zl-dingwei">
					<div class="usergl-zl">
						<div class="usergl-zl-left">
							<p>账号</p>
						</div>
						<div class="usergl-zl-right">
							<p><?php echo $pengyou_user; ?></p>
						</div>
					</div>
					<div class="usergl-zl"  onClick="xguserpass(0);">
						<div class="usergl-zl-left">
							<p>昵称</p>
						</div>
						<div class="usergl-zl-right">
							<p class="usergl_p_xuanze"><?php echo $name; ?></p>
						</div>
					</div>
					<div class="usergl-zl"  onClick="xguserpass(1);">
						<div class="usergl-zl-left">
							<p>年龄</p>
						</div>
						<div class="usergl-zl-right">
							<p class="usergl_p_xuanze"><?php echo $age; ?></p>
						</div>
					</div>
					<div class="usergl-zl"  onClick="xguserpass(2);">
						<div class="usergl-zl-left">
							<p>性别</p>
						</div>
						<div class="usergl-zl-right">
							<p class="usergl_p_xuanze"><?php echo $xinbie; ?></p>
						</div>
					</div>
					<div class="usergl-zl"  onClick="xguserpass(3);">
						<div class="usergl-zl-left">
							<p>QQ</p>
						</div>
						<div class="usergl-zl-right">
							<p class="usergl_p_xuanze"><?php echo $lianxi; ?></p>
						</div>
					</div>
					<div class="usergl-zl"  onClick="xguserpass(4);">
						<div class="usergl-zl-left">
							<p>手机</p>
						</div>
						<div class="usergl-zl-right">
							<p class="usergl_p_xuanze"><?php echo $phone; ?></p>
						</div>
					</div>
					<div class="usergl-zl"  onClick="xguserpass(5);">
						<div class="usergl-zl-left">
							<p>邮箱</p>
						</div>
						<div class="usergl-zl-right">
							<p class="usergl_p_xuanze"><?php echo $email; ?></p>
						</div>
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
		</div>
			
	</div>
</body>
	<script type="text/javascript" src="js/pengyou.js"></script>
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
		}
		var uploadtouxiang = function(){
			$('#zhezhao').show();
			$('#touxiang-upload-form').show();
		}
	</script>
</html>