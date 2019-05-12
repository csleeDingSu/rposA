<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1, minimum-scale=1, user-scalable=no">
<title>口令提取</title>
<script type="text/javascript" src="//lib.baomitu.com/jquery/2.2.4/jquery.min.js"></script>
<style>
blockquote, body, dd, dir, dl, fieldset, figure, form, h1, h2, h3, h4, h5, h6, hr, input, legend, menu, ol, optgroup, p, pre, tbody, td, textarea, tfoot, th, thead, ul {
	margin: 0;
	padding: 0
}

ol, ul {
	list-style-type: none;
	list-style-image: none
}

body, button, input, select, textarea {
	-ms-text-autospace: ideograph-alpha ideograph-numeric ideograph-parenthesis;
	text-autospace: ideograph-alpha ideograph-numeric ideograph-parenthesis
}

h1, h2, h3, h4, h5, h6 {
	font-weight: 400
}

* {
	-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}

body {
	background: #F6F5F7;
}

.beatHeader {
	background: #494A4D;
	height: 50px;
	width: 100%;
	position: relative;
	z-index: 1;
	overflow: hidden;
}

.beatMain {
	position: relative;
	z-index: 2;
	padding: 0 16px;

}

.beatMain .imgContainer {
	padding: 0 16px;
	margin-top: 14px;
}

.beatMain .imgContainer img {
	width: 100%;
	height: auto;
	box-shadow: 0px 3px 12px rgba(21, 0, 71, 0.16);
}

.beatMain .moonTitleContainer {
	font-size: 14px;
	color: rgba(0, 0, 0, 0.4);
	margin-bottom: 16px;
}

.beatMain .moonTitleContainer span {
	color: #FF5500;
	margin-right: 16px;
}

.beatMain .itemContent {
	font-size: 14px;
	color: rgba(0, 0, 0, 0.80);
	line-height: 21px;
	text-align: left;
	margin-bottom: 10px;
}

.beatMain .itemPrice {
	font-family: STHeitiSC-Light;
	font-size: 16px;
	color: #FF5500;
	line-height: 16.5px;
	text-align: right;
	margin-bottom: 10px;
}

.beatMain .itemTips {
	font-size: 12px;
	color: rgba(0,0,0,.4);
	text-align: center;
}

.beatWord {
	text-align: center;
}

.beatWord fieldset {
	padding: 0.8em;
	margin: 0 2px;
	border: 1px dashed #f54d23;
	background: #fff;
}

.beatWord fieldset legend {
	background: #f54d23;
	border: none;
	font-size: 0.8rem;
	line-height: 20px;
	color: #fff;
	padding: 0 4px;
}

.beatWord button {
	border: none;
	font-size: 16px;
	padding: 6px 15px;
	background: #f60;
	display: inline-block;
	margin: 10px auto;
	border-radius: 16px;
	color: #fff;
}

</style>
</head>
<body>
<div class="beatMain">
	<div class="imgContainer">
		<img id="img" src="" alt="">
	</div>
	<p class="itemContent">
		<strong class="itemPrice"></strong>
		<div id="item_title" style="font-weight: 700;font-size: 14px;margin-bottom: 5px;"></div>
	</p>
	<div class="beatWord">
		<fieldset>
			<legend id="copy_tip">长按框内>全选>复制>打开手淘</legend>
			<p id="itemWord" class="itemWord" style="font-size: 12px;">复制框内整段文字，打开「手淘」即可「领取优惠券」并购买<span id="taokey"></span></p>
		</fieldset>
		<button id="copy" type="button" data-clipboard-text="" class="itemCopy" style="display:none;">手机链接</button>
		<a id="coupons" href="" style="background: #00a1ff;border: none;font-size: 16px;padding: 6px 15px;display: inline-block;margin: 10px 4px 10px 4px;border-radius: 16px;color: #fff;text-decoration: none;">电脑链接</a>
			</div>
</div>
<script type="text/javascript" src="//lib.baomitu.com/clipboard.js/1.6.1/clipboard.min.js"></script>
<script>

function getParams(){
	var url = decodeURI(location.href);
	
  var paraString = url.substring(url.indexOf("key=") + 4, url.length);
	return paraString;
}
 
var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
var base64DecodeChars = new Array(
    -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
    -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
    -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63,
    52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1,
    -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14,
    15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1,
    -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40,
    41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);

function base64decode(str) {
    var c1, c2, c3, c4;
    var i, len, out;

    len = str.length;
    i = 0;
    out = "";
    while(i < len) {
        /* c1 */
        do {
            c1 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
        } while(i < len && c1 == -1);
        if(c1 == -1)
            break;

        /* c2 */
        do {
            c2 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
        } while(i < len && c2 == -1);
        if(c2 == -1)
            break;

        out += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4));

        /* c3 */
        do {
            c3 = str.charCodeAt(i++) & 0xff;
            if(c3 == 61)
                return out;
            c3 = base64DecodeChars[c3];
        } while(i < len && c3 == -1);
        if(c3 == -1)
            break;

        out += String.fromCharCode(((c2 & 0XF) << 4) | ((c3 & 0x3C) >> 2));

        /* c4 */
        do {
            c4 = str.charCodeAt(i++) & 0xff;
            if(c4 == 61)
                return out;
            c4 = base64DecodeChars[c4];
        } while(i < len && c4 == -1);
        if(c4 == -1)
            break;
        out += String.fromCharCode(((c3 & 0x03) << 6) | c4);
    }
    return out;
}

function getParams_(paras){
	var url = decodeURI(location.href);
	
    var paraString = url.substring(url.indexOf("?") + 1, url.length).split("&");
    var returnValue;
    for (i = 0; i < paraString.length; i++) {
        var tempParas = paraString[i].split('=')[0];
        var parasValue = paraString[i].split('=')[1];
        if (tempParas === paras)
            returnValue = parasValue;
    }
    if (typeof(returnValue) == "undefined") {
        return "";
    } else {
        return returnValue;
    }
}

$(function(){

	var key = getParams_('key');

	//get from db	
	var temp_img = '<?php echo isset($item->product_picurl) ? $item->product_picurl : env('shareproduct_img', 'https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg'); ?>';
	var temp_taokey = '<?php echo isset($item->voucher_pass) ? $item->voucher_pass : '￥K8454DFGH45H￥'; ?>';

	$('#img').attr('src', temp_img);
	$('#taokey').text(temp_taokey);
	$('#copy').attr('data-clipboard-text', temp_taokey);

	if (key.length > 0) {

		//加密
		var key =getParams();
		var json =	base64decode(key);
		var	jsObject = JSON.parse(json);	

		jsObject.Title =  decodeURI(jsObject.Title);
		$('#taokey').text('￥'+jsObject.tkl+'￥');
		$('#img').attr('src', jsObject.picture);
		$('#coupons').attr('href',jsObject.url);
		$('#copy').attr('data-clipboard-text', '￥'+jsObject.tkl+'￥');

	} else {

		//无加密
		var taowords =getParams_('taowords');
		var url = decodeURIComponent(getParams_('url'));
		var image = decodeURIComponent(getParams_('image'));
		
		if (taowords.length > 0) {
			$('#img').attr('src', image);
			$('#coupons').attr('href',url);
			$('#copy').attr('data-clipboard-text', '￥'+taowords+'￥');
			$('#taokey').text('￥'+taowords+'￥');
		}
	}	
	
})


	//复制文本
var clipboard = new Clipboard('.itemCopy');
clipboard.on('success',
function(e) {
	if (e.trigger.disabled == false || e.trigger.disabled == undefined) {
		e.trigger.innerHTML = "复制成功，打开淘宝会自动弹出口令";
		e.trigger.style.backgroundColor = "#9ED29E";
		e.trigger.style.borderColor = "#9ED29E";
		//e.clearSelection();
		e.trigger.disabled = true;
		//2秒后按钮恢复原状
		setTimeout(function() {
			e.trigger.innerHTML = "一键复制";
			e.trigger.style.backgroundColor = "#f54d23";
			e.trigger.style.borderColor = "#f54d23";
			e.trigger.disabled = false;
		},
		2000);
	}
});

clipboard.on('error',
function(e) {
	e.trigger.innerHTML = "复制失败";
	e.trigger.style.backgroundColor = "#8f8f8f";
	e.trigger.style.borderColor = "#8f8f8f";
});

$(function() {

	//UA判断
	var isShow = 0; //控制是否显示一键复制按钮
	var ua = navigator.userAgent.toLowerCase();

	if (ua.match(/iphone/i) == "iphone" || ua.match(/ipad/i) == "ipad") {

		$('#copy_tip').text("长按框内 > 拷贝 > 打开手淘");
		var iphoneInfo = ua.match(/iphone os (\d{1,})/i);
		var iosVersion = iphoneInfo[1];
		if (iosVersion >= 10 || ua.match(/ipad/i) == 'ipad') {
			$('.itemCopy').show();
		}

	} else {
		$('.itemCopy').show();
	}

	//自动选中
	var beat = document.querySelector('.beatWord');
	var word = document.querySelector('.itemWord');
	var copy = document.querySelector('.itemCopy');
	document.addEventListener("selectionchange",
	function(e) {
		window.getSelection().selectAllChildren(word);
	},
	false);

});
</script>
</body>
</html