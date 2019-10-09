<?php
require_once("./conn/conn.php");
require_once("./conn/function.php");
session_start();
?>
<?php
$page=intval($_GET['page']);
$kspage=($page-1)*10;
$jspage=10;
@$pengyou_user=$_SESSION['pengyou_user'];
if($pengyou_user){
	$sql='select * from pengyou_content ORDER BY time desc limit '.$kspage.','.$jspage.'';
	$zxsql=mysqli_query($sql);
	$pcont=array();
	while($cxsql=mysqli_fetch_assoc($zxsql)){
		$zcont=array();
		$username=$cxsql['username'];
		@$images_1=$cxsql['images_1'];
		@$images_2=$cxsql['images_2'];
		@$images_3=$cxsql['images_3'];
		@$images_4=$cxsql['images_4'];
		@$images_5=$cxsql['images_5'];
		@$images_6=$cxsql['images_6'];
		@$images_7=$cxsql['images_7'];
		@$images_8=$cxsql['images_8'];
		@$images_9=$cxsql['images_9'];
		$photo=array();
		if($images_1){
			$photo[]=$images_1;
		}
		if($images_2){
			$photo[]=$images_2;
		}
		if($images_3){
			$photo[]=$images_3;
		}
		if($images_4){
			$photo[]=$images_4;
		}
		if($images_5){
			$photo[]=$images_5;
		}
		if($images_6){
			$photo[]=$images_6;
		}
		if($images_7){
			$photo[]=$images_7;
		}
		if($images_8){
			$photo[]=$images_8;
		}
		if($images_9){
			$photo[]=$images_9;
		}
		$sql1='select * from pengyou_user where username= "'.$username.'"';
		$zxsql1=mysqli_query($sql1);
		$hqsql1=mysqli_fetch_assoc($zxsql1);
		$name='';
		$vip='';
		$fbtime=$cxsql['time'];
		$content=$cxsql['content'];
		$weiyibiaoshi=$cxsql['Id'];
		if($hqsql1['name']){
			$name=$hqsql1['name'];
		}else{
			$name=$username;
		};
		if($hqsql1['vip']==0){
			$vip='0';
		}elseif($hqsql1['vip']==1){
			$vip="v1.png";
		}elseif($hqsql1['vip']==2){
			$vip="v2.png";
		};
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
										if(empty($zanname)){
											$zanname=$zanuser;
										}else{
											$zanname=$hqsql3['name'];
										}
										$zanName[]=$zanname;
									}
									
								}
									
							}
		
		$zpinglun=array();
		$sql4='select * from pengyou_pinglun where weiyibiaoshi='.$weiyibiaoshi.' ORDER BY time asc';
						$zxsql4=mysqli_query($sql4);
						while(@$hqsql4=mysqli_fetch_assoc($zxsql4)){
							$pinglun=array();
									$pinglunuser=$hqsql4['username'];
									@$sql5='select * from pengyou_user where username="'.$pinglunuser.'"';
									@$zxsql5=mysqli_query($sql5);
									while (@$hqsql5=mysqli_fetch_assoc($zxsql5)){
										@$pinglunname=$hqsql5['name'];
										if(empty($pinglunname)){
											$pinglunname=$zanuser;
										}else{
											$pinglunname=$hqsql5['name'];
										}
									}
							$hqusername1=$hqsql4['username'];
							$hqcontent=$hqsql4['content'];
							$pinglun[]=$pinglunname;
							$pinglun[]=$hqusername1;
							$pinglun[]=$hqcontent;
							$zpinglun[]=$pinglun;
						}
		
		$zcont[]=$name;
		$zcont[]=$vip;
		$zcont[]=$content;
		$zcont[]=$fbtime;
		if($zanName){
			$zcont[]=$zanName;
		}else{
			$zcont[]='';
		}
		if($photo){
			$zcont[]=$photo;
		}else{
			$zcont[]='';
		}
		if($zpinglun){
			$zcont[]=$zpinglun;
		}else{
			$zcont[]='';
		}
		
		$pcont[]=$zcont;
	};
	$fhjson=urldecode(json_encode($pcont));
	print_r($fhjson);
}

//echo '{"success":true,"msg":"成功"}';

?>