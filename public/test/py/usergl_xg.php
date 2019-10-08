<?php 
require_once("./conn/conn.php");
require_once("./conn/function.php");
session_start();
?>
<?php
@$ip=addslashes($onlineip);
@$xingbie=intval($_GET["xingbie"]);
@$Id=intval($_POST["id"]);
@$neirong = addslashes($_POST["neirong"]);
@$user=$_SESSION['pengyou_user'];
if(!empty($user)|| isset($user)){
	if($xingbie){
			if($xingbie==1){
				$xgsql="update pengyou_user set xinbie='$xingbie' where username='$user'";
							$zxxgsql=mysqli_query($xgsql);
							if($zxxgsql){
								echo '{"success":true,"msg":"修改成功"}';

						}else{
								echo '{"success":false,"msg":"修改失败"}';
							}
			}else{
				$xgsql="update pengyou_user set xinbie=0 where username='$user'";
							$zxxgsql=mysqli_query($xgsql);
							if($zxxgsql){
								echo '{"success":true,"msg":"修改成功"}';
						}else{
								echo '{"success":false,"msg":"修改失败"}';
							}
			};
		}
	if($Id==0){
		$xgsql="update pengyou_user set name='$neirong' where username='$user'";
					$zxxgsql=mysqli_query($xgsql);
					if($zxxgsql){
						echo '{"success":true,"msg":"修改成功"}';
						
				}else{
						echo '{"success":false,"msg":"修改失败"}';
					}
	}elseif($Id==1){
		
		if(is_numeric($neirong)){
			if($neirong<100 && $neirong>0){
			$xgsql="update pengyou_user set age='$neirong' where username='$user'";
					$zxxgsql=mysqli_query($xgsql);
				if($zxxgsql){
						echo '{"success":true,"msg":"修改成功"}';
						
				}else{
						echo '{"success":false,"msg":"修改失败"}';
					}
				}else{
					echo '{"success":false,"msg":"年龄大小不符合规范"}';
			}
		}else{
			echo '{"success":false,"msg":"需要填写数字哦"}';
		}
		
	}elseif($Id==3){
		if(is_numeric($neirong)){
			if(strlen($neirong)>11){
				echo '{"success":false,"msg":"请填写正常的联系方式"}';
			}else{
			$xgsql="update pengyou_user set qq='$neirong' where username='$user'";
					$zxxgsql=mysqli_query($xgsql);
				if($zxxgsql){
						echo '{"success":true,"msg":"修改成功"}';
				}else{
						echo '{"success":false,"msg":"修改失败"}';
					}
			}
		}else{
			echo '{"success":false,"msg":"需要填写数字哦"}';
		}
	}elseif($Id==4){
		if(is_numeric($neirong)){
			if(strlen($neirong)>11){
				echo '{"success":false,"msg":"请填写正常的联系方式"}';
			}else{
			$xgsql="update pengyou_user set phone='$neirong' where username='$user'";
					$zxxgsql=mysqli_query($xgsql);
				if($zxxgsql){
						echo '{"success":true,"msg":"修改成功"}';
				}else{
						echo '{"success":false,"msg":"修改失败"}';
					}
			}
		}else{
			echo '{"success":false,"msg":"需要填写数字哦"}';
		}
	}elseif($Id==5){
		if($neirong){
			$xgsql="update pengyou_user set email='$neirong' where username='$user'";
					$zxxgsql=mysqli_query($xgsql);
				if($zxxgsql){
						echo '{"success":true,"msg":"修改成功"}';
				}else{
						echo '{"success":false,"msg":"修改失败"}';
					}

		}else{
			echo '{"success":false,"msg":"邮箱"}';
		}
	}


}else{
	echo '{"success":false,"msg":"你是不是在乱搞"}';
}
