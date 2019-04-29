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
					<img src="<?=str_replace('_160x160.jpg', '', empty($item->product_picurl) ? env('shareproduct_img', 'https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg') : $item->product_picurl)?>">
				</a>
			</li>
			<li class="dbox">
				<div class="dbox1">
					<span>
						<h2>{{empty($item->product_name) ? env('shareproduct_content', '宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋') : $item->product_name}}</h2>
						<div class="price1">
							<h3>
								<span class="lbl">券后价</span>
								<span class="lbl_cur">￥</span>
								<span class="price2">{{number_format(empty($item->discount_price) ? env('shareproduct_pricebefore',20) : $item->discount_price,2)}} </span>
								<span class="price3">
								淘宝价￥{{number_format( empty($item->product_price) ? env('shareproduct_priceafter', 55) : $item->product_price,2)}}
								</span>
							</h3>							
						</div>
					</span>							
				</div>
			</li>
			<li class="dbox">
				
					<div class="caption_redeem_angpao">
						<span>30元现金等你拿</span>
						<img src="{{ asset('/client/images/share_product_caption_redeem_angpao.png') }}" />
					</div>
					<div id="button-wrapper">
						<img class="btn-product-details" src="{{ asset('/client/images/btn-redeem.png') }}" />
						<a class="copyBtn"> 
							<div id="btn-copy" class="btn-copy">领取优惠券</div>
						</a>
						<a href="/arcade">
							<div id="btn-voucher" class="freeVoucherBtn"><span>玩转盘拿红包</span></div>
						</a>
					</div>
				
				<h4 style="font-size: 0;">优惠券代码 <span id="cut" class="copyvoucher">{{empty($item->voucher_pass) ? "￥K8454DFGH45H￥" : $item->voucher_pass}}</span></h4>
			</li>
			<li class="dbox">
				<p class="intruction">
					活动说明：<br>
					每一次幸运转盘有99%概率赚到15元红包（可提现）<br>
					1.新人注册<span class="instruction_highlight">送2次幸运转盘（可得30元）</span><br>
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
