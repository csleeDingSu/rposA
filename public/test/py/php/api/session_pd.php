<?php 
	session_start();
	@$pengyou_id=$_SESSION['pengyou_id'];
	@$pengyou_user=$_SESSION['pengyou_user'];
?>
<?php
	if (!isset($pengyou_id) || empty($pengyou_user) ||
   !isset($pengyou_user) || empty($pengyou_user)
   ){
		echo '{"success":false,"msg":"哟哟切克闹"}';
   }else{
	   echo '{"success":true,"msg":"好的呢"}';
   }
	
?>
