<?php
	@$url=$_GET['url'];
	/*$zhurl="https://api.weibo.com/2/short_url/shorten.json?access_token=2.00Ty2DSGchUrPDa76e8c54a9wAVGQE&url_long=";
	$tjurl=$zhurl.$url;
	$html = file_get_contents($tjurl);
	$res = json_decode($html,true);
	$zz=$res['urls'][0]['url_short'];
   	echo '{"success":true,"url":"'.$zz.'"}'; */
	$zhurl="http://tools.aeink.com/tools/dwz/urldwz.php?longurl=";
	$tjurl=$zhurl.$url;
	$html = file_get_contents($tjurl);
	$res = json_decode($html,true);
	$zz=$res['ae_url'];
   	echo '{"success":true,"url":"'.$zz.'"}'; 
	
?>