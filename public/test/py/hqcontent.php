
<?php
require_once('./conn/conn.php');
require_once('./conn/function.php');
session_start();
@$pengyou_user=$_SESSION['pengyou_user'];
?>
<?php 
@$page=intval($_GET['page']);
@$kspage=($page-1)*10;
$jspage=10;
@$hello=dtcxsql('pengyou_user','username',"$pengyou_user");
if($hello['guanli']==3){
	echo '{"success":false,"msg":"你的账号被禁止使用,如有疑问联系管理员"}'; 
}else{
				$shenhesql='select * from pengyou_shezhi';
				$zxshenhe=mysql_query($shenhesql);
				$hqshenhe=mysql_fetch_assoc($zxshenhe);
				$shenhe=$hqshenhe['shenhe'];
				if($shenhe==1){
					$sql='select * from pengyou_content where shenhe=1 and zhiding=0 ORDER BY time desc limit '.$kspage.','.$jspage.'';
				}else{
					//$sql='select * from pengyou_content ORDER BY time desc limit '.$kspage.','.$jspage.'';
					$sql='select * from pengyou_content order by if(zhiding=1 and zhidingtime>"'.date('Y-m-d H:i').'",0,1),time desc limit '.$kspage.','.$jspage.'';
				}
					
						$zxsql=mysql_query($sql);
					$z=$jspage;
					while($hqsql=mysql_fetch_assoc($zxsql)){
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
							@$zxsql2=mysql_query($sql2);
							$zanName=array();
							while (@$hqsql2=mysql_fetch_assoc($zxsql2)){
								if(!empty($hqsql2)){
									$zanuser=$hqsql2['username'];
									@$sql3='select * from pengyou_user where username="'.$zanuser.'"';
									@$zxsql3=mysql_query($sql3);
									while (@$hqsql3=mysql_fetch_assoc($zxsql3)){
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
						$zxsql4=mysql_query($sql4);
						while(@$hqsql4=mysql_fetch_assoc($zxsql4)){
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
}
				?>