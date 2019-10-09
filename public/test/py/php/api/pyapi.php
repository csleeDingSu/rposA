<html>
<meta charset="utf-8">
<body>
</body>
<?php

function convertUrlArray($query)
{
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}
function openId($query)
{
	$query=str_replace("callback( {","","$query");
	$query=str_replace("} );","","$query");
	$query=str_replace("\"","","$query");
    $queryParts = explode(':', $query);
    return $queryParts;
}
	$grant_type='authorization_code';
	$client_id='101516388';
	$client_secret="7265fcad1b6d92d76f8c52acf517fc15";
	$code=$_GET['code'];
	$redirect_uri=URLEncode("http://www.q05.cc/");
	$url="https://graph.qq.com/oauth2.0/token?grant_type=$grant_type&client_secret=$client_secret&code=$code&redirect_uri=$redirect_uri&client_id=$client_id";
	$html = file_get_contents($url);
	$res = convertUrlArray($html);
	$access_token=$res['access_token'];
	$url1="https://graph.qq.com/oauth2.0/me?access_token=$access_token";
	$html1 = file_get_contents($url1);
	$res1 = json_decode($html1);
	$hqIdArray=openId($html1);
	$hqId=$hqIdArray[2];
	$tzhtml="http://zhijiaoqiang.com/php/api/jieshou.php?id=$hqId&token=$access_token";
	$str = str_replace(PHP_EOL, '', $tzhtml);
	header("location:$str");
?>

</html>
