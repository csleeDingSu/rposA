@extends('layouts.default_useforshareproduct')

@section('title', '记得往下拉，免单等你拿！')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/share_product.css') }}" />
@endsection

@section('top-navbar')
@endsection

@section('content')

	<div class="infinite-scroll" id="product">
		<ul class="list-2">
			<li class="dbox">
				<a class="dbox0 imgBox" href="#">
					<img id="img" src="">
				</a>
			</li>
			<li class="dbox">
				<div class="dbox1">
					<span>
						<h2 id="product_name">{{empty($item->product_name) ? env('shareproduct_content', '宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋') : $item->product_name}}</h2>
						<div class="price1">
							<h3>
								<span class="lbl">券后价</span>
								<span class="lbl_cur">￥</span>
								<span id="Pay" class="price2">{{number_format(empty($item->discount_price) ? env('shareproduct_pricebefore',20) : $item->discount_price,2)}} </span>
								<span id="bonus" class="price3">
								淘宝价￥{{number_format( empty($item->product_price) ? env('shareproduct_priceafter', 55) : $item->product_price,2)}}
								</span>
							</h3>							
						</div>
					</span>							
				</div>
			</li>
			<li class="dbox">
					<div id="button-wrapper">
						<div class="caption_redeem_angpao">
							<span>15元红包等你抽</span>
							<img src="{{ asset('/client/images/share_product_caption_redeem_angpao.png') }}" />
						</div>
						<img class="btn-product-details" src="{{ asset('/client/images/btn-redeem.png') }}" />
						<a class="copyBtn"> 
							<div id="btn-copy" class="btn-copy">领取优惠券</div>
						</a>
						<a href="/intro">
							<div id="btn-voucher" class="freeVoucherBtn"><span>转盘抽奖</span></div>
						</a>
					</div>
				
				<h4 style="font-size: 0;">优惠券代码 <span id="cut" class="copyvoucher" ></span></h4>
			</li>
			<li class="dbox">
				<p class="intruction">
					活动说明：<br>
					每一局幸运转盘可抽奖15次，99%概率获得15元红包（可提现）<br>
					1.新人注册<span class="instruction_highlight">就送1局幸运转盘（免费抽奖15次）</span><br>
					2.每介绍1名好友注册挖宝网（只需注册并微信认证，非常容易介绍），你能获得1次幸运转盘。<br>
					你邀请的好友每邀请1个人，你能获得1次幸运转盘。<br>
					<span class="instruction_highlight">假如你介绍了10个好友，而每个好友也介绍10个人，你就能获得110次机会，可赚1650元。
					</span>
				</p>
			</li>
		</ul>
	</div>
	

@endsection

@section('footer-javascript')

	@parent
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script type="text/javascript" src="//lib.baomitu.com/jquery/2.2.4/jquery.min.js"></script>
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
	$('#cut').text(temp_taokey);
	$('#btn-copy').attr('data-clipboard-text', temp_taokey);

	if (key.length > 0) {

		//加密
		var key =getParams();
		console.log('key ' + key);

		var json =	base64decode(key);
		var	jsObject = JSON.parse(json);	
		console.log(jsObject);

		jsObject.Title =  decodeURI(jsObject.Title);
		// console.log(jsObject.Title);
		// $('#product_name').text(jsObject.Title);
		$('#cut').text('￥'+jsObject.tkl+'￥');
		$('#img').attr('src', jsObject.image);
		$('#coupons').attr('href',jsObject.url);
		$('#btn-copy').attr('data-clipboard-text', '￥'+jsObject.tkl+'￥');

	} else {

		//无加密
		var taowords =getParams_('taowords');
		var url = decodeURIComponent(getParams_('url'));
		var image = decodeURIComponent(getParams_('image'));
		var Title =getParams_('Title');
		var Pay =getParams_('Pay');
		var bonus =getParams_('bonus');
		
		console.log('taowords ' + taowords);
		console.log('url ' + url);
		console.log('image ' + image);
		console.log('Title ' + Title);
		console.log('Pay ' + Pay);
		console.log('bonus ' + bonus);
		
		if (taowords.length > 0) {
			$('#img').attr('src', image);
			$('#coupons').attr('href',url);
			$('#btn-copy').attr('data-clipboard-text', '￥'+taowords+'￥');
			$('#cut').text('￥'+taowords+'￥');
			$('#product_name').text(Title);
			$('#Pay').text(Pay);
			$('#bonus').text(bonus);
		}
	}	
	
})
</script>
<script>
		
		$(document).ready(function(){
			
			var clipboard = new ClipboardJS('.copyBtn', {
				target: function () {
					return document.querySelector('#cut');
				}
		        
			});

			clipboard.on('success', function (e) {
				console.log(e);
				$('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
				$('#btn-copy').css('padding-top', '0.1rem');
				$('.btn-copy').html("<p class='inner_span_copy1' style='margin-top: -0.1rem;'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");
			});

			clipboard.on('error', function (e) {
				console.log(e);
				$('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
				$('#btn-copy').css('padding-top', '0.1rem');
				$('.btn-copy').html("<p class='inner_span_copy1' style='margin-top: -0.1rem;'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");
			});

			
		})
		
	</script>
@endsection
