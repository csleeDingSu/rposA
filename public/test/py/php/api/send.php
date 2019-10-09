<?PHP
function sendMsg($phone,$msg,$app_id,$app_key){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'https://api.mysubmail.com/message/send');
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POST, 1);
	$post_data = array(
		"appid" => $app_id,
		"to" => $phone,
		"content" => $msg,
		"signature" => $app_key
	);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
	$data = curl_exec($curl);
	curl_close($curl);
	return json_decode($data,true);
}

print_r(sendMsg('18680803092','【双体杯】恭喜你杨瀚淩同学，你被淘汰了，退订回N',"29931","ffb2f688d69f58e37bcb1c360eb85c80"));