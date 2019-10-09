<?php
require_once("../conn/conn.php");
require_once("../conn/function.php");
session_start();
?>
<?php
@$user=$_SESSION['pengyou_user'];
@$ip=addslashes($onlineip);
@$Id=intval($_GET['id']);
if (!isset($Id) || empty($Id) ||
	!isset($user) || empty($user)
   ){
		raoguo();
}else{
	@$quanxian=quanxian($user);
	if($quanxian==1){
					$fhvip=array();
					$fhdtvip=array();
					@$sql1='select * from pengyou_renzheng';
							@$zxsql1=mysqli_query($sql1);
							while(@$hqsql1=mysqli_fetch_assoc($zxsql1)){
								@$vipname=$hqsql1['name'];
								@$vipid=$hqsql1['Id'];
								$fhdtvip['Id']=$vipid;
								$fhdtvip['name']=$vipname;
								$fhvip[]=$fhdtvip;
							}
						$fhvip=json_encode($fhvip);
						echo $fhvip;
					
	}else{
		raoguo();
	}
		
	

}

?>

